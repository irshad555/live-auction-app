<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStatus extends Model
{
    public function scopeUpcoming($query)
    {
        return $query->where('type', '=', 'upcoming')->first();
    }
    public function scopeLive($query)
    {
        return $query->where('type', '=', 'live')->first();
    }
    public function scopeClosed($query)
    {
        return $query->where('type', '=', 'closed')->first();
    }
}
