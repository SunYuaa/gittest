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
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="/leading/js/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="/leading/js/bootstrap.min.js"></script>
      <script src="/leading/js/style.js"></script>
      <!--jq加减-->
      <script src="/leading/js/jquery.spinner.js"></script>
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
     <table class="shoucangtab">
      <tr>
       <td width="75%"><a href="/user/addressAdd" class="hui"><strong class="">+</strong> 新增收货地址</a></td>
       <td width="25%" align="center" style="background:#fff url(/leading/images/xian.jpg) left center no-repeat;"><a href="javascript:;" class="orange">删除信息</a></td>
      </tr>
     </table>
     
     <div class="dingdanlist" onClick="window.location.href='proinfo.html'">
      <table>
       
       <tr>
        <td width="50%">
         <h3>张先生 185444171241</h3>
         <time>上海普陀区曹杨路1040弄中友大厦19楼</time>
        </td>
        <td align="right"><a href="address.html" class="hui"><span class="glyphicon glyphicon-check"></span> 修改信息</a></td>
       </tr>
      </table>
     </div><!--dingdanlist/-->
 @extends('layouts.footer')