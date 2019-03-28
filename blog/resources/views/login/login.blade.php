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
    <script src="/js/jquery-3.2.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="maincont">
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>会员注册</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/leading/images/head.jpg" />
    </div>
    <form action="" method="get" class="reg-login">
        <h3>还没有三级分销账号？点此<a class="orange" href="register">注册</a></h3>
        <div class="lrBox">
            @if (Session::has('userInfo')!=null)
            <div class="lrList"><input type="text" placeholder="输入手机号码或者邮箱号" value="{{Session::get('userInfo.user_name')}}"/></div>
            @elseif (Session::has('userInfo')==null)
            <div class="lrList"><input type="text" placeholder="输入手机号码或者邮箱号" /></div>
            @endif
            <div class="lrList"><input type="password" placeholder="输入密码" /></div>
        </div>
        <div class="lrSub">
            <input type="submit" value="立即登录" />
        </div>
    </form>
  @extends('layouts.footer')

<script>
    $(function(){
        $(":submit").click(function(){
            var user_email = $(":text").val();
            var user_pwd = $(":password").val();
            if(user_email==''){
                alert('账号不能为空');
                return false;
            }
            if(user_pwd==''){
                alert('密码不能为空');
                return false;
            }
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.post(
                "login/loginDo",
                {user_email:user_email,user_pwd:user_pwd},
                function(res){
                    if(res=='ok'){
                        alert('登录成功');
                        location.href = 'user/';
                    }else{
                        alert('登录失败');
                    }
                }
            );
            return false;
        });

    })
</script>