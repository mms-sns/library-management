<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'library_id',
        'branch_id',
        'student_id',
        'id_card_id',
        'seat_id',
        'check_in_at',
        'check_out_at',
        'status',
        'method',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'check_in_at' => 'datetime',
            'check_out_at' => 'datetime',
        ];
    }

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function idCard(): BelongsTo
    {
        return $this->belongsTo(IDCard::class, 'id_card_id');
    }

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('check_in_at', now()->toDateString());
    }

    public function getDurationInMinutes(): ?int
    {
        if (!$this->check_in_at) {
            return null;
        }

        $endTime = $this->check_out_at ?? now();
        return (int) $this->check_in_at->diffInMinutes($endTime);
    }

    public function getFormattedDuration(): string
    {
        $minutes = $this->getDurationInMinutes();
        if ($minutes === null) {
            return 'N/A';
        }

        $hours = floor($minutes / 60);
        $remainingMin = $minutes % 60;

        if ($hours > 0) {
            return "{$hours}h {$remainingMin}m";
        }

        return "{$remainingMin}m";
    }
}
