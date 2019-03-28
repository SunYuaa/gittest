<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'blog_address';
    //关闭时间戳
    public $timestamps = false;
}
