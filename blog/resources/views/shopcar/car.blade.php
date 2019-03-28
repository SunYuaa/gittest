<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>购物车</title>
    <link rel="shortcut icon" href="/leading/images/favicon.ico" />
    <link href="/leading/css/bootstrap.min.css" rel="stylesheet">
    <link href="/leading/css/style.css" rel="stylesheet">
    <link href="/leading/css/response.css" rel="stylesheet">
    <script src="/leading/js/jquery.min.js"></script>
    <script src="/leading/js/bootstrap.min.js"></script>
    <script src="/leading/js/style.js"></script>
    <script src="/leading/js/jquery.spinner.js"></script>
      <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>购物车</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/leading/images/head.jpg" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><span class="hui">购物车共有：<strong class="orange">{{$count}}</strong>件商品</span></td>
       <td width="25%" align="center" style="background:#fff url(/leading/images/xian.jpg) left center no-repeat;">
        <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
       </td>
      </tr>
     </table>

     <div class="dingdanlist">
         <table>
             <tr>
                 <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" name="1" id="box"/> 全选</a></td>
             </tr>
             @foreach ($cartInfo as $k=>$v)
             <div class="goods">
                 <tr goods_id={{$v->goods_id}}>
                     <td width="4%"><input type="checkbox" name="1" class='box' /></td>
                     <td class="dingimg" width="15%"><img src="http://blog.images.com/goodsImgs/{{$v->goods_img}}" /></td>
                     <td width="50%">
                         <h3>{{$v->goods_name}}</h3>
                         <time>下单时间：{{date("Y/m/d H:i:s",$v->buy_time)}}</time>
                     </td>
                     <td align="right" goods_num={{$v->goods_num}} goods_id={{$v->goods_id}} goods_price={{$v->goods_price}}>
                         <input type="text" class="spinnerExample"/>
                     </td>
                     <td style="display:none" class="number">{{$v->buy_number}}</td>
                 </tr>
                 <tr>
                     <th colspan="4">
                         <strong class="orange">¥{{$v->buy_number*$v->goods_price}}</strong>
                         <p align="right"><a href="javascript:;" class="del">删除</a></p>
                     </th>
                 </tr>
             </div>
             @endforeach
         </table>
     </div>


     <div class="height1"></div>
     <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="orange" id="price">¥0</strong></td>
       <td width="40%"><a href="javascript:;" class="jiesuan">去结算</a></td>
      </tr>
     </table>
    </div>
    </div>
</body>
</html>

<script>
    $('.spinnerExample').spinner({});

    $(".number").each(function(index){
        var value = $(this).text();
        $(this).prev().find('input').val(value);
    });
    //小计
    function getTotal(_this,goods_price,buy_number){
        var total = goods_price*buy_number;
        _this.parents('tr').next('tr').find('strong').text('¥'+total);
    }
    //总价
    function priceCount(){
        var box = $('.box');
        var goods_id = '';
        box.each(function(index){
            if($(this).prop('checked')==true){
                goods_id+= $(this).parents('tr').attr('goods_id')+',';
            }
        });
        goods_id = goods_id.substr(0,goods_id.length-1);
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.post(
            "/shopcar/priceCount",
            {goods_id:goods_id},
            function(res){
                $("#price").text('¥'+res);
            }
        );
    }

    //点击减号
    $(".decrease").click(function(){
        var _this = $(this);
        var buy_number =  _this.next().val();
        var goods_id = _this.parents('td').attr('goods_id');
        var goods_price = parseInt(_this.parents('td').attr('goods_price'));

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.post(
            "/shopcar/changeNum",
            {goods_id:goods_id,buy_number:buy_number},
            function(res){
                getTotal(_this,goods_price,buy_number);
                priceCount();
            }
        )

    });
    //点击加号
    $(".increase").click(function(){
        var _this = $(this);
        var buy_number =  _this.prev().val();
        var goods_id = _this.parents('td').attr('goods_id');
        var goods_price = parseInt(_this.parents('td').attr('goods_price'));

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.post(
            "/shopcar/changeNum",
            {goods_id:goods_id,buy_number:buy_number},
            function(res){
                getTotal(_this,goods_price,buy_number);
                priceCount();
            }
        )
    });
    //失焦
    $(".spinnerExample").blur(function(){
        var _this = $(this);
        var buy_number = $(this).val();
        var goods_id = _this.parents('td').attr('goods_id');
        var goods_num = _this.parents('td').attr('goods_num');
        var goods_price = parseInt(_this.parents('td').attr('goods_price'));
        console.log(buy_number);
        console.log(goods_num);
        var reg = /^[1-9]\d*$/;
        if(buy_number<=1||buy_number==''){
            _this.val(1);
            buy_number=1;
        }else if(!reg.test(buy_number)){
            _this.val(1);
            buy_number =1;
        }else if(buy_number >= goods_num){
            _this.val(buy_number);
        }
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.post(
            "/shopcar/changeNum",
            {goods_id:goods_id,buy_number:buy_number},
            function(res){
                getTotal(_this,goods_price,buy_number);
                priceCount();
            }
        )
    });

    //全选
    $("#box").click(function(){
        var box = $(this).prop('checked');
        $(".box").prop('checked',box);
        priceCount();
    });
    //点击复选框
    $(".box").click(function(){
        priceCount();
    });

    //删除
    $(".del").click(function(){
        var _this = $(this);
        var goods_id = _this.parents('tr').prev('tr').attr('goods_id');
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.post(
            "shopcar/cartDel",
            {goods_id:goods_id},
            function(res){
                if(res=='ok') {
                    _this.parents('tr').prev('tr').remove();
                    _this.parents('tr').remove();
                }
            }
        );
    });

    //结算
    $(".jiesuan").click(function(){
        var res = checkLogin();
        if(res==true){
            var box = $('.box');
            var goods_id = '';
            box.each(function(index){
                if($(this).prop('checked')==true){
                    goods_id+= $(this).parents('tr').attr('goods_id')+',';
                }
            });
            goods_id = goods_id.substr(0,goods_id.length-1);

            if(goods_id==''){
                alert('请至少选择一个商品');
                return false;
            }
            location.href = '/Order/pay/'+goods_id;
        }else{
            alert('请先登录');
            location.href = 'login/';
        }
    });
    //是否登录
    function checkLogin(){
        var status;
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: 'post',
            url: "shopcar/checkLogin",
            async: false,
            dataType: 'json'
        }).done(function(res){
                if(res==1){
                    status = true;
                }else{
                    status = false;
                }
        });
        return status;
    }
</script>
