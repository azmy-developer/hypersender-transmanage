<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Company extends Model
{

    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory,HasTranslations;
    protected $fillable = ['name','active'];
    public function drivers() {
        return $this->hasMany(Driver::class);
    }

    public function vehicles() {
        return $this->hasMany(Vehicle::class);
    }

    public function trips() {
        return $this->hasMany(Trip::class);
    }
}
