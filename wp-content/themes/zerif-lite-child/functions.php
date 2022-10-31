<?php

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_script( 'wpa-main-js', get_theme_file_uri( 'js/main.js' ), [], null, true );
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