<!DOCTYPE html>
<html lang="zh-cn">
   <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>主页</title>
    <link rel="shortcut icon" href="/leading/images/favicon.ico" />
    <link href="/leading/css/bootstrap.min.css" rel="stylesheet">
    <link href="/leading/css/style.css" rel="stylesheet">
    <link href="/leading/css/response.css" rel="stylesheet">
    <script src="/leading/js/jquery.min.js"></script>
    <script src="/leading/js/bootstrap.min.js"></script>
    <script src="/leading/js/style.js"></script>
    <script src="/leading/js/jquery.excoloSlider.js"></script>

   </head>
   <body>
   <div class="maincont">
    <div class="head-top">
     <img src="/leading/images/head.jpg" />
     <dl>
      <dt><a href="user"><img src="/leading/images/touxiang.jpg" /></a></dt>
      <dd>
       <h1 class="username">会员</h1>
       <ul>
        <li><a href="goods"><strong>34</strong><p>全部商品</p></a></li>
        <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
        <li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
        <div class="clearfix"></div>
       </ul>
      </dd>
      <div class="clearfix"></div>
     </dl>
    </div><!--head-top/-->
    <form action="#" method="get" class="search">
     <input type="text" class="seaText fl" />
     <input type="submit" value="搜索" class="seaSub fr" />
    </form><!--search/-->
    <ul class="reg-login-click">
     <li><a href="login">登录</a></li>
     <li><a href="register" class="rlbg">注册</a></li>
     <div class="clearfix"></div>
    </ul><!--reg-login-click/-->
    <div id="sliderA" class="slider">
     <img src="/leading/images/image1.jpg" />
     <img src="/leading/images/image2.jpg" />
     <img src="/leading/images/image3.jpg" />
     <img src="/leading/images/image4.jpg" />
     <img src="/leading/images/image5.jpg" />
    </div><!--sliderA/-->
    <ul class="pronav">
     <li><a href="prolist.html">干红</a></li>
     <li><a href="prolist.html">手链</a></li>
     <li><a href="prolist.html">手镯</a></li>
     <li><a href="prolist.html">戒指</a></li>
     <div class="clearfix"></div>
    </ul><!--pronav/-->

    <div class="index-pro1">
    @foreach ($goodsInfo as $k=>$v)
         <div class="index-pro1-list">
         <dl>
              <dt><a href="/goods/proinfo/{{$v->goods_id}}"><img src="http://blog.images.com/goodsImgs/{{$v->goods_img}}" /></a></dt>
              <dd class="ip-text"><a href="/goods/proinfo/{{$v->goods_id}}">{{$v->goods_name}}</a><span>已售:{{$v->goods_sales}}</span></dd>
              <dd class="ip-price"><strong>¥{{$v->goods_price}}</strong> <span>¥{{$v->goods_market}}</span></dd>
         </dl>
         </div>
    @endforeach
    </div>

    <div class="prolist">
     <dl>
      <dt><a href="proinfo.html"><img src="/leading/images/prolist1.jpg" width="100" height="100" /></a></dt>
      <dd>
       <h3><a href="proinfo.html">四叶草</a></h3>
       <div class="prolist-price"><strong>¥299</strong> <span>¥599</span></div>
       <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
      </dd>
      <div class="clearfix"></div>
     </dl>
    </div>

    {{--<div class="joins"><a href="sales"><img src="/leading/images/jrwm.jpg" /></a></div>--}}
    <div class="copyright">Copyright &copy; <span class="blue">the end</span></div>

    @extends('layouts.footer')

    <script>
        $(function () {
            $("#sliderA").excoloSlider();
        });
    </script>