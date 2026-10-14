<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaaSPackage extends Model
{
    use HasFactory;

    protected $table = 'saas_packages';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'monthly_price',
        'yearly_price',
        'max_branches',
        'max_seats',
        'max_students',
        'status',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(TenantSubscription::class, 'saas_package_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getFormattedMaxBranchesAttribute(): string
    {
        return $this->max_branches === 0 ? 'Unlimited' : (string) $this->max_branches;
    }

    public function getFormattedMaxSeatsAttribute(): string
    {
        return $this->max_seats === 0 ? 'Unlimited' : (string) $this->max_seats;
    }

    public function getFormattedMaxStudentsAttribute(): string
    {
        return $this->max_students === 0 ? 'Unlimited' : (string) $this->max_students;
    }
}
