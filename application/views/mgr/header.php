<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $site_title; ?></title>
  <meta name="description" content="<?php echo $site_description; ?>">
  <meta name="keywords" content="<?php echo $site_keywords; ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="<?php echo ROOTPATH;?>assets/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="<?php echo ROOTPATH;?>assets/i/app-icon72x72@2x.png">
  <link rel="stylesheet" href="<?php echo ROOTPATH;?>assets/css/amazeui.min.css"/>
  <link rel="stylesheet" href="<?php echo ROOTPATH;?>assets/css/admin.css">
</head>
<body>

<header class="am-topbar admin-header">
  <div class="am-topbar-brand">
    <strong>通明开放平台</strong> <small>微信开放平台集成化专家</small>
  </div>

  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
      <li><a href="javascript:;"><span class="am-icon-envelope-o"></span> 收件箱 <span class="am-badge am-badge-warning">...</span></a></li>
      <li class="am-dropdown" data-am-dropdown>
        <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
          <span class="am-icon-users"></span> 我的帐号 <span class="am-icon-caret-down"></span>
        </a>
        <ul class="am-dropdown-content">
          <li><a href="#"><span class="am-icon-user"></span> 资料</a></li>
          <li><a href="#"><span class="am-icon-cog"></span> 设置</a></li>
          <li><a href="#"><span class="am-icon-power-off"></span> 退出</a></li>
        </ul>
      </li>
      <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
    </ul>
  </div>
</header>
  <!--[if lte IE 9]>
<p style="border:1px solid #eee; margin:0px; text-align:center">尊敬的用户：您正在使用<strong>过时并已被淘汰</strong>的浏览器，访问本系统会有一定兼容性问题。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->

