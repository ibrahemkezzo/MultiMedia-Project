<?php

namespace Modules\Product\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Product\Models\Product;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    public function viewAny(User $user): bool
    {
        return $user->can('view products');
    }

    public function create(User $user): bool
    {
        return $user->can('create products');
    }

    public function update(User $user, Product $product): bool
    {
        return $user->can('edit products') || $product->store->user_id === $user->id;
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->can('delete products') || $product->store->user_id === $user->id;
    }
}
