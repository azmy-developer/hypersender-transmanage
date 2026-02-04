<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Vehicle extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleFactory> */
    use HasFactory,HasTranslations;

    protected $fillable = ['company_id', 'name', 'plate_number','active'];
    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function trips() {
        return $this->hasMany(Trip::class);
    }
}
