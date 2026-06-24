<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['room_type_id', 'room_number', 'floor', 'status', 'description'];
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }
    public function bookings()
    {
        return $this->belongsToMany(Booking::class)->withPivot('price_per_night', 'nights', 'subtotal')->withTimestamps();
    }
}
