<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Booking extends Model
{

   use  HasUuids;
    // protected $fillable = [
    //      'user_id',
    //      'service_id',
    //      'coupon_id',
    //      'customer_name', 
    //      'customer_email',
    //      'customer_phone',
    //      'scheduled_at', 
    //      'total_rooms', 
    //      'subtotal', 
    //      'discount_amount', 
    //      'total_price', 
    //      'status',
    //      'special_instructions',
    //      'address',
    //      'city',
    //      'zip_code',
    //      'stripe_session_id',
    //      'payment_status',
    //      'rating',
    //      'feedback_comment'
    // ];

    protected $guarded =[];

    const STATUS_PENDING = 'pending';
    const  STATUS_CONFIRMED ='confirmed';
    const STATUS_ON_THE_WAY ='on_the_way';
    const STATUS_IN_PROGRESS = 'in_progress';
    const  STATUS_COMPLETED ='completed';

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
        {
            return 'id'; // Tells Laravel to look up the UUID string in the 'id' column
        }

    public function service() {
    return $this->belongsTo(Service::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function cleaners(){
        return $this->belongsToMany(User::class,'booking_cleaner')
        ->withTimestamps();
    }

    public function messages(){
        return $this->hasMany(BookingMessage::class);
    }

    //Helper  to get colors for Filament badges
    public function getStatusColor(): string{

        return match($this->status){
            self::STATUS_PENDING=>'gray',
            self::STATUS_CONFIRMED => 'info',
            self::STATUS_ON_THE_WAY => 'warning',
            self::STATUS_IN_PROGRESS => 'primary',
            self::STATUS_COMPLETED => 'success',
            default => 'gray',
        };

    }
    /**
     * Generate a Google Maps link for the booking address. 
     */

    public function getGoogleMapsLinkAttribute(): string
    {
        $query = implode(',', array_filter([
            $this->address,
            $this->city,
            $this->zip_code,
            'Kenya'

        ]));
        return "https://www.google.com/maps/search/?api=1&query={urlencode($query)}";
    }

    public function getTransformationDurationAttribute(): ?string
    {
        if (!$this->started_at || !$this->completed_at) {
            return 'In Progress / Not Started';
        }
        return $this->started_at->diffForHumans($this->completed_at, true);
    }
}
