<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //定义表名
    protected $table = 'blog_area';
    //关闭时间戳
    public $timestamps = false;
}
