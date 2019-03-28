<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    //定义表名
    protected $table = 'blog_goods';
    //关闭时间戳
    public $timestamps = false;
}
