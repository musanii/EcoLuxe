<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $guarded =[];

    public function responses(){
        return $this->hasMany(InquiryResponse::class)->latest();
    }
}
