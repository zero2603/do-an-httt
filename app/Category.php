<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /* The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'parent_id', 'name', 'created_at', 'updated_at'
   ];

   /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
   protected $hidden = [
       
   ];
}
