<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    //定义表名
    protected $table = 'blog_user';
    //关闭时间戳
    public $timestamps = false;
}
