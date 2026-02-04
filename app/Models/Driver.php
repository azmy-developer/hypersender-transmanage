<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Driver extends Model
{
    /** @use HasFactory<\Database\Factories\DriverFactory> */
    use HasFactory,HasTranslations;

    protected $fillable = ['company_id', 'name', 'license_number', 'phone', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function trips() {
        return $this->hasMany(Trip::class);
    }
}
