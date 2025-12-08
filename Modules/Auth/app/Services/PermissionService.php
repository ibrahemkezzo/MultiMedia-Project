<?php

namespace Modules\Auth\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService
{
    public function handle() {}

    /**
     * Paginate permissions with role count.
     */
    // Modules/Auth/Services/PermissionService.php
    public function paginate(array $filters = []): LengthAwarePaginator
    {
        $perPage = $filters['per_page'] ?? 20;

        return Permission::query()
            ->withCount('roles')
            ->when($filters['search'] ?? null, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage == 'all' ? 1000 : $perPage)
            ->withQueryString();
    }

    /**
     * Get all permissions.
     */
    public function all(): Collection
    {
        return Permission::orderBy('name')->get(['id', 'name']);
    }

    /**
     * Create new permission.
     */
    public function create(array $data): Permission
    {
        $permission = Permission::create([
            'name' => $data['name'],
            'guard_name' => 'web',
        ]);

        // جلب دور super-admin (إذا لم يكن موجودًا يُنشئه تلقائيًا)
        $superAdmin = Role::firstOrCreate(
            ['name' => 'super-admin'],
            ['guard_name' => 'web']
        );

        // إسناد الصلاحية الجديدة إلى super-admin
        $superAdmin->givePermissionTo($permission);

        // تحديث الكاش (اختياري لكن مهم جدًا في البيئات الكبيرة)
        $superAdmin->forgetCachedPermissions();

        return $permission;
    }

    /**
     * Update existing permission.
     */
    public function update(Permission $permission, array $data): Permission
    {
        $permission->update(['name' => $data['name']]);

        return $permission->fresh();
    }

    public function findWithRoles(int $id): Permission
    {
        return Permission::with('roles')->withCount('roles')->findOrFail($id);
    }

    /**
     * Delete permission safely.
     */
    public function delete(Permission $permission): void
    {
        if ($permission->roles()->exists()) {
            throw new \Exception('Cannot delete permission assigned to roles.');
        }

        $permission->delete();
    }
}
