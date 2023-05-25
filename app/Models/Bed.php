<?php

namespace App\Models;

use App\Models\Room;
use App\Models\BedType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bed extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'bed_type_id', 'name'];
 
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
 
    public function bed_type()
    {
        return $this->belongsTo(BedType::class);
    }
}
