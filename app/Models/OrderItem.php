<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function product(){
        return $this->belongsTo(product::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
