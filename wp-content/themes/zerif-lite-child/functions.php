<?php

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

function my_theme_enqueue_styles() {
    $my_js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . `js/main.js` ));

    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_script( 'wpa-main-js', get_theme_file_uri( 'js/main.js?v=1' ), [], null, true );
    //wp_enqueue_script( 'main_js', plugins_url( 'js/main.js', __FILE__ ), array(), $my_js_ver );
    
    /*
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
                      array( 'twenty-twenty-two-style' ), 
                      wp_get_theme()->;get('Version') );
    );*/
}

/*
function twentytwentyone_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
    array( 'twenty-twenty-two-style' ), wp_get_theme()->;get('Version') );
}

add_action( 'wp_enqueue_scripts', 'twentytwentytwo_styles');
*/