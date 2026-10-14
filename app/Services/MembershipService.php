<?php

namespace App\Services;

use App\Models\Membership;
use App\Models\MembershipPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MembershipService
{
    /**
     * Create a new student membership record
     */
    public function createMembership(array $data): Membership
    {
        return DB::transaction(function () use ($data) {
            $plan = MembershipPlan::findOrFail($data['membership_plan_id']);

            $startDate = !empty($data['start_date'])
                ? Carbon::parse($data['start_date'])
                : now();

            $endDate = (clone $startDate)->addDays($plan->duration_days - 1);

            $price = $data['price'] ?? $plan->price;
            $discount = $data['discount'] ?? 0.00;
            $finalAmount = max(0, $price - $discount);

            return Membership::create([
                'library_id' => $data['library_id'],
                'branch_id' => $data['branch_id'],
                'student_id' => $data['student_id'],
                'membership_plan_id' => $plan->id,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'price' => $price,
                'discount' => $discount,
                'final_amount' => $finalAmount,
                'status' => $data['status'] ?? 'active',
                'notes' => $data['notes'] ?? null,
            ]);
        });
    }

    /**
     * Renew an existing membership non-destructively
     */
    public function renewMembership(Membership $existingMembership, int $newPlanId, ?float $discount = 0.00, ?string $notes = null): Membership
    {
        return DB::transaction(function () use ($existingMembership, $newPlanId, $discount, $notes) {
            $newPlan = MembershipPlan::findOrFail($newPlanId);

            // Renewal Rules:
            // Option A: If existing membership is still active, new start_date = previous_end_date + 1 day
            // Option B: If expired, new start_date = current_date
            $today = now()->startOfDay();

            if ($existingMembership->end_date->isAfter($today)) {
                $startDate = $existingMembership->end_date->copy()->addDay();
            } else {
                $startDate = $today->copy();
            }

            $endDate = $startDate->copy()->addDays($newPlan->duration_days - 1);

            $price = $newPlan->price;
            $discount = $discount ?? 0.00;
            $finalAmount = max(0, $price - $discount);

            return Membership::create([
                'library_id' => $existingMembership->library_id,
                'branch_id' => $existingMembership->branch_id,
                'student_id' => $existingMembership->student_id,
                'membership_plan_id' => $newPlan->id,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'price' => $price,
                'discount' => $discount,
                'final_amount' => $finalAmount,
                'status' => 'active',
                'notes' => $notes ?? "Renewed from Membership #{$existingMembership->id}",
            ]);
        });
    }
}
