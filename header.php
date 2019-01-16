<!doctype html>
<html lang="zh-hans">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="robots" content="index,follow">
    <meta name="applicable-device" content="pc,mobile">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<meta name=”apple-mobile-web-app-title” content=w候人兮猗>

<meta name=”apple-mobile-web-app-capable” content=”yes”/>  



<meta name=”apple-itunes-app” content=”app-id=myAppStoreID, affiliate-data=myAffiliateData, app-argument=myURL”>


<meta name=”apple-mobile-web-app-status-bar-style” content=”black”/>

<meta name=”format-detection” content=”telphone=no, email=no”/>  

<meta name=”renderer” content=”webkit”>  

<meta http-equiv=”X-UA-Compatible” content=”IE=edge”>    

<meta http-equiv=”Cache-Control” content=”no-siteapp” />    

<meta name=”HandheldFriendly” content=”true”>    

<meta name=”MobileOptimized” content=”320″>   

<meta name=”screen-orientation” content=”portrait”>   

<meta name=”x5-orientation” content=”portrait”>   

<meta name=”full-screen” content=”yes”>             

<meta name=”x5-fullscreen” content=”true”>      

<meta name=”browsermode” content=”application”>  

<meta name=”x5-page-mode” content=”app”>    

<meta name=”msapplication-tap-highlight” content=”no”>
    <title><?php wp_title( '&#8211;', true, 'right'); ?></title>
    <meta itemprop="image"  content="https://static.ahwgs.cn/wp-content/uploads/2018/02/2018022209020469-300x290.jpg" />
    <?php wp_head(); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/gitalk@1/dist/gitalk.css">
    <script src="https://cdn.jsdelivr.net/npm/gitalk@1/dist/gitalk.min.js"></script>
  <style type="text/css">
    	#entry-content img{cursor: pointer;}
    .close_bgmask{
    display:none}
    </style>
</head>
<body <?php body_class(); ?>>
    <header class="header" id="header">
        <div id="header-wrap">
            <h2 id="logo" class="fl">
                <a href="<?php echo home_url(); ?>" ><?php bloginfo('name'); ?></a>
            </h2>
            <nav id="nav" class=" fr clear">
                <?php wp_nav_menu(array('theme_location' => 'top','menu_class'=>'nav-menu top-menu fl','container'=>'ul')); ?>
            </nav>

            <nav id="mobie-nav">
				<div class="nav-btn">Menu</div>
                <div class="nav-btn-active">
                    <?php wp_nav_menu(array('theme_location' => 'top','menu_class'=>'nav-menu top-menu fl','container'=>'ul')); ?>
                </div>
            </nav>
        </div>
    </header>
