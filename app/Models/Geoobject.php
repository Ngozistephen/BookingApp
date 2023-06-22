<?php

namespace App\Models;

use App\Models\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Geoobject extends Model
{
    use HasFactory;

    protected $fillable = ['city_id', 'name', 'lat', 'long'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

}
