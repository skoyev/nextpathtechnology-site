<?php

$email_key = '';

function my_theme_enqueue_styles() {
    $my_js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . `js/main.js` ));

    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );

    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/style.css', array(), time() );

    //$parent_style = 'parent-style';

    //wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    /*wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array(),
        '1.1'
    );  */  
    
    //wp_enqueue_script( 'wpa-main-js', get_theme_file_uri( 'js/main.js' ), [], null, true );

    wp_enqueue_script( 'wpa-main-js', get_stylesheet_directory_uri() . '/js/main.js', array(), time(), true );

    //wp_enqueue_script( 'wpa-main-js', get_stylesheet_directory_uri() . '/js/main.js', array(), 6, true );  
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

// if you want none logged in users to access this function use this hook
add_action( 'wp_ajax_get_data', 'get_data' );
add_action( 'wp_ajax_nopriv_get_data', 'get_data');

function get_data() {
    //if ( isset($_POST['action']) && 
      //      $_POST['action'] == "send_email" ) {
        global $email_key;  

        $success = wp_mail('info@nextpathtechnology.com', 'test subject', 'test content');

        //echo $email_key;

        echo 'Return';

        //if ($succsess) return true
        //else return false;   
        
        wp_die(); 
    //} 
}

add_action('wp_head', 'myplugin_ajaxurl');

function myplugin_ajaxurl() {
    global $email_key;

    $email_key = 'test123';

    echo '<script type="text/javascript">
           var ajaxUrl = "' . admin_url('admin-ajax.php') . '";
           alert("' . $email_key . '");
         </script>';
}

