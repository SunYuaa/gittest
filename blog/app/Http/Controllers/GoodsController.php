<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goods;
class GoodsController extends Controller
{
    //全部商品
    public function goodsList(){
        $order_type = request()->post('order_type');
        $field = request()->post('field');
        $order = request()->post('order');

        if(empty($field)&&empty($order)){
            $goodsInfo = Goods::all();
        }
        if(!empty($field)&&!empty($order)){
            $goodsInfo = Goods::orderBy($field,$order)->get();
        }

        return view('goods.prolist',(['goodsInfo'=>$goodsInfo]));
    }
    //商品详情
    public function goodsDetail($id){
        if(!$id){
            return ;
        }
        $goodsOneInfo = Goods::where('goods_id',$id)->first();
        $goods_imgs = rtrim($goodsOneInfo['goods_imgs'],'|');
        $goodsOneInfo['goods_imgs'] = explode('|',$goods_imgs);

//        dd($goodsOneInfo['goods_imgs']);
        return view('goods.proinfo',(['goodsOneInfo'=>$goodsOneInfo]));
    }

}
