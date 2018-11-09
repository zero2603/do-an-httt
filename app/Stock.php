<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';

    protected $fillable = ['product_id', 'size_id', 'color_id', 'buying_price', 'selling_price'];

    public $timestamps = false;
}
