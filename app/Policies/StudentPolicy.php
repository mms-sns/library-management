<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('students.view') || $user->isSuperAdmin();
    }

    public function view(User $user, Student $student): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->library_id === $student->library_id && $user->hasPermissionTo('students.view');
    }

    public function create(User $user): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->hasPermissionTo('students.create');
    }

    public function update(User $user, Student $student): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->library_id === $student->library_id && $user->hasPermissionTo('students.update');
    }

    public function delete(User $user, Student $student): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->library_id === $student->library_id && $user->hasPermissionTo('students.delete');
    }
}
