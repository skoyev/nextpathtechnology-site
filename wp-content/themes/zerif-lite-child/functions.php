<?php

$email_key = generateRandomString();

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

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

        if($_POST['email_key'] === $email_key) {

            $success = wp_mail('info@nextpathtechnology.com', 'test subject', 'test content');

            $data = ['status' => $success ? 'success' : 'failed', 'email_key' => $_POST['email_key']];

            echo json_encode($data);
        } else {
            $data = ['status' => 'failed'];

            echo json_encode($data);
        }
        
        wp_die(); 
}

add_action('wp_head', 'myplugin_ajaxurl');

function myplugin_ajaxurl() {
    global $email_key;

    echo '<script type="text/javascript">
           var ajaxUrl = "' . admin_url('admin-ajax.php') . '";
           var email_key = "' . $email_key . '";
         </script>';
}

