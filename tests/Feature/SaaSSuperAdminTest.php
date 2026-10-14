<?php

namespace Tests\Feature;

use App\Models\Library;
use App\Models\SaaSPackage;
use App\Models\User;
use App\Services\TenantProvisioningService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SaaSSuperAdminTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected User $libraryOwner;
    protected Library $library;
    protected SaaSPackage $package;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'super_admin']);
        Role::firstOrCreate(['name' => 'library_owner']);

        $this->superAdmin = User::factory()->create(['email' => 'admin@saas.com']);
        $this->superAdmin->assignRole('super_admin');

        $this->package = SaaSPackage::create([
            'name' => 'Growth Plan',
            'slug' => 'growth-plan',
            'monthly_price' => 1999.00,
            'yearly_price' => 19990.00,
            'max_branches' => 3,
            'max_seats' => 150,
            'max_students' => 300,
            'status' => 'active',
        ]);

        $service = app(TenantProvisioningService::class);
        $result = $service->provisionLibrary([
            'name' => 'Existing Library',
            'email' => 'contact@existing.com',
            'mobile' => '9988776655',
            'branch_name' => 'Main Campus',
        ], [
            'name' => 'Owner Person',
            'email' => 'owner@existing.com',
            'password' => 'password123',
        ], $this->package->id);

        $this->library = $result['library'];
        $this->libraryOwner = $result['owner'];
    }

    public function test_super_admin_can_view_libraries_directory(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('admin.libraries.index'));
        $response->assertStatus(200);
        $response->assertSee('Existing Library');
    }

    public function test_super_admin_can_provision_new_tenant_library(): void
    {
        $response = $this->actingAs($this->superAdmin)->post(route('admin.libraries.store'), [
            'name' => 'Pinnacle Reading Hub',
            'email' => 'info@pinnacle.com',
            'mobile' => '9876500000',
            'city' => 'Kolkata',
            'branch_name' => 'Park Street Campus',
            'owner_name' => 'Subhash Ray',
            'owner_email' => 'subhash@pinnacle.com',
            'owner_password' => 'secret1234',
            'saas_package_id' => $this->package->id,
            'billing_cycle' => 'monthly',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('libraries', [
            'name' => 'Pinnacle Reading Hub',
            'email' => 'info@pinnacle.com',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'subhash@pinnacle.com',
        ]);
    }

    public function test_super_admin_can_create_saas_package(): void
    {
        $response = $this->actingAs($this->superAdmin)->post(route('admin.saas-packages.store'), [
            'name' => 'Unlimited Enterprise',
            'description' => 'Unlimited capacity for enterprise chains',
            'monthly_price' => 4999.00,
            'yearly_price' => 49990.00,
            'max_branches' => 0,
            'max_seats' => 0,
            'max_students' => 0,
            'status' => 'active',
        ]);

        $response->assertRedirect(route('admin.saas-packages.index'));
        $this->assertDatabaseHas('saas_packages', [
            'name' => 'Unlimited Enterprise',
            'slug' => 'unlimited-enterprise',
        ]);
    }

    public function test_non_super_admin_cannot_access_admin_portal(): void
    {
        $response = $this->actingAs($this->libraryOwner)->get(route('admin.libraries.index'));
        $response->assertStatus(403);
    }
}
