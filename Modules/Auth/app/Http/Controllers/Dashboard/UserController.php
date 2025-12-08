<?php

namespace Modules\Auth\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Auth\Http\Requests\User\StoreUserRequest;
use Modules\Auth\Http\Requests\User\UpdateUserRequest;
use Modules\Auth\Services\UserService;

class UserController extends Controller
{
    public function __construct(protected UserService $service) {}

    /** Display a listing of the users */
    public function index(): View
    {
        $users = $this->service->paginate(request()->all());

        return view('auth::dashboard.users.index', compact('users'));
    }

    /** Show the form for creating a new user */
    public function create(): View
    {
        $roles = $this->service->getRoles();
        $user  = new User();

        return view('auth::dashboard.users.form', compact('roles','user'));
    }

    /** Store a newly created user */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $request->validated();
        $this->service->create($request);

        return redirect()->route('dashboard.users.index')->with('message', [
            'type'    => 'success',
            'content' => __('User created successfully.'),
            // 'img'     => asset('images/congrats.gif'),
        ]);
    }

    /** Show the form for editing the specified user */
    public function edit(User $user): View
    {
        $roles = $this->service->getRoles();
        $user->load('roles');
        return view('auth::dashboard.users.form', compact('user', 'roles'));
    }

    /** Update the specified user */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->service->update($request, $user);

        return redirect()->route('dashboard.users.index')->with('message', [
            'type'    => 'success',
            'content' => __('User updated successfully.'),
        ]);
    }

    /** Remove the specified user */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $this->service->delete($user);
            $content = __('User deleted successfully.');
            $type = 'success';
        } catch (\Exception $e) {
            $content = $e->getMessage();
            $type = 'error';
        }

        return back()->with('message', [
            'type'    => $type,
            'content' => $content,
        ]);
    }

    public function show($id){
        $user = $this->service->getUser($id);
        // dd($user);
        return view('auth::dashboard.users.show',compact('user'));
    }
}
