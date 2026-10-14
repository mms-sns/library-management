<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SaaSPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SaaSPackageController extends Controller
{
    public function index(Request $request): View
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Super Admin platform access required.');
        }

        $packages = SaaSPackage::withCount('subscriptions')->get();

        return view('admin.saas_packages.index', compact('packages'));
    }

    public function create(Request $request): View
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Super Admin platform access required.');
        }

        return view('admin.saas_packages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Super Admin platform access required.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'required|numeric|min:0',
            'max_branches' => 'required|integer|min:0',
            'max_seats' => 'required|integer|min:0',
            'max_students' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        SaaSPackage::create($validated);

        return redirect()->route('admin.saas-packages.index')
            ->with('status', "SaaS Package '{$validated['name']}' created successfully.");
    }

    public function edit(Request $request, SaaSPackage $saasPackage): View
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Super Admin platform access required.');
        }

        return view('admin.saas_packages.edit', compact('saasPackage'));
    }

    public function update(Request $request, SaaSPackage $saasPackage): RedirectResponse
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Super Admin platform access required.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'required|numeric|min:0',
            'max_branches' => 'required|integer|min:0',
            'max_seats' => 'required|integer|min:0',
            'max_students' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $saasPackage->update($validated);

        return redirect()->route('admin.saas-packages.index')
            ->with('status', "SaaS Package '{$saasPackage->name}' updated successfully.");
    }
}
