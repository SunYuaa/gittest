<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goods;

class IndexController extends Controller
{
    //商城首页
    public function index(){
        $goodsInfo = Goods::all();
        return view('index.index',(['goodsInfo'=>$goodsInfo]));
    }

}
