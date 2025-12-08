<?php

namespace Modules\Auth\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Http\Requests\User\StoreUserRequest;
use Modules\Auth\Http\Requests\User\UpdateUserRequest;

class UserService
{
    public function handle() {}

  /**
     * Get paginated users with search, role filter, and dynamic per_page.
     */
    public function paginate(array $filters = []): LengthAwarePaginator
    {
        $perPage = max(1, (int) ($filters['per_page'] ?? 20));

        return User::query()
            ->with('roles:id,name')
            ->when(!empty($filters['search']), fn($q) => $q->where(function ($query) use ($filters) {
                $search = $filters['search'];
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            }))
            ->when(!empty($filters['role']), fn($q) => $q->role($filters['role']))
            ->latest()
            ->paginate($perPage == 'all' ? 1000 : $perPage)
            ->withQueryString();
    }

    /**
     * Get all roles for select dropdowns.
     */
    public function getRoles(): Collection
    {
        return Role::orderBy('name')->get(['id', 'name']);
    }

    /**
     * Create new user with roles.
     */
    public function create(StoreUserRequest $request): User
    {
        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        if ($request->has('roles') && is_array($request->roles)) {
            $user->syncRoles($request->roles);
        }

        return $user->load('roles');
    }

    /**
     * Update user details and roles.
     */
    public function update(UpdateUserRequest $request, User $user): User
    {
        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles($request->roles ?? []);

        return $user->load('roles');
    }

    /**
     * Delete user with business rules.
     */
    public function delete(User $user): void
    {
        if (Auth::user()->id === $user->id) {
            throw new \Exception('You cannot delete your own account.');
        }

        if ($user->hasRole('super-admin')) {
            throw new \Exception('Super Admin users cannot be deleted.');
        }

        $user->delete();
    }

    public function getUser($id){
        $user = User::where('id',$id)->with('roles:id,name')->first();
        return $user;
    }
}
