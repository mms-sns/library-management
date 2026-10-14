<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\SaaSPackage;
use App\Models\TenantSubscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantSubscriptionController extends Controller
{
    public function index(Request $request): View
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Super Admin platform access required.');
        }

        $subscriptions = TenantSubscription::with(['library', 'package'])
            ->latest()
            ->paginate(15);

        return view('admin.tenant_subscriptions.index', compact('subscriptions'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Super Admin platform access required.');
        }

        $validated = $request->validate([
            'library_id' => 'required|exists:libraries,id',
            'saas_package_id' => 'required|exists:saas_packages,id',
            'billing_cycle' => 'required|in:monthly,yearly',
        ]);

        $package = SaaSPackage::findOrFail($validated['saas_package_id']);
        $price = $validated['billing_cycle'] === 'yearly' ? $package->yearly_price : $package->monthly_price;
        $durationDays = $validated['billing_cycle'] === 'yearly' ? 365 : 30;

        // Deactivate previous subscriptions for this tenant
        TenantSubscription::where('library_id', $validated['library_id'])
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        $subscription = TenantSubscription::create([
            'library_id' => $validated['library_id'],
            'saas_package_id' => $package->id,
            'billing_cycle' => $validated['billing_cycle'],
            'price' => $price,
            'starts_at' => now()->toDateString(),
            'ends_at' => now()->addDays($durationDays)->toDateString(),
            'status' => 'active',
        ]);

        return redirect()->back()
            ->with('status', "SaaS package '{$package->name}' assigned to tenant successfully.");
    }
}
