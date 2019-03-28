<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>全部商品</title>
    <link rel="shortcut icon" href="/leading/images/favicon.ico" />
    <link href="/leading/css/bootstrap.min.css" rel="stylesheet">
    <link href="/leading/css/style.css" rel="stylesheet">
    <link href="/leading/css/response.css" rel="stylesheet">
   <script src="/leading/js/jquery.min.js"></script>
   <script src="/leading/js/bootstrap.min.js"></script>
   <script src="/leading/js/style.js"></script>
   <!--焦点轮换-->
   <script src="/leading/js/jquery.excoloSlider.js"></script>
   <script src="js/jquery-3.2.1.min.js"></script>
      <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <form action="#" method="get" class="prosearch"><input type="text" /></form>
      </div>
     </header>
     <ul class="pro-select">
      <li><a href="javascript:;" class="select" order_type="1" field="is_new">新品</a></li>
      <li><a href="javascript:;" class="select" order_type="2" field="goods_sales">销量</a></li>
      <li><a href="javascript:;" class="select" order_type="3" field="goods_price">价格</a></li>
     </ul>
     <div class="prolist">
      @foreach ($goodsInfo as $k=>$v)
      <dl>
       <dt><a href="goods/proinfo/{{$v->goods_id}}"><img src="http://blog.images.com/goodsImgs/{{$v->goods_img}}" width="100" height="100" /></a></dt>
       <dd>
        <h3><a href="goods/proinfo/{{$v->goods_id}}">{{$v->goods_name}}</a></h3>
        <div class="prolist-price"><strong>¥{{$v->goods_price}}</strong> <span>¥{{$v->goods_market}}</span></div>
        <div class="prolist-yishou"><span>5.0折</span> <em>已售：{{$v->goods_sales}}</em></div>
       </dd>
       <div class="clearfix"></div>
      </dl>
      @endforeach
     </div><!--prolist/-->

  @extends('layouts.footer')

<script>
    $(function(){
        $(".select").click(function(){
            var _this  = $(this);
            _this.parent().addClass('pro-selCur');
            _this.parent().siblings('li').removeClass('pro-selCur');

            var order_type = _this.attr('order_type');
            var field = _this.attr('field');
            if(order_type==1){
                var order = 'desc';//降序
            }else if(order_type==2){
                var order = 'desc';//降序
            }else if(order_type==3){
                var order = 'asc';//升序
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post(
                 "/goods/goodsList",
                {order_type:order_type,field:field,order:order},
                function(res){
                    $("body").html(res);
                }
            )
        });

    })
</script>