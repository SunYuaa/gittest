<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>收货地址添加</title>
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
            <h1>收货地址</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/leading/images/head.jpg" />
    </div><!--head-top/-->
    <form action="" method="get" class="reg-login">
        <div class="lrBox">
            <div class="lrList"><input type="text" placeholder="收货人" id="address_name"/></div>
            <div class="lrList"><input type="text" placeholder="详细地址" id="address_detail"/></div>
            <div class="lrList">
                <select class="area" id="province">
                    <option value="">省份</option>
                    @foreach ($province as $k=>$v)
                        <option value="{{$v->id}}">{{$v->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="lrList">
                <select class="area" id="city">
                    <option value="">直辖市</option>
                </select>
            </div>
            <div class="lrList">
                <select class="area" id="county">
                    <option value="">区县</option>
                </select>
            </div>
            <div class="lrList"><input type="text" placeholder="手机" id="address_tel"/></div>
            <div class="lrList2"><input type="checkbox" id="is_default"><button>设为默认</button></div>
        </div>
        <div class="lrSub">
            <input type="submit" value="保存" />
        </div>
    </form>

@extends('layouts.footer')
<script>
    $(function(){
        //三级联动
        $(document).on('change','.area',function(){
            var _this = $(this);
            var id = _this.val();
            var _option = "<option value='0'>直辖市区县</option>";
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.post(
                "/user/selectArea",
                {id:id},
                function(res){
                    for(var i in res){
                        _option+="<option value='"+res[i]['id']+"'>"+res[i]['name']+"</option>";
                        _this.parent('div').nextAll('div').find('select').html(_option);
                    }
                },
                'json'
            )
        });

        //地址添加
        $(":submit").click(function(){
            var obj = {};
            obj.province = $("#province").val();
            obj.city = $("#city").val();
            obj.county = $("#county").val();
            obj.address_name = $("#address_name").val();
            obj.address_tel = $("#address_tel").val();
            obj.address_detail = $("#address_detail").val();

            var is_default = $(":checkbox").prop('checked');
            if(is_default==true){
                obj.is_default=1;
            }else{
                obj.is_default=2;
            }

            //验证
            if(obj.province==''){
                alert('请选择一个省份');
                return false;
            }
            if(obj.city==''){
                alert('请选择一个城市');
                return false;
            }
            if(obj.county==''){
                alert('请选择一个地区');
                return false;
            }

            if(obj.address_name==''){
                alert('收货人姓名必填');
                return false;
            }
            var reg = /^1[35789]\d{9}$/;
            if(obj.address_tel==''){
                alert('联系电话必填');
                return false;
            }else if(!reg.test(obj.address_tel)){
                alert('请填写正确联系方式');
                return false;
            }
            if(obj.address_detail==''){
                alert('详细地址必填');
                return false;
            }

            //提交
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.post(
                '/user/addressDo',
                obj,
                function(res){
                    if(res==1){
                        alert('添加成功');
                        history.go(-1);
                    }else{
                        alert('添加失败');
                    }
                }
            );

            return false;
        })
    })
</script>