<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>三级分销</title>
    <link rel="shortcut icon" href="/leading/images/favicon.ico" />
    <link href="/leading/css/bootstrap.min.css" rel="stylesheet">
    <link href="/leading/css/style.css" rel="stylesheet">
    <link href="/leading/css/response.css" rel="stylesheet">
    <script src="/leading/js/jquery.min.js"></script>
    <script src="/leading/js/bootstrap.min.js"></script>
    <script src="/leading/js/style.js"></script>
    <script src="/leading/js/jquery.excoloSlider.js"></script>
    <script src="/leading/js/jquery.spinner.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>产品详情</h1>
      </div>
     </header>
     <div id="sliderA" class="slider">
         @foreach ($goodsOneInfo['goods_imgs'] as $k=>$v)
         <img src="http://blog.images.com/goodsImgs/{{$v}}" />
         @endforeach
     </div><!--sliderA/-->
     <table class="jia-len" >
      <tr>
       <th><strong class="orange">{{$goodsOneInfo->goods_price}}</strong></th>
       <td >
        <input type="text" class="spinnerExample" id="number"/>
       </td>
      </tr>
      <tr>
       <td>
        <strong>{{$goodsOneInfo->goods_name}}</strong>
        <p class="hui"></p>
       </td>
       <td align="right">
        <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
       </td>
      </tr>
     </table>
     <div class="height2"></div>
     <h3 class="proTitle">商品规格</h3>
     <ul class="guige">
      <li class="guigeCur"><a href="javascript:;">50ML</a></li>
      <li><a href="javascript:;">100ML</a></li>
      <li><a href="javascript:;">150ML</a></li>
      <li><a href="javascript:;">200ML</a></li>
      <li><a href="javascript:;">300ML</a></li>
      <div class="clearfix"></div>
     </ul><!--guige/-->
     <div class="height2"></div>
     <div class="zhaieq">
      <a href="javascript:;" class="zhaiCur">商品简介</a>
      <a href="javascript:;">商品参数</a>
      <a href="javascript:;" style="background:none;">订购列表</a>
      <div class="clearfix"></div>
     </div><!--zhaieq/-->
     <div class="proinfoList">
      <img src="http://blog.images.com/goodsImgs/{{$goodsOneInfo->goods_img}}" width="636" height="822" />
     </div>
     <div class="proinfoList">
         {!!$goodsOneInfo->goods_desc!!}
     </div>
     <div class="proinfoList">
      订购列表
     </div>
     <table class="jrgwc" goods_id = {{$goodsOneInfo->goods_id}} goods_num={{$goodsOneInfo->goods_num}}>
      <tr>
       <th>
        <a href="/index"><span class="glyphicon glyphicon-home"></span></a>
       </th>
       <td><a href="javascript:;" id="addCar">加入购物车</a></td>
      </tr>
     </table>
    </div><!--maincont-->
  </body>
</html>

<script>
    $(function () {
        $("#sliderA").excoloSlider();
    });
    $('.spinnerExample').spinner({});

    $(function(){
        $("#number").blur(function(){
            var _this = $(this);
            var buy_number = _this.val();
            var goods_num =  $("#addCar").parents('table').attr('goods_num');
            var reg = /^[1-9]\d*$/;
            if(buy_number<=1){
                _this.val(1);
            }else if(!reg.test(buy_number)){
                _this.val(1);
            }else if(buy_number>goods_num){
                _this.val(goods_num);
            }
        });
        $("#addCar").click(function(){
            var buy_number = $("#number").val();
            var goods_id = $(this).parents('table').attr('goods_id');
            if(buy_number==0){
                alert('请选择商品购买数量');
                return false;
            }
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.post(
                '/shopcar/cartAdd',
                {buy_number:buy_number,goods_id:goods_id},
                function(res){
                    if(res=='ok'){
                        alert('加入购物车成功');
                        location.href = '/shopcar/';
                    }else{
                        alert('加入购物车失败');
                    }
                }
            );
            return false;
        })

    })
</script>