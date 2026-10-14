<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\LibrarySetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user();
        $library = $user->isSuperAdmin()
            ? Library::with(['branches', 'settings'])->firstOrFail()
            : $user->library->load(['branches', 'settings']);

        $this->authorize('view', $library);

        return view('library.show', compact('library'));
    }

    public function edit(Request $request): View
    {
        $user = $request->user();
        $library = $user->isSuperAdmin()
            ? Library::firstOrFail()
            : $user->library;

        $this->authorize('update', $library);
        $settings = $library->settings;

        return view('library.edit', compact('library', 'settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $library = $user->isSuperAdmin()
            ? Library::findOrFail($request->input('library_id'))
            : $user->library;

        $this->authorize('update', $library);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i',
            'grace_period_days' => 'required|integer|min:0|max:30',
            'gst_enabled' => 'boolean',
            'gst_number' => 'nullable|required_if:gst_enabled,1|string|max:50',
            'tax_rate' => 'nullable|required_if:gst_enabled,1|numeric|min:0|max:100',
        ]);

        $library->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'pincode' => $validated['pincode'] ?? null,
        ]);

        $library->settings()->updateOrCreate(
            ['library_id' => $library->id],
            [
                'opening_time' => $validated['opening_time'],
                'closing_time' => $validated['closing_time'],
                'grace_period_days' => $validated['grace_period_days'],
                'gst_enabled' => $request->boolean('gst_enabled'),
                'gst_number' => $validated['gst_number'] ?? null,
                'tax_rate' => $validated['tax_rate'] ?? 0.00,
            ]
        );

        return redirect()->route('library.show')
            ->with('status', 'Library details and settings updated successfully.');
    }
}
