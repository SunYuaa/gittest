<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiveAdd extends Model
{
    //定义表名
    protected $table = 'blog_receiveAddress';
    //关闭时间戳
    public $timestamps = false;
}
