<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>三级分销</title>
    <link rel="shortcut icon" href="/leading/images/favicon.ico" />

    <!-- Bootstrap -->
    <link href="/leading/css/bootstrap.min.css" rel="stylesheet">
    <link href="/leading/css/style.css" rel="stylesheet">
    <link href="/leading/css/response.css" rel="stylesheet">
    <script src="/leading/js/jquery.min.js"></script>
    <script src="/leading/js/bootstrap.min.js"></script>
    <script src="/leading/js/style.js"></script>
    <script src="/leading/js/jquery.spinner.js"></script>
</head>
<body>
<div class="maincont">
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>购物车</h1>
        </div>
    </header>
    <div class="susstext">订单提交成功</div>
    <div class="sussimg">&nbsp;</div>
    <div class="dingdanlist">
        <table>
            <tr>
                <td width="50%">
                    <h3>订单号：{{$orderInfo->order_no}}</h3>
                    <time>创建日期：{{date('Y/m/d H:i:s',$orderInfo->created_at)}}<br />
                        失效日期：{{date('Y/m/d H:i:s',$orderInfo->updated_at)}}</time>
                    <strong class="orange">¥{{$orderInfo->order_amount}}</strong>
                </td>

                <td align="right"><span class="orange">等待支付</span></td>
            </tr>
        </table>
    </div><!--dingdanlist/-->
    <div class="succTi orange">请您尽快完成付款，否则订单将被取消</div>

</div><!--content/-->

<div class="height1"></div>
<div class="gwcpiao">
    <table>
        <tr>
            <td width="50%"><a href="/goods/" class="jiesuan" style="background:#5ea626;">继续购物</a></td>
            <td width="50%"><a href="/alipay/{{$orderInfo->order_no}}" class="jiesuan">立即支付</a></td>
        </tr>
    </table>
</div>
</div>

<script>
    $('.spinnerExample').spinner({});
</script>
</body>
</html>