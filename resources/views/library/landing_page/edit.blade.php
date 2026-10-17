<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-xl text-black dark:text-white tracking-tight flex items-center gap-2">
                    <span>🌐</span>
                    <span>Library Public Landing Page</span>
                </h2>
                <p class="text-xs text-gray-500 dark:text-bodydark">
                    Configure, customize, and enable your study center's branded public website.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a
                    href="{{ route('public.library.show', $library->slug) }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 rounded-xl bg-gray-100 dark:bg-boxdark-2 px-4 py-2.5 font-semibold text-xs text-gray-700 dark:text-white shadow-sm hover:bg-gray-200 dark:hover:bg-strokedark transition"
                >
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span>View Public Page</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6 py-2" x-data="{ copied: false, enabled: {{ old('is_enabled', $landingPage->is_enabled) ? 'true' : 'false' }} }">

        @if (session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <p class="text-sm text-emerald-700 dark:text-emerald-300 font-semibold">{{ session('status') }}</p>
            </div>
        @endif

        <!-- Live Status & URL Card -->
        <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Public Web Address</span>
                        <template x-if="enabled">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Published &amp; Live
                            </span>
                        </template>
                        <template x-if="!enabled">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-600 dark:bg-boxdark-2 dark:text-bodydark">
                                <span class="h-2 w-2 rounded-full bg-gray-400"></span>
                                Disabled / Draft
                            </span>
                        </template>
                    </div>
                    <div class="flex items-center gap-2 text-sm sm:text-base font-mono font-bold text-primary">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        <span id="public-url" class="truncate">{{ route('public.library.show', $library->slug) }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 w-full md:w-auto">
                    <button
                        type="button"
                        @click="navigator.clipboard.writeText('{{ route('public.library.show', $library->slug) }}'); copied = true; setTimeout(() => copied = false, 2500)"
                        class="flex-1 md:flex-initial inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl border border-stroke dark:border-strokedark text-xs font-semibold text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-boxdark-2 transition"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <span x-text="copied ? 'Link Copied! ✓' : 'Copy Link'">Copy Link</span>
                    </button>

                    <a
                        href="{{ route('public.library.show', $library->slug) }}"
                        target="_blank"
                        class="flex-1 md:flex-initial inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        <span>Preview</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Configuration -->
        <form method="POST" action="{{ route('library.landing-page.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            @if(Auth::user()->isSuperAdmin())
                <input type="hidden" name="library_id" value="{{ $library->id }}">
            @endif

            <!-- 1. Enable / Disable Master Toggle -->
            <div class="rounded-2xl border-2 p-6 transition" :class="enabled ? 'border-primary/40 bg-white dark:bg-boxdark shadow-sm' : 'border-dashed border-stroke dark:border-strokedark bg-gray-50/50 dark:bg-boxdark/50'">
                <div class="flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <label for="is_enabled" class="text-base font-bold text-black dark:text-white cursor-pointer flex items-center gap-2">
                            <span>Enable Public Landing Page</span>
                            <span class="text-xs font-normal text-gray-500">(Master Switch)</span>
                        </label>
                        <p class="text-xs text-gray-500 dark:text-bodydark max-w-2xl leading-relaxed">
                            When enabled, anyone visiting <strong class="text-primary font-mono">{{ route('public.library.show', $library->slug) }}</strong> can discover your study center, view available seats, browse membership plans, inspect amenities, and reach out directly via WhatsApp or phone.
                        </p>
                    </div>

                    <div class="pt-1">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                id="is_enabled"
                                name="is_enabled"
                                value="1"
                                x-model="enabled"
                                class="sr-only peer"
                            >
                            <div class="w-14 h-8 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-boxdark-2 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- 2. Hero & Announcement -->
            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-5">
                <div class="border-b border-stroke dark:border-strokedark pb-3">
                    <h3 class="text-base font-bold text-black dark:text-white flex items-center gap-2">
                        <span>✨</span> Hero Section &amp; Headlines
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-bodydark">The first impression students see when landing on your page</p>
                </div>

                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label for="hero_title" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">
                            Hero Main Heading <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="hero_title"
                            name="hero_title"
                            type="text"
                            value="{{ old('hero_title', $landingPage->hero_title ?? 'Welcome to ' . $library->name) }}"
                            required
                            placeholder="e.g. Welcome to Apex Study Center & Reading Room"
                            class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                        />
                        <x-input-error class="mt-1" :messages="$errors->get('hero_title')" />
                    </div>

                    <div>
                        <label for="hero_tagline" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">
                            Hero Subtitle / Tagline
                        </label>
                        <textarea
                            id="hero_tagline"
                            name="hero_tagline"
                            rows="2"
                            placeholder="e.g. A serene, disciplined quiet study space equipped for competitive exam aspirants, medical students, and serious learners."
                            class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                        >{{ old('hero_tagline', $landingPage->hero_tagline) }}</textarea>
                    </div>

                    <div>
                        <label for="announcement" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">
                            Top Announcement Ribbon (Optional)
                        </label>
                        <input
                            id="announcement"
                            name="announcement"
                            type="text"
                            value="{{ old('announcement', $landingPage->announcement) }}"
                            placeholder="e.g. 📢 Admissions open for the upcoming batch! 10% discount on yearly plans."
                            class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                        />
                    </div>
                </div>
            </div>

            <!-- 3. About Study Center -->
            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-5">
                <div class="border-b border-stroke dark:border-strokedark pb-3">
                    <h3 class="text-base font-bold text-black dark:text-white flex items-center gap-2">
                        <span>📖</span> About Section
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-bodydark">Tell students about your library philosophy, environment, and rules</p>
                </div>

                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label for="about_title" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">
                            Section Title
                        </label>
                        <input
                            id="about_title"
                            name="about_title"
                            type="text"
                            value="{{ old('about_title', $landingPage->about_title ?? 'Why Choose ' . $library->name . '?') }}"
                            class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                        />
                    </div>

                    <div>
                        <label for="about_text" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">
                            About Description
                        </label>
                        <textarea
                            id="about_text"
                            name="about_text"
                            rows="4"
                            placeholder="Describe your facilities, quiet atmosphere, strict pin-drop silence rules, and seating comfort..."
                            class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                        >{{ old('about_text', $landingPage->about_text) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 4. Facilities & Amenities Checklist -->
            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-5">
                <div class="border-b border-stroke dark:border-strokedark pb-3">
                    <h3 class="text-base font-bold text-black dark:text-white flex items-center gap-2">
                        <span>🛋️</span> Facilities &amp; Amenities
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-bodydark">Select the key features and perks available at your center</p>
                </div>

                @php
                    $selectedAmenities = old('amenities', $landingPage->amenities ?? []);
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($availableAmenities as $name => $meta)
                        <label class="relative flex items-start gap-3 p-3.5 rounded-xl border border-stroke dark:border-strokedark bg-gray-50/50 dark:bg-boxdark-2/40 hover:bg-gray-50 dark:hover:bg-boxdark-2 cursor-pointer transition">
                            <input
                                type="checkbox"
                                name="amenities[]"
                                value="{{ $name }}"
                                {{ in_array($name, $selectedAmenities) ? 'checked' : '' }}
                                class="mt-1 h-4 w-4 rounded border-stroke text-primary focus:ring-primary dark:border-strokedark dark:bg-boxdark-2"
                            />
                            <div class="text-xs">
                                <span class="font-bold text-black dark:text-white block">{{ $name }}</span>
                                <span class="text-[11px] text-gray-400 mt-0.5 block leading-tight">{{ $meta['description'] }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- 5. Display Preferences -->
            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-5">
                <div class="border-b border-stroke dark:border-strokedark pb-3">
                    <h3 class="text-base font-bold text-black dark:text-white flex items-center gap-2">
                        <span>📊</span> Public Display Preferences
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-bodydark">Choose what sections to showcase on the public landing page</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="flex items-center gap-3 p-4 rounded-xl border border-stroke dark:border-strokedark bg-gray-50/50 dark:bg-boxdark-2/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-boxdark-2 transition">
                        <input
                            type="checkbox"
                            name="show_pricing"
                            value="1"
                            {{ old('show_pricing', $landingPage->show_pricing ?? true) ? 'checked' : '' }}
                            class="h-5 w-5 rounded border-stroke text-primary focus:ring-primary dark:border-strokedark dark:bg-boxdark-2"
                        />
                        <div>
                            <span class="text-xs font-bold text-black dark:text-white block">Membership Plans &amp; Pricing</span>
                            <span class="text-[11px] text-gray-400 block mt-0.5">Show active plans and subscription fees</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 rounded-xl border border-stroke dark:border-strokedark bg-gray-50/50 dark:bg-boxdark-2/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-boxdark-2 transition">
                        <input
                            type="checkbox"
                            name="show_timing"
                            value="1"
                            {{ old('show_timing', $landingPage->show_timing ?? true) ? 'checked' : '' }}
                            class="h-5 w-5 rounded border-stroke text-primary focus:ring-primary dark:border-strokedark dark:bg-boxdark-2"
                        />
                        <div>
                            <span class="text-xs font-bold text-black dark:text-white block">Operating Hours</span>
                            <span class="text-[11px] text-gray-400 block mt-0.5">Show opening and closing times</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-4 rounded-xl border border-stroke dark:border-strokedark bg-gray-50/50 dark:bg-boxdark-2/30 cursor-pointer hover:bg-gray-50 dark:hover:bg-boxdark-2 transition">
                        <input
                            type="checkbox"
                            name="show_seats_status"
                            value="1"
                            {{ old('show_seats_status', $landingPage->show_seats_status ?? true) ? 'checked' : '' }}
                            class="h-5 w-5 rounded border-stroke text-primary focus:ring-primary dark:border-strokedark dark:bg-boxdark-2"
                        />
                        <div>
                            <span class="text-xs font-bold text-black dark:text-white block">Live Seat Availability</span>
                            <span class="text-[11px] text-gray-400 block mt-0.5">Show available vs total seats count</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- 6. Contact, WhatsApp & Location -->
            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-5">
                <div class="border-b border-stroke dark:border-strokedark pb-3">
                    <h3 class="text-base font-bold text-black dark:text-white flex items-center gap-2">
                        <span>📞</span> Contact &amp; Location Details
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-bodydark">Help students reach your reception or contact desk immediately</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label for="contact_phone" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">
                            Reception Phone
                        </label>
                        <input
                            id="contact_phone"
                            name="contact_phone"
                            type="text"
                            value="{{ old('contact_phone', $landingPage->contact_phone ?? $library->mobile) }}"
                            placeholder="e.g. +91 98765 43210"
                            class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                        />
                    </div>

                    <div>
                        <label for="whatsapp_number" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">
                            WhatsApp Number (Direct Chat)
                        </label>
                        <input
                            id="whatsapp_number"
                            name="whatsapp_number"
                            type="text"
                            value="{{ old('whatsapp_number', $landingPage->whatsapp_number ?? $library->mobile) }}"
                            placeholder="e.g. 919876543210 (with country code)"
                            class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                        />
                        <span class="text-[10px] text-gray-400 mt-1 block">Students can click to chat with you on WhatsApp</span>
                    </div>

                    <div>
                        <label for="contact_email" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">
                            Inquiry Email
                        </label>
                        <input
                            id="contact_email"
                            name="contact_email"
                            type="email"
                            value="{{ old('contact_email', $landingPage->contact_email ?? $library->email) }}"
                            placeholder="e.g. contact@yourlibrary.com"
                            class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                        />
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">
                            Full Center Address
                        </label>
                        <textarea
                            id="address"
                            name="address"
                            rows="2"
                            placeholder="e.g. 2nd Floor, Landmark Building, Near Metro Station..."
                            class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                        >{{ old('address', $landingPage->address ?? $library->address) }}</textarea>
                    </div>

                    <div>
                        <label for="google_maps_url" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">
                            Google Maps Link (Directions)
                        </label>
                        <input
                            id="google_maps_url"
                            name="google_maps_url"
                            type="url"
                            value="{{ old('google_maps_url', $landingPage->google_maps_url) }}"
                            placeholder="https://maps.google.com/..."
                            class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                        />
                    </div>
                </div>
            </div>

            <!-- 7. SEO & Search Engine Optimization -->
            <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark space-y-5">
                <div class="border-b border-stroke dark:border-strokedark pb-3">
                    <h3 class="text-base font-bold text-black dark:text-white flex items-center gap-2">
                        <span>🔍</span> SEO &amp; Social Sharing
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-bodydark">Optimize how your page appears on Google search and when sharing on WhatsApp or social media</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="seo_meta_title" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">
                            SEO Page Title
                        </label>
                        <input
                            id="seo_meta_title"
                            name="seo_meta_title"
                            type="text"
                            value="{{ old('seo_meta_title', $landingPage->seo_meta_title ?? $library->name . ' — Quiet Study Center & Reading Room') }}"
                            placeholder="e.g. Apex Study Center — Best AC Library in City"
                            class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                        />
                    </div>

                    <div>
                        <label for="seo_meta_description" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-black dark:text-white">
                            SEO Meta Description
                        </label>
                        <textarea
                            id="seo_meta_description"
                            name="seo_meta_description"
                            rows="2"
                            placeholder="Brief description that appears in search results and WhatsApp link previews..."
                            class="w-full rounded-xl border border-stroke bg-gray-50 dark:bg-boxdark-2 py-3 px-4 text-sm text-black dark:text-white outline-none focus:border-primary dark:border-strokedark dark:focus:border-primary transition"
                        >{{ old('seo_meta_description', $landingPage->seo_meta_description ?? 'Join ' . $library->name . ' for high-speed Wi-Fi, comfortable AC seating, and quiet study atmosphere.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-4 pb-12">
                <a
                    href="{{ route('library.show') }}"
                    class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-boxdark-2 text-gray-700 dark:text-bodydark font-semibold text-xs uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-strokedark transition"
                >
                    Cancel
                </a>

                <div class="flex items-center gap-3">
                    <a
                        href="{{ route('public.library.show', $library->slug) }}"
                        target="_blank"
                        class="px-5 py-2.5 rounded-xl border border-stroke dark:border-strokedark text-gray-700 dark:text-white font-semibold text-xs uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-boxdark-2 transition"
                    >
                        Preview Page
                    </a>
                    <button
                        type="submit"
                        class="px-7 py-2.5 rounded-xl bg-primary text-white font-semibold text-xs uppercase tracking-widest hover:bg-primary-hover shadow-md transition"
                    >
                        Save &amp; Update Landing Page
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
