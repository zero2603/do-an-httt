<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'order_item_size', 'order_item_color', 'order_item_quantity', 'order_item_price'];

    public $timestamps = true;
}
