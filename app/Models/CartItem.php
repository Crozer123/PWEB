<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id', 
        'item_id',
         'quantity'
        ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}

