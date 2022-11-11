<?php

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

function my_theme_enqueue_styles() {
    $my_js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . `js/main.js` ));

    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );

    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/style.css' );
    
    //wp_enqueue_script( 'wpa-main-js', get_theme_file_uri( 'js/main.js' ), [], null, true );

    //wp_enqueue_script( 'wpa-main-js', get_stylesheet_directory_uri() . '/js/main.js', array(), time(), true );

    wp_enqueue_script( 'wpa-main-js', get_stylesheet_directory_uri() . '/js/main.js', array(), 6, true );
}