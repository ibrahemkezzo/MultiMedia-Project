<?php

namespace Modules\Auth\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Auth\Http\Requests\Role\StoreRoleRequest;
use Modules\Auth\Http\Requests\Role\UpdateRoleRequest;
use Modules\Auth\Services\RoleService;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(protected RoleService $service) {}

    /** Display a listing of roles */
    public function index(): View
    {
        $roles = $this->service->paginate([
            'search' => request('search'),
            'per_page' => request('per_page', 25),
        ]);
        return view('auth::dashboard.roles.index', compact('roles'));
    }

    /** Show the form for creating a new role */
    public function create(): View
    {
        $permissions = $this->service->getAllPermissions();
        $role = new Role();
        return view('auth::dashboard.roles.form', compact('permissions','role'));
    }

    /** Store a newly created role */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->route('dashboard.roles.index')->with('message', [
            'type'    => 'success',
            'content' => __('Role created successfully.'),
            // 'img'     => asset('images/congrats.gif'),
        ]);
    }

    /** Display the specified role with users & permissions */
    public function show(Role $role): View
    {
        $role = $this->service->findWithRelations($role->id);
        return view('auth::dashboard.roles.show', compact('role'));
    }

    /** Show the form for editing the specified role */
    public function edit(Role $role): View
    {
        $permissions = $this->service->getAllPermissions();
        $role->load('permissions');
        return view('auth::dashboard.roles.form', compact('role', 'permissions'));
    }

    /** Update the specified role */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $this->service->update($role, $request->validated());

        return redirect()->route('dashboard.roles.index')->with('message', [
            'type'    => 'success',
            'content' => __('Role updated successfully.'),
        ]);
    }

    /** Remove the specified role */
    public function destroy(Role $role): RedirectResponse
    {
        try {
            $this->service->delete($role);
            $content = __('Role deleted successfully.');
            $type    = 'success';
        } catch (\Exception $e) {
            $content = $e->getMessage();
            $type    = 'error';
        }

        return back()->with('message', [
            'type'    => $type,
            'content' => $content,
        ]);
    }
}
