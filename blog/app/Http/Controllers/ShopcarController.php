<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Goods;
use App\Cart;

class ShopcarController extends Controller
{
    //是否登录
    public function checkLogin(){
        if(session('loginInfo')){
            return 1;
        }else{
            return 2;
        }
//        $status  = session()->exists('loginInfo');
//        echo $status;
    }
    //加入购物车
    public function cartAdd(){
        $buy_number = request()->post('buy_number');
        $goods_id = request()->post('goods_id');
        if($goods_id==''){
            echo '请至少选择一个商品';die;
        }
        $userInfo = session('loginInfo')->toArray();
        $user_id = $userInfo[0]['user_id'];

        $data = [
            'user_id'=>$user_id,
            'goods_id'=>$goods_id,
            'buy_number'=>$buy_number,
            'buy_time'=>time()
        ];
        $res = DB::table('blog_cart')->where('goods_id',$goods_id)->first();

        $goodsData = Goods::where('goods_id',$goods_id)->first();
        $cartData = Cart::where('goods_id',$goods_id)->first();
        $goods_num = $goodsData['goods_num'];
        $num = $cartData['buy_number'];
        $cart_id = $cartData['cart_id'];
        if($res){
            //改
            //判断是否超过库存
            if(($buy_number+$num) > $goods_num){
                $n = $goods_num-$num;
                echo '您购买的数量已经超过库存，您还可以买'.$n.'件此商品';die;
            }
            $data['buy_number']=$num+$buy_number;
            $res = DB::table('blog_cart')->where('cart_id',$cart_id)->update($data);
            if($res){
                return 'ok';
            }else{
                return 'no';
            }
        }else{
            //增
            $res = DB::table('blog_cart')->where('cart_id',$cart_id)->insert($data);
            if($res){
                return 'ok';
            }else{
                return 'no';
            }
        }


    }
    //全部商品
    public function carList(){
        $cartInfo = Goods::select('buy_number','buy_time','blog_goods.*')
            ->join('blog_cart','blog_goods.goods_id','=','blog_cart.goods_id')
            ->get();
        $count = Goods::select('cart_id','blog_goods.*')
            ->join('blog_cart','blog_goods.goods_id','=','blog_cart.goods_id')
            ->count();

        return view('shopcar.car',compact('cartInfo','count'));
    }

    //点击加减改变数量
    public function changeNum(){
        $goods_id = request()->post('goods_id');
        $buy_number = request()->post('buy_number');

        $userInfo  = session('loginInfo')->toArray();
        $user_id = $userInfo[0]['user_id'];
        $where = [
            'user_id'=>$user_id,
            'goods_id'=>$goods_id
        ];
        $data = [
            'buy_number'=>$buy_number
        ];
        $res = Cart::where($where)->update($data);
        if($res){
            return 'ok';
        }else{
            return 'no';
        }
    }
    //计算总价
    public function priceCount(){
        $goods_id = request()->post('goods_id');
        $goods_id = explode(',',$goods_id);
        $userInfo  = session('loginInfo')->toArray();
        $user_id = $userInfo[0]['user_id'];
        $model = new Goods;
        $goodsData = $model->whereIn('goods_id',$goods_id)->get()->toArray();
        $priceCount = 0;
        foreach($goodsData as $k=>$v){
            $cartWhere = [
                'user_id'=>$user_id,
                'goods_id'=>$v['goods_id']
            ];
            $info = Cart::where($cartWhere)->first();
            $goodsData[$k]['buy_number'] = $info->buy_number;
            $priceCount += $v['goods_price']*$info->buy_number;
        }
        echo $priceCount;

    }
    //删除
    public function cartDel(){
        $goods_id = request()->post();
        $goods_id = explode(',',$goods_id['goods_id']);
        $userInfo  = session('loginInfo')->toArray();
        $user_id = $userInfo[0]['user_id'];

        $model = new Cart;
        $res = $model
            ->whereIn('goods_id',$goods_id)
            ->where('user_id',$user_id)
            ->delete();
        if($res){
            return 'ok';
        }else{
            return 'no';
        }
    }

}
