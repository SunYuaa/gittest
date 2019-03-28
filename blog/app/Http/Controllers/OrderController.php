<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Goods;
use App\Cart;
use App\Address;
use App\Area;
use App\Order;
use App\OrderDetail;
use App\ReceiveAdd;

class OrderController extends Controller
{
    //结算页面
    public function order($id){
        $goods_id = explode(',',$id);
        $userInfo  = session('loginInfo')->toArray();
        $user_id = $userInfo[0]['user_id'];
        $goods_model = new Goods;
        $goodsInfo = $goods_model->whereIn('goods_id',$goods_id)->get();
        $priceCount = 0;
        foreach($goodsInfo as $k=>$v){
            $cartWhere = [
                'goods_id'=>$v['goods_id']
            ];
            $info = Cart::where($cartWhere)->first();
            $goodsInfo[$k]['buy_number'] = $info->buy_number;
            $goodsInfo[$k]['buy_time'] = $info->buy_time;
            $priceCount += $v['goods_price']*$info->buy_number;
        }
        //收货地址
        $addressInfo = Address::where('user_id',$user_id)->get();
        if(!empty($addressInfo)){
            //处理省市区
            foreach($addressInfo as $k=>$v){
                $addressInfo[$k]['province']=Area::where(['id'=>$v['province']])->select('name');
                $addressInfo[$k]['city']=Area::where(['id'=>$v['city']])->select('name');
                $addressInfo[$k]['county']=Area::where(['id'=>$v['county']])->select('name');
            }
        }

        return view('order.pay',(['goodsInfo'=>$goodsInfo,'priceCount'=>$priceCount,'addressInfo'=>$addressInfo]));
    }

    //确认结算
    public function orderDo(){
        $status  = session()->exists('loginInfo');
        if($status!=true){
            echo '请先登录';die;
        }
        $userInfo  = session('loginInfo')->toArray();
        $user_id = $userInfo[0]['user_id'];
        $address_id = request()->post('address_id');
        $goods_id = request()->post('goods_id');
        $priceCount = request()->post('priceCount');
        $order_type = request()->post('order_type');

        //存入订单表
        $goodsInfo = Goods::select('buy_number','blog_goods.*')
            ->join('blog_cart','blog_goods.goods_id','=','blog_cart.goods_id')
            ->get();
        $order_amount = 0;
        foreach($goodsInfo as $k=>$v){
            $order_amount += $v['buy_number']*$v['goods_price'];
        }
        $orderInfo['order_no'] = time()+rand(1111,9999);
        $orderInfo['order_amount'] = $priceCount;
        $orderInfo['user_id'] = $user_id;
        $orderInfo['order_type'] = $order_type;
        $res1 = Order::insert($orderInfo);

        //订单详情表
        $order_id = DB::getPdo()->lastInsertId();
        $Info = [];
        $res2 = '';
        foreach($goodsInfo as $k=>$v){
//            $num = Goods::where('goods_id',$v['goods_id'])->select('num');
//            if(($v['buy_number']+$num) > $v['goods_num']){
//                $n = $v['goods_num']-$num;
//                echo '您购买的数量已经超过库存，您还可以买'.$n.'件此商品';die;
//            }
//            dd(11);
            $Info[$k]['order_id']=$order_id;
            $Info[$k]['user_id']=$user_id;
            $Info[$k]['goods_id']=$v['goods_id'];
            $Info[$k]['goods_name']=$v['goods_name'];
            $Info[$k]['buy_number']=$v['buy_number'];
            $Info[$k]['goods_price']=$v['goods_price'];
            $Info[$k]['goods_img']=$v['goods_img'];

            $res2 = OrderDetail::insert($Info);
        }

        //订单收货信息 存入订单收货地址表
        $addressWhere = [
            'address_id'=>$address_id
        ];
        $addressInfo = Address::where($addressWhere)->first();
        if(empty($addressInfo)){
            echo ('收货地址不存在');die;
        }

        $addressData['order_id']=$order_id;
        $addressData['user_id']=$user_id;
        $addressData['receive_name']=$addressInfo['address_name'];
        $addressData['receive_tel']=$addressInfo['address_tel'];
        $addressData['receive_detail']=$addressInfo['address_detail'];
        $addressData['province']=$addressInfo['province'];
        $addressData['city']=$addressInfo['city'];
        $addressData['county']=$addressInfo['county'];
        $res3 = ReceiveAdd::insert($addressData);

        //清空当前用户的购物车信息 购物车表
        $id = explode(',',$goods_id);
        $res4 = DB::table('blog_cart')->where('user_id',$user_id)->whereIn('goods_id',$id)->delete();

        //减少商品库存 商品表
        foreach($goodsInfo as $k=>$v){
            $goodsWhere = [
                'goods_id'=>$v['goods_id']
            ];
            $updateInfo = [
                'goods_num'=>$v['goods_num']-$v['buy_number']
            ];
            $res5 = Goods::where($goodsWhere)->update($updateInfo);
        }

        if($res1&&$res2&&$res3&&$res4&&$res5){
            return 'ok';
        }else{
            return 'no';
        }
    }

