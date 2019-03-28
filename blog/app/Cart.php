<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'blog_cart';
    //关闭时间戳
    public $timestamps = false;
}
