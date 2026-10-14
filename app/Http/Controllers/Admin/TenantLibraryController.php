<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\SaaSPackage;
use App\Services\TenantProvisioningService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantLibraryController extends Controller
{
    public function __construct(protected TenantProvisioningService $provisioningService)
    {
    }

    public function index(Request $request): View
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Super Admin platform access required.');
        }

        $query = Library::with(['branches', 'users', 'activeSubscription.package']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $libraries = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total_libraries' => Library::count(),
            'active_libraries' => Library::where('status', 'active')->count(),
            'suspended_libraries' => Library::where('status', 'suspended')->count(),
        ];

        return view('admin.libraries.index', compact('libraries', 'stats'));
    }

    public function create(Request $request): View
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Super Admin platform access required.');
        }

        $packages = SaaSPackage::active()->get();

        return view('admin.libraries.create', compact('packages'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Super Admin platform access required.');
        }

        $validated = $request->validate([
            // Library details
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:libraries,email',
            'mobile' => 'required|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'branch_name' => 'required|string|max:255',
            'gst_number' => 'nullable|string|max:50',

            // Owner details
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email',
            'owner_password' => 'required|string|min:8',
            'owner_mobile' => 'nullable|string|max:20',

            // SaaS Package
            'saas_package_id' => 'nullable|exists:saas_packages,id',
            'billing_cycle' => 'required|in:monthly,yearly',
        ]);

        $result = $this->provisioningService->provisionLibrary([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'pincode' => $validated['pincode'] ?? null,
            'branch_name' => $validated['branch_name'],
            'gst_number' => $validated['gst_number'] ?? null,
        ], [
            'name' => $validated['owner_name'],
            'email' => $validated['owner_email'],
            'password' => $validated['owner_password'],
            'mobile' => $validated['owner_mobile'] ?? $validated['mobile'],
        ], $validated['saas_package_id'] ?? null, $validated['billing_cycle']);

        return redirect()->route('admin.libraries.show', $result['library'])
            ->with('status', "Tenant Library '{$result['library']->name}' provisioned successfully!");
    }

    public function show(Request $request, Library $library): View
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Super Admin platform access required.');
        }

        $library->load(['branches', 'settings', 'users', 'subscriptions.package']);
        $packages = SaaSPackage::active()->get();

        return view('admin.libraries.show', compact('library', 'packages'));
    }

    public function toggleStatus(Request $request, Library $library): RedirectResponse
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Super Admin platform access required.');
        }

        $newStatus = $library->status === 'active' ? 'suspended' : 'active';
        $library->update(['status' => $newStatus]);

        return redirect()->back()
            ->with('status', "Library status updated to '{$newStatus}'.");
    }
}
