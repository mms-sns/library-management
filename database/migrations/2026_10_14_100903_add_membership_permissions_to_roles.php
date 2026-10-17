<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'memberships.view',
            'memberships.create',
            'memberships.renew',
            'memberships.cancel',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $superAdmin = Role::where('name', 'super_admin')->first();
        if ($superAdmin) {
            $superAdmin->givePermissionTo($permissions);
        }

        $owner = Role::where('name', 'library_owner')->first();
        if ($owner) {
            $owner->givePermissionTo($permissions);
        }

        $branchManager = Role::where('name', 'branch_manager')->first();
        if ($branchManager) {
            $branchManager->givePermissionTo([
                'memberships.view',
                'memberships.create',
                'memberships.renew',
            ]);
        }

        $staff = Role::where('name', 'staff')->first();
        if ($staff) {
            $staff->givePermissionTo('memberships.view');
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::whereIn('name', [
            'memberships.view',
            'memberships.create',
            'memberships.renew',
            'memberships.cancel',
        ])->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
};
