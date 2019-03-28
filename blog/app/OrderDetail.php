<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //定义表名
    protected $table = 'blog_order_detail';
    //关闭时间戳
    public $timestamps = false;
}