    //继续支付
    public function successOrder(){
        $userInfo  = session('loginInfo')->toArray();
        $user_id = $userInfo[0]['user_id'];
        $orderInfo = DB::table('blog_order')
            ->where(['user_id'=>$user_id,'order_status'=>3])
            ->orderBy('order_id','desc')
            ->first();
        return view('order.successOrder',compact('orderInfo'));
    }

    //支付宝手机端
    public function alipay($order_no){


        if(!$order_no){
            return redirect('goods')->with('没有订单信息');
        }
        //根据订单号得到订单信息
        $order = DB::table('blog_order')
            ->select(['order_amount','order_no'])
            ->where('order_no',$order_no)
            ->first();
        if($order->order_amount<=0){
            return redirect('goods/')->with('无效的订单');
        }
//        echo app_path('libs/pcpay/wappay/service/AlipayTradeService.php');die;
        require_once app_path('libs/pcpay/wappay/service/AlipayTradeService.php');

        require_once app_path('libs/pcpay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php');

        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $order_no;

        //订单名称，必填
        $subject = '手机支付测试';

        //付款金额，必填
        $total_amount = $order->order_amount;

        //商品描述，可空
        $body = '测试test';

        //超时时间
        $timeout_express="1m";

        $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);

        $payResponse = new \AlipayTradeService(config('alipay'));
        $result=$payResponse->wapPay($payRequestBuilder,config('alipay.return_url'),config('alipay.notify_url'));

        return $result;
    }

    //同步
    public function returnpay(){

        $out_trade_no = trim($_GET['out_trade_no']);
        $total_amount = trim($_GET['total_amount']);
        $data = DB::table('blog_order')->where(['order_no'=>$out_trade_no,'order_amount'=>$total_amount])->first();
        if(!$data){
            return redirect('/user')->with('付款错误，无此订单');
        }
        if(trim($_GET['seller_id']) != config('alipay.seller_id') || trim($_GET['app_id']) != config('alipay.app_id')){
            return redirect('/user')->with('付款错误，商家或卖家错误');
        }

        return redirect('index/');

    }

    //异步
    public function notifypay(){
        Log::channel('pay')->info('test');

        $post = json_encode($_POST);
        Log::channel('pay')->info($post);

        $out_trade_no = trim($_POST['out_trade_no']);
        $total_amount = trim($_POST['total_amount']);
        $data = DB::table('blog_order')->where(['order_no'=>$out_trade_no,'order_amount'=>$total_amount])->first();

        if(!$data){
            Log::channel('pay')->info($post.'付款错误，无此订单');
        }
        if(trim($_POST['seller_id']) != config('alipay.seller_id') || trim($_POST['app_id']) != config('alipay.app_id')){
            Log::channel('pay')->info($post.'付款错误，商家或卖家错误');
        }
        if($data){
            //改 支付状态
            $res = DB::table('blog_order')
                ->where(['order_no'=>$out_trade_no])
                ->update(['order_status'=>1]);
//            return $res;
            dump($res);
        }

    }



    //支付宝电脑端支付
//    public function alipay($order_no){
//        if(!$order_no){
//            return redirect('shopcar/')->with('没有订单信息');
//        }
//        //根据订单号得到订单信息
//        $order = DB::table('blog_order')
//            ->select(['order_amount','order_no'])
//            ->where('order_no',$order_no)
//            ->first();
//        if($order->order_amount<=0){
//            return redirect('shopcar/')->with('无效的订单');
//        }
//
////        echo app_path('libs/notify/pagepay/service/AlipayTradeService.php');die;
//        require_once app_path('libs/notify/pagepay/service/AlipayTradeService.php');
//        require_once app_path('libs/notify/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php');
//        //商户订单号，商户网站订单系统中唯一订单号，必填
//        $out_trade_no = trim($order_no);
//
//        //订单名称，必填
//        $subject = 'blog测试';
//
//        //付款金额，必填
//        $total_amount = $order->order_amount;
//
//        //商品描述，可空
//        $body = 'blog测试';
//
//        //构造参数
//        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
//        $payRequestBuilder->setBody($body);
//        $payRequestBuilder->setSubject($subject);
//        $payRequestBuilder->setTotalAmount($total_amount);
//        $payRequestBuilder->setOutTradeNo($out_trade_no);
//
//        $aop = new \AlipayTradeService(config('alipay'));
//
//        /**
//         * pagePay 电脑网站支付请求
//         * @param $builder 业务参数，使用buildmodel中的对象生成。
//         * @param $return_url 同步跳转地址，公网可以访问
//         * @param $notify_url 异步通知地址，公网可以访问
//         * @return $response 支付宝返回的信息
//         */
//        $response = $aop->pagePay($payRequestBuilder,config('alipay.return_url'),config('alipay.notify_url'));
//
//        //输出表单
//        var_dump($response);
//    }
}
