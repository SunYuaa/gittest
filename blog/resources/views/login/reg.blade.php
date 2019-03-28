<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="Author" contect="http://www.webqin.net">
        <title>注册</title>
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
        </div><!--head-top/-->
        <form action="" method="get" class="reg-login">
            <h3>已经有账号了？点此<a class="orange" href="login">登陆</a></h3>
            <div class="lrBox">
                <div class="lrList"><input type="text" id="user_email" placeholder="输入手机号码或者邮箱号" /></div>
                <div class="lrList2"><input type="text" id="code" placeholder="输入验证码" /><span style="background-color:pink;" id="sendEmailCode">获取验证码</span></div>
                <div class="lrList"><input type="password" id="user_pwd" placeholder="设置新密码（6-18位数字或字母）" /></div>
                <div class="lrList"><input type="password" id="repwd" placeholder="再次输入密码" /></div>
            </div>
            <div class="lrSub">
                <input type="submit" value="立即注册" />
            </div>
        </form><!--reg-login/-->

    @extends('layouts.footer')

<script>
    $(function(){
        //点击获取按钮
        var emailFlag = false;
        $("#sendEmailCode").click(function(){
            //获取邮箱信息 进行验证
            var user_email = $("#user_email").val();
            var email_reg = /^\w+@\w+\.com$/;
            if(user_email==''){
                alert('请输入手机号码或者邮箱号');
                return false;
            }else if(!email_reg.test(user_email)){
                alert('请输入有效邮箱');
                return false;
            }else{
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
                $.ajax({
                    type:'post',
                    url:'/login/checkEmail',
                    data:{user_email:user_email},
                    async:false,
                    dataType:'json',
                    success:function(res) {
                        if (res == 1) {
                            alert('账号已存在');
                            emailFlag = false;
                        } else {
                            emailFlag = true;
                        }
                    }
                })
                if(emailFlag == false){
                    return emailFlag;
                }

            }
            //秒数倒计时
            $("#sendEmailCode").text(10+'s');
            //计时
            _time = setInterval(secondGo,1000);

            //发送邮件
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.post(
                'login/sendEmail',
                {user_email:user_email},
                function(res){
                    if(res=='no'){
                        alert('发送失败');
                    }else{
                       alert('发送成功');
                    }
                }
            )

            //计时器
            function secondGo(){
                var button = $("#sendEmailCode");
                var second = parseInt(button.text());
                if(second==0){
                    button.text('获取验证码');
                    clearInterval(_time);
                    button.css("pointer-events",'auto');
                }else{
                    second = second-1;
                    button.text(second+'s');
                    button.css("pointer-events",'none');
                }
            }
        });

        //点击注册
        $(":submit").click(function(){
            var user_pwd = $("#user_pwd").val();
            var repwd = $("#repwd").val();
            var user_email = $("#user_email").val();
            var code = $("#code").val();
            var pwd_reg = /^[A-Za-z0-9]{6,12}$/;
            if(user_pwd == ''){
                alert('请输入密码');
                return false;
            }else if(!pwd_reg.test(user_pwd)){
                alert('密码必须为6-18位数字或字母）');
                return false;
            }else if(repwd!=user_pwd){
                alert('确认密码必须和密码一致');
                return false;
            }else{
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
                $.post(
                    'login/registerDo',
                    {user_pwd:user_pwd,repwd:repwd,user_email:user_email,code:code},
                    function(res){
                        if(res=='ok'){
                            alert('注册成功');
                            location.href = 'login/login';
                        }else{
                            alert('注册失败');
                        }
                    }
                )
            }
            return false;
        })
    })
</script>