<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;
    protected $fillable = ['identity_number', 'name', 'gender', 'phone', 'email', 'address'];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
