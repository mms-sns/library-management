<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('invoices.view') || $user->isSuperAdmin();
    }

    public function view(User $user, Invoice $invoice): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->library_id === $invoice->library_id && $user->hasPermissionTo('invoices.view');
    }

    public function create(User $user): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->hasPermissionTo('invoices.create');
    }

    public function update(User $user, Invoice $invoice): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->library_id === $invoice->library_id && $user->hasPermissionTo('invoices.edit');
    }
}
