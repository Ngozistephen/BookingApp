<?php

namespace App\Models;

use App\Models\Apartment;
use App\Observers\PropertyObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'city_id',
        'address_street',
        'address_postcode',
        'lat',
        'long',
    ];


    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public static function booted()
    {
        parent::booted();
 
        self::observe(PropertyObserver::class);
    }

    public function apartments()
    {
        return $this->hasMany(Apartment::class);
    }

}
