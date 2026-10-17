<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DemoLibrarySeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
        $this->seed(DemoLibrarySeeder::class);
    }

    public function test_tenant_owner_can_view_all_in_one_executive_dashboard(): void
    {
        $owner = User::where('email', 'owner@apexlibrary.com')->first();

        $response = $this->actingAs($owner)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Welcome back,');
        $response->assertSee('Active Students');
        $response->assertSee('Seat Occupancy');
        $response->assertSee('Present in Library');
        $response->assertSee('Monthly Revenue');
        $response->assertSee('Live Reading Room Stream');
        $response->assertSee('Expiring Soon');
    }
}
