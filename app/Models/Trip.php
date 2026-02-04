<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Spatie\Translatable\HasTranslations;

class Trip extends Model
{
    /** @use HasFactory<\Database\Factories\TripFactory> */
    use HasFactory,HasTranslations;

    protected $fillable = [
        'company_id', 'driver_id', 'vehicle_id', 'starts_at', 'ends_at', 'status'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'status' => \App\Enum\TripStatus::class,
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function driver() {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    // Scope للـ Active trips
    public function scopeActive($query) {
        $now = now();
        return $query->where('starts_at', '<=', $now)
            ->where('ends_at', '>=', $now);
    }

    // Scope للـ overlapping
    public function scopeOverlapping($query, $from, $to)
    {
        return $query->where(function ($q) use ($from, $to) {
            $q->whereBetween('starts_at', [$from, $to])
                ->orWhereBetween('ends_at', [$from, $to])
                ->orWhere(function ($q2) use ($from, $to) {
                    $q2->where('starts_at', '<=', $from)
                        ->where('ends_at', '>=', $to);
                });
        });
    }

    // Scope to get trips completed this month
    public function scopeCompletedThisMonth(Builder $query): Builder
    {
        $now = Carbon::now();
        return $query->where('status', 'completed') // شرط الحالة مكتملة
        ->whereMonth('ends_at', $now->month)
            ->whereYear('ends_at', $now->year);
    }
}
