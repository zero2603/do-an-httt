<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = ['order_id', 'receiver_name', 'receiver_phone', 'shipment_address'];

    public $timestamps = true;
}
