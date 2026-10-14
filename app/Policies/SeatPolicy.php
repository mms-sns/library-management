<?php

namespace App\Policies;

use App\Models\Seat;
use App\Models\User;

class SeatPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('seats.view') || $user->isSuperAdmin();
    }

    public function view(User $user, Seat $seat): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->library_id === $seat->branch->library_id && $user->hasPermissionTo('seats.view');
    }

    public function create(User $user): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->hasPermissionTo('seats.create');
    }

    public function update(User $user, Seat $seat): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->library_id === $seat->branch->library_id && $user->hasPermissionTo('seats.update');
    }

    public function delete(User $user, Seat $seat): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->library_id === $seat->branch->library_id && $user->isLibraryOwner();
    }
}
