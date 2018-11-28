<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id', 'stock_id', 'quantity', 'created_at', 'updated_at'
    ];
}
