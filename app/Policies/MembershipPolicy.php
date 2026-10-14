<?php

namespace App\Policies;

use App\Models\Membership;
use App\Models\User;

class MembershipPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('memberships.view') || $user->isSuperAdmin();
    }

    public function view(User $user, Membership $membership): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->library_id === $membership->library_id && $user->hasPermissionTo('memberships.view');
    }

    public function create(User $user): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->hasPermissionTo('memberships.create');
    }

    public function renew(User $user, Membership $membership): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->library_id === $membership->library_id && $user->hasPermissionTo('memberships.renew');
    }

    public function cancel(User $user, Membership $membership): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->library_id === $membership->library_id && $user->hasPermissionTo('memberships.cancel');
    }
}
