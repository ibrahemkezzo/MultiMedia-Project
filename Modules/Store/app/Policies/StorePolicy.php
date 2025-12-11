<?php

namespace Modules\Store\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Store\Models\Store;

class StorePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    public function viewAny(User $user): bool
    {
        return $user->can('view-stores');
    }

    public function view(User $user, Store $store): bool
    {
        return $user->can('view-stores') || $store->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('create-stores');
    }

    public function update(User $user, Store $store): bool
    {
        return $user->can('edit-stores') || $store->user_id === $user->id;
    }

    public function delete(User $user, Store $store): bool
    {
        return $user->can('delete-stores');
    }
}


/**
 * ===================================================================
 * شرح الكلاس: StorePolicy
 * ===================================================================
 * الهدف: صلاحيات المتاجر
 * لماذا وُجد: للتحكم في الوصول باستخدام Spatie
 * المهام الرئيسية:
 *   - إداري يشوف كل شيء
 *   - صاحب المتجر يشوف/يعدل متجره فقط
 * كيفية الاستخدام:
 *   1. في Controller: $this->authorize('update', $store);
 * ==
 *
 * **/
