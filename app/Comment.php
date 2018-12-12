<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'product_id', 'parent_comment_id', 'content', 'rating'];
    public $timestamps = true;
}
