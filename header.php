<!doctype html>
<html lang="zh-hans">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="robots" content="index,follow">
    <meta name="applicable-device" content="pc,mobile">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
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
                <a href="<?php echo home_url(); ?>" >w候人兮猗</a>
            </h2>
            <nav id="nav" class=" fr clear">
                <?php wp_nav_menu(array('theme_location' => 'top','menu_class'=>'nav-menu top-menu fl','container'=>'ul')); ?>
            </nav>

            <nav id="mobie-nav">
                <button class="nav-btn">
                    <?php wp_nav_menu(array('theme_location' => 'top','menu_class'=>'nav-menu top-menu fl','container'=>'ul')); ?>
                </button>
            </nav>
        </div>
    </header>
