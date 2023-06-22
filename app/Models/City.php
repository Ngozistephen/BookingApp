<?php

namespace App\Models;

use App\Models\Country;
use App\Models\Geoobject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['country_id', 'name', 'lat', 'long'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function Geoobject()
    {
        return $this->hasMany(Geoobject::class);
    }
}
