<?php

namespace App\Policies;

use App\Models\IDCard;
use App\Models\User;

class IDCardPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['library_owner', 'branch_manager', 'staff']);
    }

    public function view(User $user, IDCard $card): bool
    {
        return $user->library_id === $card->library_id;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['library_owner', 'branch_manager']);
    }

    public function revoke(User $user, IDCard $card): bool
    {
        return $user->library_id === $card->library_id && $user->hasAnyRole(['library_owner', 'branch_manager']);
    }
}
