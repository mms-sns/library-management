<?php

namespace App\Policies;

use App\Models\Library;
use App\Models\User;

class LibraryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function view(User $user, Library $library): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->library_id === $library->id;
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, Library $library): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->library_id === $library->id && $user->isLibraryOwner();
    }

    public function delete(User $user, Library $library): bool
    {
        return $user->isSuperAdmin();
    }
}
