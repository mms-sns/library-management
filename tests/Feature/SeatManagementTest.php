<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Library;
use App\Models\Seat;
use App\Models\SeatType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeatManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    public function test_bulk_seat_generator_creates_seats_correctly(): void
    {
        $library = Library::create([
            'name' => 'Library Alpha',
            'slug' => 'lib-alpha',
            'email' => 'alpha@test.com',
            'mobile' => '9999999999',
            'status' => 'active',
        ]);
        $owner = User::create([
            'library_id' => $library->id,
            'name' => 'Owner Alpha',
            'email' => 'owner.alpha@test.com',
            'password' => bcrypt('password'),
        ]);
        $owner->assignRole('library_owner');

        $branch = Branch::create([
            'library_id' => $library->id,
            'name' => 'Main Branch',
            'code' => 'MB-01',
            'status' => 'active',
        ]);

        $seatType = SeatType::create([
            'library_id' => $library->id,
            'name' => 'AC Desk',
            'monthly_price' => 1500.00,
            'status' => 'active',
        ]);

        // Bulk Generate A-01 to A-10
        $response = $this->actingAs($owner)->post(route('seats.bulk-generate'), [
            'branch_id' => $branch->id,
            'seat_type_id' => $seatType->id,
            'prefix' => 'A-',
            'start_num' => 1,
            'end_num' => 10,
        ]);

        $response->assertRedirect(route('seats.index'));
        $this->assertDatabaseCount('seats', 10);
        $this->assertDatabaseHas('seats', ['branch_id' => $branch->id, 'seat_number' => 'A-01']);
        $this->assertDatabaseHas('seats', ['branch_id' => $branch->id, 'seat_number' => 'A-10']);
    }

    public function test_seat_map_page_loads_with_occupancy_analytics(): void
    {
        $this->seed(\Database\Seeders\DemoLibrarySeeder::class);

        $owner = User::where('email', 'owner@apexlibrary.com')->first();

        $response = $this->actingAs($owner)->get(route('seats.map'));
        $response->assertStatus(200);
        $response->assertSee('Interactive Seat Map');
        $response->assertSee('A-01');
        $response->assertDontSee('Filter Floor');
        $response->assertDontSee('Filter Room');
        $response->assertDontSee('Seat Packages');
    }
}
