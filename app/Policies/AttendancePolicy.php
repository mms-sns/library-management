<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;

class AttendancePolicy
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

    public function view(User $user, Attendance $attendance): bool
    {
        return $user->library_id === $attendance->library_id;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['library_owner', 'branch_manager', 'staff']);
    }

    public function update(User $user, Attendance $attendance): bool
    {
        return $user->library_id === $attendance->library_id && $user->hasAnyRole(['library_owner', 'branch_manager', 'staff']);
    }
}
