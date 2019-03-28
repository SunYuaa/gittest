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
        <div class="dingdanlist">
            <table>
                <tr onClick="window.location.href='/user/addressAdd'">
                    <td class="dingimg" width="75%" colspan="2">新增收货地址</td>
                    <td align="right"><img src="/leading/images/jian-new.png" /></td>
                </tr>
                <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
                <tr>
                    <td width="75%" colspan="2">
                        选择收货地址
                        <select>
                            @foreach($addressInfo as $k=>$v)
                            <option value="{{$v->address_id}}">{{$v->address_detail}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
                <tr>
                    <td class="dingimg" width="75%" colspan="2">支付方式</td>
                    <td align="right"><span class="hui">支付宝</span></td>
                </tr>
                <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>

                <tr>
                    <td class="dingimg" width="75%" colspan="3">商品清单</td>
                </tr>
                @foreach($goodsInfo as $k=>$v)
                <div>
                    <tr goods_id="{{$v->goods_id}}" class='goods_id'>
                        <td class="dingimg" width="15%"><img src="http://blog.images.com/goodsImgs/{{$v->goods_img}}" /></td>
                        <td width="50%">
                            <h3>{{$v->goods_name}}</h3>
                            <time>下单时间：{{date('Y/m/d H:i:s',$v->buy_time)}}</time>
                        </td>
                        <td align="right"><span class="qingdan">X {{$v->buy_number}}</span></td>
                    </tr>
                    <tr>
                        <th colspan="3"><strong class="orange">¥{{$v->goods_price*$v->buy_number}}</strong></th>
                    </tr>
                </div>
                @endforeach

                <tr>
                    <td class="dingimg" width="75%" colspan="2">商品金额</td>
                    <td align="right"><strong class="orange">¥<span class="priceCount">{{$priceCount}}</span></strong></td>
                </tr>

            </table>
        </div>


    </div>

    <div class="height1"></div>
    <div class="gwcpiao">
        <table>
            <tr>
                <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
                <td width="50%">总计：<strong class="orange">¥{{$priceCount}}</strong></td>
                <td width="40%"><a href="javascript:;" class="jiesuan">提交订单</a></td>
            </tr>
        </table>
    </div>
    </div>
    </body>
</html>
<script>
    $('.spinnerExample').spinner({});

    //提交
    $(".jiesuan").click(function(){
        var goods_id = '';
        $(".goods_id").each(function(index){
            goods_id += $(this).attr('goods_id')+',';
        });
        goods_id = goods_id.substr(0,goods_id.length-1);

        var address_id;
        $("option").each(function(index){
            if($(this).prop('selected')==true){
                address_id = $(this).val();
            }
        });

        var order_type = $(".hui").text();
        if(order_type=='支付宝'){
            order_type=1;
        }

        var priceCount = $(".priceCount").text();

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.post(
            "/order/orderDo",
            {goods_id:goods_id,address_id:address_id,priceCount:priceCount,order_type:order_type},
            function(res){
                if(res=='ok'){
                    alert('提交订单成功');
                    location.href = '/order/successOrder';
                }else{
                    alert('提交订单失败')
                }
            }
        )
    })
</script>