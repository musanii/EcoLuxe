<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
     protected $guarded = [];

     protected $casts = [
        'advantages' => 'array',    // This is the missing piece
        'is_active' => 'boolean',
        'base_price' => 'decimal:2',
    ];

     public function getIconAttribute()
{
    // Return different SVG paths based on the service name
    return match (true) {
        str_contains($this->name, 'Essential') => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
        str_contains($this->name, 'Deep')      => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z',
        default                               => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
    };
}
}
