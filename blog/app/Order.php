<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //定义表名
    protected $table = 'blog_order';
    protected $dates = [ 'created_at', 'updated_at'];

}
