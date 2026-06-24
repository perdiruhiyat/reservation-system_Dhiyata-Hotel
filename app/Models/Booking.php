<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = ['booking_code', 'guest_id', 'user_id', 'created_by', 'booking_source', 'check_in_date', 'check_out_date', 'actual_check_in', 'actual_check_out', 'status', 'total_amount', 'notes'];
    protected function casts(): array
    {
        return ['check_in_date' => 'date', 'check_out_date' => 'date', 'actual_check_in' => 'datetime', 'actual_check_out' => 'datetime', 'total_amount' => 'decimal:2'];
    }
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function rooms()
    {
        return $this->belongsToMany(Room::class)->withPivot('price_per_night', 'nights', 'subtotal')->withTimestamps();
    }
}
