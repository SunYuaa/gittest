<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>微商城</title>
    <link rel="shortcut icon" href="/leading/images/favicon.ico" />
    <!-- Bootstrap -->
    <link href="/leading/css/bootstrap.min.css" rel="stylesheet">
    <link href="/leading/css/style.css" rel="stylesheet">
    <link href="/leading/css/response.css" rel="stylesheet">
      <script src="/leading/js/jquery.min.js"></script>
      <script src="/leading/js/bootstrap.min.js"></script>
      <script src="/leading/js/style.js"></script>
      <script src="/leading/js/jquery.spinner.js"></script>
      <script src="/js/jquery-3.2.1.min.js"></script>
  </head>
  <body>


    <div class="maincont">
     <div class="userName">
      <dl class="names">
       <dt><img src="/leading/images/user01.png" /></dt>
       <dd>
        <h3>{{$userInfo}}</h3>
       </dd>
       <div class="clearfix"></div>
      </dl>
      <div class="shouyi">
       <dl>
        <dt>我的余额</dt>
        <dd>0.00元</dd>
       </dl>
       <dl>
        <dt>我的积分</dt>
        <dd>0</dd>
       </dl>
       <div class="clearfix"></div>
      </div><!--shouyi/-->
     </div><!--userName/-->
     
     <ul class="userNav">
      <li><span class="glyphicon glyphicon-list-alt"></span><a href="user/order">我的订单</a></li>
      <div class="height2"></div>
      <div class="state">
         <dl>
          <dt><a href="/user/order"><img src="/leading/images/user1.png" /></a></dt>
          <dd><a href="/user/order">待支付</a></dd>
         </dl>
         <dl>
          <dt><a href="/user/order"><img src="/leading/images/user2.png" /></a></dt>
          <dd><a href="/user/order">代发货</a></dd>
         </dl>
         <dl>
          <dt><a href="/user/order"><img src="/leading/images/user3.png" /></a></dt>
          <dd><a href="/user/order">待收货</a></dd>
         </dl>
         <dl>
          <dt><a href="/user/order"><img src="/leading/images/user4.png" /></a></dt>
          <dd><a href="/user/order">全部订单</a></dd>
         </dl>
         <div class="clearfix"></div>
      </div><!--state/-->
      <li><span class="glyphicon glyphicon-usd"></span><a href="/user/ticket">我的优惠券</a></li>
      <li><span class="glyphicon glyphicon-map-marker"></span><a href="/user/receiveAddress">收货地址管理</a></li>
      <li><span class="glyphicon glyphicon-star-empty"></span><a href="/user/collect">我的收藏</a></li>
      <li><span class="glyphicon glyphicon-heart"></span><a href="">我的浏览记录</a></li>
      <li><span class="glyphicon glyphicon-usd"></span><a href="">余额提现</a></li>
	 </ul><!--userNav/-->
     
     <div class="lrSub">
       <a href="login/logout/">退出登录</a>
     </div>

@extends('layouts.footer')