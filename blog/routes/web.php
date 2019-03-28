<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//商城首页
Route::get('index/','IndexController@index');


//全部商品
Route::get('goods/','GoodsController@goodsList');
Route::get('goods/proinfo/{id}','GoodsController@goodsDetail');//商品详情
Route::post('/goods/goodsList','GoodsController@goodsList');//排序

//购物车
Route::get('shopcar/','ShopcarController@carList');
Route::post('/shopcar/cartAdd','ShopcarController@cartAdd');//加入购物车
Route::post('/shopcar/changeNum','ShopcarController@changeNum');//点击加减
Route::post('/shopcar/priceCount','ShopcarController@priceCount');//计算总价
Route::post('shopcar/cartDel','ShopcarController@cartDel');//删除
Route::post('shopcar/checkLogin','ShopcarController@checkLogin');//结算时检测是否登录

//订单支付
Route::get('/Order/pay/{id}','OrderController@order');//结算时检测是否登录
Route::post('/order/orderDo','OrderController@orderDo');//订单完成
Route::get('/order/successOrder','OrderController@successOrder');//完成
Route::get('/alipay/{order_no}','OrderController@alipay');//支付宝支付
Route::get('/returnpay','OrderController@returnpay');//支付完成返回 同步
Route::post('/notifypay','OrderController@notifypay');//支付完成返回 异步


//用户首页
Route::get('user/','UserController@user');
Route::get('/user/order','UserController@order');
Route::get('/user/receiveAddress','UserController@receiveAddress');//收货地址列表
Route::get('/user/addressAdd','UserController@addressAdd');//收货地址添加页面
Route::get('/user/collect','UserController@collect');//我的收藏
Route::post('/user/selectArea','UserController@selectArea');//三级联动
Route::post('/user/addressDo','UserController@addressDo');//地址添加执行



//登录注册
Route::get('login/','LoginController@login');
Route::get('register/','LoginController@register');
Route::post('login/checkEmail','LoginController@checkEmail');//账号唯一性
Route::post('login/sendEmail','LoginController@sendEmail');//发送邮件
Route::post('login/registerDo','LoginController@registerDo');//注册
//跳转登录
Route::post('login/loginDo','LoginController@loginDo');//登录



