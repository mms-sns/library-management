<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\LibraryLandingPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryLandingPageController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $library = $user->isSuperAdmin()
            ? Library::firstOrFail()
            : $user->library;

        $this->authorize('update', $library);

        $landingPage = $library->landingPage ?? new LibraryLandingPage([
            'library_id' => $library->id,
            'is_enabled' => false,
            'hero_title' => 'Welcome to ' . $library->name,
            'hero_tagline' => 'Your premier quiet study environment equipped for focused learning, reading, and exam preparation.',
            'announcement' => 'Admissions open for current session! Limited seats available.',
            'about_title' => 'Why Choose ' . $library->name . '?',
            'about_text' => 'We offer a serene, distraction-free environment built specifically for competitive exam aspirants, researchers, and serious students. Enjoy high-speed Wi-Fi, ergonomic chairs, uninterrupted power, and strict pin-drop silence.',
            'contact_phone' => $library->mobile,
            'contact_email' => $library->email,
            'whatsapp_number' => $library->mobile,
            'address' => $library->address . ($library->city ? ', ' . $library->city : '') . ($library->pincode ? ' - ' . $library->pincode : ''),
            'amenities' => array_slice(array_keys(LibraryLandingPage::availableAmenities()), 0, 8),
            'show_pricing' => true,
            'show_timing' => true,
            'show_seats_status' => true,
        ]);

        $availableAmenities = LibraryLandingPage::availableAmenities();

        return view('library.landing_page.edit', compact('library', 'landingPage', 'availableAmenities'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $library = $user->isSuperAdmin()
            ? Library::findOrFail($request->input('library_id', 1))
            : $user->library;

        $this->authorize('update', $library);

        $validated = $request->validate([
            'is_enabled' => 'nullable|boolean',
            'hero_title' => 'required|string|max:255',
            'hero_tagline' => 'nullable|string|max:1000',
            'announcement' => 'nullable|string|max:255',
            'about_title' => 'nullable|string|max:255',
            'about_text' => 'nullable|string|max:5000',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|max:100',
            'contact_phone' => 'nullable|string|max:30',
            'contact_email' => 'nullable|email|max:150',
            'whatsapp_number' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
            'google_maps_url' => 'nullable|string|max:1000',
            'show_pricing' => 'nullable|boolean',
            'show_timing' => 'nullable|boolean',
            'show_seats_status' => 'nullable|boolean',
            'seo_meta_title' => 'nullable|string|max:255',
            'seo_meta_description' => 'nullable|string|max:500',
        ]);

        $library->landingPage()->updateOrCreate(
            ['library_id' => $library->id],
            [
                'is_enabled' => $request->boolean('is_enabled'),
                'hero_title' => $validated['hero_title'],
                'hero_tagline' => $validated['hero_tagline'] ?? null,
                'announcement' => $validated['announcement'] ?? null,
                'about_title' => $validated['about_title'] ?? null,
                'about_text' => $validated['about_text'] ?? null,
                'amenities' => $validated['amenities'] ?? [],
                'contact_phone' => $validated['contact_phone'] ?? null,
                'contact_email' => $validated['contact_email'] ?? null,
                'whatsapp_number' => $validated['whatsapp_number'] ?? null,
                'address' => $validated['address'] ?? null,
                'google_maps_url' => $validated['google_maps_url'] ?? null,
                'show_pricing' => $request->boolean('show_pricing', true),
                'show_timing' => $request->boolean('show_timing', true),
                'show_seats_status' => $request->boolean('show_seats_status', true),
                'seo_meta_title' => $validated['seo_meta_title'] ?? null,
                'seo_meta_description' => $validated['seo_meta_description'] ?? null,
            ]
        );

        $statusMsg = $request->boolean('is_enabled')
            ? 'Landing page updated and published successfully! It is now live.'
            : 'Landing page settings saved (currently disabled).';

        return redirect()->route('library.landing-page.edit')
            ->with('status', $statusMsg);
    }
}
