<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Library;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_library_owner_cannot_view_or_modify_other_tenant_branches(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);

        // Tenant A
        $libraryA = Library::create([
            'name' => 'Library Alpha',
            'slug' => 'library-alpha',
            'email' => 'alpha@test.com',
            'mobile' => '9999999991',
            'status' => 'active',
        ]);
        $ownerA = User::create([
            'library_id' => $libraryA->id,
            'name' => 'Owner Alpha',
            'email' => 'owner.a@test.com',
            'password' => bcrypt('password'),
        ]);
        $ownerA->assignRole('library_owner');

        $branchA = Branch::create([
            'library_id' => $libraryA->id,
            'name' => 'Alpha Main',
            'code' => 'ALP-01',
            'status' => 'active',
        ]);

        // Tenant B
        $libraryB = Library::create([
            'name' => 'Library Beta',
            'slug' => 'library-beta',
            'email' => 'beta@test.com',
            'mobile' => '9999999992',
            'status' => 'active',
        ]);
        $branchB = Branch::create([
            'library_id' => $libraryB->id,
            'name' => 'Beta Main',
            'code' => 'BET-01',
            'status' => 'active',
        ]);

        // Act as Owner A
        $response = $this->actingAs($ownerA)->get(route('branches.index'));
        $response->assertStatus(200);
        $response->assertSee('Alpha Main');
        $response->assertDontSee('Beta Main');

        // Try updating Branch B as Owner A
        $updateResponse = $this->actingAs($ownerA)->put(route('branches.update', $branchB), [
            'name' => 'Hacked Name',
            'code' => 'BET-01',
            'status' => 'active',
        ]);
        $updateResponse->assertStatus(403);
    }
}
