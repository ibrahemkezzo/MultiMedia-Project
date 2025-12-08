<?php

namespace Modules\Auth\Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Auth\App\Http\Requests\Role\StoreRoleRequest;
use Modules\Auth\App\Http\Requests\Role\UpdateRoleRequest;

class RoleService
{
    public function handle() {}

    /**
     * Paginate roles with permissions and users count.
     */
    public function paginate(array $filters = []): LengthAwarePaginator
    {
        $perPage = $filters['per_page'] ?? 20;
        
        return Role::with(['permissions:id,name'])
            ->when($filters['search'] ?? null, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->withCount('users')
            ->latest()
            ->paginate($perPage == 'all' ? 1000 : $perPage)
            ->withQueryString();
    }

    /**
     * Find role with full relations: permissions + users.
     */
    public function findWithRelations(int $id): Role
    {
        return Role::with([
                'permissions:id,name',
                'users:id,name,email'
            ])
            ->withCount('users')
            ->findOrFail($id);
    }

    /**
     * Get all permissions for forms.
     */
    public function getAllPermissions(): Collection
    {
        return Permission::orderBy('name')->get(['id', 'name']);
    }

    /**
     * Create role with permissions.
     */
    public function create(array $data): Role
    {
        $role = Role::create([
            'name'       => $data['name'],
            'guard_name' => 'web',
        ]);

        if (!empty($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role->load('permissions');
    }

    /**
     * Update role and permissions.
     */
    public function update(Role $role, array $data): Role
    {
        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        return $role->load(['permissions', 'users:id,name,email']);
    }

    /**
     * Delete role safely.
     */
    public function delete(Role $role): void
    {
        if ($role->name === 'super-admin') {
            throw new \Exception('Cannot delete Super Admin role.');
        }

        if ($role->users()->exists()) {
            throw new \Exception('Cannot delete role assigned to users.');
        }

        $role->delete();
    }
}
