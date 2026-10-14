<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Library;
use App\Models\LibrarySetting;
use App\Models\MembershipPlan;
use App\Models\SaaSPackage;
use App\Models\TenantSubscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenantProvisioningService
{
    /**
     * Provision a new tenant library with initial setting, main branch, owner user, and SaaS package
     */
    public function provisionLibrary(array $libraryData, array $ownerData, ?int $saasPackageId = null, string $billingCycle = 'monthly'): array
    {
        return DB::transaction(function () use ($libraryData, $ownerData, $saasPackageId, $billingCycle) {
            // 1. Create Library Record
            $slug = Str::slug($libraryData['name']);
            $count = Library::where('slug', 'like', "{$slug}%")->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }

            $library = Library::create([
                'name' => $libraryData['name'],
                'slug' => $slug,
                'email' => $libraryData['email'],
                'mobile' => $libraryData['mobile'],
                'address' => $libraryData['address'] ?? null,
                'city' => $libraryData['city'] ?? null,
                'state' => $libraryData['state'] ?? null,
                'pincode' => $libraryData['pincode'] ?? null,
                'status' => 'active',
            ]);

            // 2. Create Library Settings
            $settings = LibrarySetting::create([
                'library_id' => $library->id,
                'timezone' => $libraryData['timezone'] ?? 'Asia/Kolkata',
                'currency' => 'INR',
                'opening_time' => $libraryData['opening_time'] ?? '06:00:00',
                'closing_time' => $libraryData['closing_time'] ?? '23:00:00',
                'grace_period_days' => 2,
                'gst_enabled' => !empty($libraryData['gst_number']),
                'gst_number' => $libraryData['gst_number'] ?? null,
                'tax_rate' => !empty($libraryData['gst_number']) ? 18.00 : 0.00,
            ]);

            // 3. Create Main Branch
            $branch = Branch::create([
                'library_id' => $library->id,
                'name' => $libraryData['branch_name'] ?? 'Main Campus',
                'code' => 'MAIN-01',
                'address' => $libraryData['address'] ?? null,
                'city' => $libraryData['city'] ?? null,
                'state' => $libraryData['state'] ?? null,
                'pincode' => $libraryData['pincode'] ?? null,
                'status' => 'active',
            ]);

            // 3.1 Create Default Membership Plans
            $defaultPlans = [
                ['name' => 'Monthly Membership', 'duration_days' => 30, 'price' => 1500.00, 'description' => '30 Days Full Reading Access'],
                ['name' => 'Quarterly Membership', 'duration_days' => 90, 'price' => 4000.00, 'description' => '90 Days Access (Save ₹500)'],
                ['name' => 'Half Yearly Plan', 'duration_days' => 180, 'price' => 7500.00, 'description' => '180 Days Access (Save ₹1500)'],
                ['name' => 'Yearly Membership', 'duration_days' => 365, 'price' => 14000.00, 'description' => '365 Days Access (Save ₹4000)'],
            ];

            foreach ($defaultPlans as $dp) {
                MembershipPlan::create(array_merge($dp, [
                    'library_id' => $library->id,
                    'status' => 'active',
                ]));
            }

            // 4. Create Library Owner Account
            $owner = User::create([
                'library_id' => $library->id,
                'name' => $ownerData['name'],
                'email' => $ownerData['email'],
                'password' => Hash::make($ownerData['password']),
                'mobile' => $ownerData['mobile'] ?? $libraryData['mobile'],
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
            $owner->assignRole('library_owner');
            $owner->branches()->attach($branch->id);

            // 5. Assign SaaS Package Subscription if selected
            $subscription = null;
            if ($saasPackageId) {
                $package = SaaSPackage::findOrFail($saasPackageId);
                $price = $billingCycle === 'yearly' ? $package->yearly_price : $package->monthly_price;
                $durationDays = $billingCycle === 'yearly' ? 365 : 30;

                $subscription = TenantSubscription::create([
                    'library_id' => $library->id,
                    'saas_package_id' => $package->id,
                    'billing_cycle' => $billingCycle,
                    'price' => $price,
                    'starts_at' => now()->toDateString(),
                    'ends_at' => now()->addDays($durationDays)->toDateString(),
                    'status' => 'active',
                ]);
            }

            return [
                'library' => $library,
                'branch' => $branch,
                'owner' => $owner,
                'subscription' => $subscription,
            ];
        });
    }
}
