<?php

namespace Modules\Category\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Category\Models\Category;

class CategoryPolicy
{
    use HandlesAuthorization;

  public function viewAny(User $user): bool
    {
        return $user->can('view categories');
    }

    public function create(User $user): bool
    {
        return $user->can('create categories');
    }

    public function update(User $user, Category $category): bool
    {
        return $user->can('edit categories');
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->can('delete categories');
    }
}

/**
 * ===================================================================
 * شرح الكلاس: CategoryPolicy
 * ===================================================================
 * الهدف: تحديد الصلاحيات باستخدام Spatie
 * كيفية الاستخدام:
 *   $this->authorize('update', $category);
 * ===================================================================
 */
