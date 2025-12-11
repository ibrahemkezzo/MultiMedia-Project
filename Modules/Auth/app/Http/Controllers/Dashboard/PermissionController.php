<?php

namespace Modules\Auth\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Auth\Http\Requests\Permission\StorePermissionRequest;
use Modules\Auth\Http\Requests\Permission\UpdatePermissionRequest;
use Modules\Auth\Services\PermissionService;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct(protected PermissionService $service) {}

    /** Display a listing of permissions */
    public function index(): View
    {
        $permissions = $this->service->paginate([
            'search' => request('search'),
            'per_page' => request('per_page', 25),
        ]);

        return view('auth::dashboard.permissions.index', compact('permissions'));
    }

    /** Show the form for creating a new permission */
    public function create(): View
    {
        $permission = new Permission;

        return view('auth::dashboard.permissions.form', compact('permission'));
    }

    /** Store a newly created permission */
    public function store(StorePermissionRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->route('dashboard.permissions.create')->with('message', [
            'type' => 'success',
            'content' => __('Permission created successfully.'),
            // 'img'     => asset('images/congrats.gif'),
        ]);
    }

    /** Show the form for editing the specified permission */
    public function edit(Permission $permission): View
    {
        return view('auth::dashboard.permissions.form', compact('permission'));
    }

    /** Update the specified permission */
    public function update(UpdatePermissionRequest $request, Permission $permission): RedirectResponse
    {
        $this->service->update($permission, $request->validated());

        return redirect()->route('dashboard.permissions.index')->with('message', [
            'type' => 'success',
            'content' => __('Permission updated successfully.'),
        ]);
    }

    public function show($id): View
    {
        $permission = $this->service->findWithRoles($id);

        return view('auth::dashboard.permissions.show', compact('permission'));
    }

    /** Remove the specified permission */
    public function destroy(Permission $permission): RedirectResponse
    {
        try {
            $this->service->delete($permission);
            $content = __('Permission deleted successfully.');
            $type = 'success';
        } catch (\Exception $e) {
            $content = $e->getMessage();
            $type = 'error';
        }

        return back()->with('message', [
            'type' => $type,
            'content' => $content,
        ]);
    }
}
