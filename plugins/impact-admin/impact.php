<?php

/*
Plugin Name: Impact Pharmacy Admin Theme
Plugin URI: http://www.KonvergeStudios.com
Description: Impact Pharmacy Admin Theme Skin
Author: Ranga Mapuvire
Version: 1.0
Author URI: http://www.KonvergeStudios.com
*/

function impact_admin_theme_style() {
    wp_enqueue_style('impact-admin-theme', plugins_url('wp-impact-admin.css', __FILE__));
}

add_action('admin_enqueue_scripts', 'impact_admin_theme_style');
add_action('login_enqueue_scripts', 'impact_admin_theme_style');

?>