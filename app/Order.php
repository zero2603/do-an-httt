<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'status', 'total_amount'];
    
    protected $hidden = [];

    public $timestamps = true;

}
