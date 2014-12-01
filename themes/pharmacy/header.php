<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head <?php language_attributes(); ?>>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/normalize.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/main.css">
    <script src="<?php echo get_template_directory_uri(); ?>/js/vendor/modernizr-2.6.2.min.js"></script>

    <!-- typekit fonts -->
    <script src="//use.typekit.net/eol0cqi.js"></script>
    <script>try{Typekit.load();}catch(e){}</script>

    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>

    <?php wp_head(); ?>
</head>
<body <?php body_class('woocommerce'); ?>>

<div id="page" class="hfeed site">
    <div id="top-navigation">
        <?php wp_nav_menu( array( 'theme_location' => 'top_nav', 'menu_class' => 'nav-menu clearfix' ) ); ?>
    </div>
    <header id="masthead" class="site-header" role="banner">
        <hgroup>
            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
        </hgroup>

        <nav id="site-navigation" class="main-navigation clearfix" role="navigation">
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu clearfix' ) ); ?>
        </nav><!-- #site-navigation -->

        <?php $header_image = get_header_image();
        if ( ! empty( $header_image ) ) : ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
        <?php endif; ?>

         <?php if(is_front_page()) : ?>
            <div id="sliderWrapper" class="fullWidth">
                <div id="slider" class="centered">
                    <img src="<?php  ?>" alt="">
                    <p>Welcome to impact pharmacy online</p>
                </div>
            </div>
        <?php endif; ?>
    </header><!-- #masthead -->

    <div id="main" class="wrapper clearfix">