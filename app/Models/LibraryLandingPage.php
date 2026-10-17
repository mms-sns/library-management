<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryLandingPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'library_id',
        'is_enabled',
        'hero_title',
        'hero_tagline',
        'announcement',
        'about_title',
        'about_text',
        'amenities',
        'contact_phone',
        'contact_email',
        'whatsapp_number',
        'address',
        'google_maps_url',
        'show_pricing',
        'show_timing',
        'show_seats_status',
        'seo_meta_title',
        'seo_meta_description',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'show_pricing' => 'boolean',
            'show_timing' => 'boolean',
            'show_seats_status' => 'boolean',
            'amenities' => 'array',
        ];
    }

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    /**
     * Default list of popular amenities for study centers & libraries
     */
    public static function availableAmenities(): array
    {
        return [
            'High-Speed Optical Wi-Fi' => ['icon' => 'wifi', 'description' => 'Fast, uninterrupted internet connectivity for online classes and research.'],
            'Full Air Conditioning' => ['icon' => 'sparkles', 'description' => 'Climate-controlled cooling throughout operating hours for maximum comfort.'],
            'Ergonomic & Comfortable Chairs' => ['icon' => 'chair', 'description' => 'Specially designed seating to prevent fatigue during long study sessions.'],
            '100% Silent Learning Zone' => ['icon' => 'volume-off', 'description' => 'Strict quiet policy enforced to ensure total concentration and deep work.'],
            'Individual Power Sockets' => ['icon' => 'bolt', 'description' => 'Dedicated power outlets at every desk for laptops, tablets, and phones.'],
            '24x7 Power Backup' => ['icon' => 'battery', 'description' => 'Zero-downtime battery and generator backup during power cuts.'],
            'Pure RO Drinking Water' => ['icon' => 'droplet', 'description' => 'Chilled and normal RO purified water stations available at all times.'],
            'CCTV 24x7 Security Surveillance' => ['icon' => 'shield', 'description' => 'Round-the-clock camera monitoring ensuring complete safety.'],
            'Personal Storage Lockers' => ['icon' => 'lock', 'description' => 'Secure lockable spaces for your heavy study materials and books.'],
            'Daily Newspapers & Magazines' => ['icon' => 'newspaper', 'description' => 'Fresh leading daily newspapers and monthly current affairs journals.'],
            'Separate Discussion & Break Area' => ['icon' => 'users', 'description' => 'Dedicated zone to have meals, relax, or collaborate without disturbing others.'],
            'Clean & Sanitized Washrooms' => ['icon' => 'check', 'description' => 'Hygienic, regularly cleaned and maintained restroom facilities.'],
        ];
    }
}
