<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            'super_admin',
            'library_owner',
            'branch_manager',
            'staff',
            'student',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        $permissions = [
            'saas.manage',

            'dashboard.view',

            'students.view',
            'students.create',
            'students.update',
            'students.delete',

            'admissions.view',
            'admissions.create',

            'seats.view',
            'seats.create',
            'seats.update',
            'seats.assign',
            'seats.release',

            'attendance.view',
            'attendance.scan',
            'attendance.edit',

            'invoices.view',
            'invoices.create',
            'invoices.edit',

            'payments.view',
            'payments.create',
            'payments.refund',

            'id_cards.view',
            'id_cards.generate',
            'id_cards.print',

            'reports.view',

            'staff.view',
            'staff.create',
            'staff.update',

            'library.view',
            'library.update',

            'branches.view',
            'branches.create',
            'branches.update',

            'settings.view',
            'settings.update',

            'activity_logs.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $superAdmin = Role::findByName('super_admin', 'web');
        $superAdmin->syncPermissions(Permission::all());

        $owner = Role::findByName('library_owner', 'web');
        $owner->syncPermissions(
            Permission::where('name', '!=', 'saas.manage')->get()
        );

        $branchManager = Role::findByName('branch_manager', 'web');
        $branchManager->syncPermissions([
            'dashboard.view',
            'students.view', 'students.create', 'students.update',
            'admissions.view', 'admissions.create',
            'seats.view', 'seats.assign', 'seats.release',
            'attendance.view', 'attendance.scan', 'attendance.edit',
            'invoices.view', 'invoices.create',
            'payments.view', 'payments.create',
            'id_cards.view', 'id_cards.generate', 'id_cards.print',
            'reports.view',
            'branches.view',
            'activity_logs.view',
        ]);

        $staff = Role::findByName('staff', 'web');
        $staff->syncPermissions([
            'dashboard.view',
            'students.view',
            'admissions.view',
            'seats.view',
            'attendance.view', 'attendance.scan',
            'invoices.view',
            'payments.view', 'payments.create',
            'id_cards.view', 'id_cards.print',
        ]);
    }
}
