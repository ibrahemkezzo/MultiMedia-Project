<?php

namespace Modules\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{

    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
    }

    public function viewAny($user): bool
    {
        return $user->hasRole('super-admin');
    }

    public function view($user): bool
    {
        return $user->hasRole('super-admin');
    }

    public function update($user): bool
    {
        return $user->hasRole('super-admin');
    }
}
