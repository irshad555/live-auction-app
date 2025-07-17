<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function status()
    {
        return $this->belongsTo(ProductStatus::class, 'status_id');
    }
   public function bids()
    {
        return $this->hasMany(Bid::class, 'product_id');
    }

    
}
