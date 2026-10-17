<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'library_id',
        'seat_id',
        'user_id',
        'student_number',
        'first_name',
        'last_name',
        'photo',
        'gender',
        'date_of_birth',
        'mobile',
        'email',
        'address',
        'city',
        'state',
        'pincode',
        'status',
        'joined_at',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'joined_at' => 'date',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function guardian(): HasOne
    {
        return $this->hasOne(StudentGuardian::class);
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function idCards()
    {
        return $this->hasMany(IDCard::class);
    }

    public function activeIdCard()
    {
        return $this->hasOne(IDCard::class)->where('status', 'active')->latestOfMany();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function activeAttendance()
    {
        return $this->hasOne(Attendance::class)->where('status', 'present')->latestOfMany();
    }

    public function getPendingInvoiceAttribute(): ?Invoice
    {
        return $this->invoices
            ->filter(fn($inv) => $inv->balance_amount > 0 && $inv->status !== 'cancelled')
            ->sortBy('due_date')
            ->first();
    }

    public function getActiveMembershipAttribute(): ?Membership
    {
        return $this->memberships->first(fn($m) => $m->status === 'active' && !$m->end_date->isPast())
            ?? $this->memberships->first();
    }

    public function getTotalDueAmountAttribute(): float
    {
        return (float) $this->invoices
            ->where('status', '!=', 'cancelled')
            ->sum('balance_amount');
    }
}
