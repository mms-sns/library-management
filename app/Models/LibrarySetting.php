<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibrarySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'library_id',
        'timezone',
        'currency',
        'date_format',
        'time_format',
        'opening_time',
        'closing_time',
        'duplicate_scan_delay_seconds',
        'grace_period_days',
        'gst_enabled',
        'gst_number',
        'tax_rate',
    ];

    protected function casts(): array
    {
        return [
            'gst_enabled' => 'boolean',
            'tax_rate' => 'decimal:2',
            'duplicate_scan_delay_seconds' => 'integer',
            'grace_period_days' => 'integer',
        ];
    }

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }
}
