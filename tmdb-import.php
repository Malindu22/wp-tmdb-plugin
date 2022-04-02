<?php
/*
Plugin Name:  TMDB-impoter Plugin 
Plugin URI:   https://github.com/Malindu22/wp-tmdb-plugin 
Description:  Intigrate with TMDB Api. 
Version:      1.0
Author:       Malindu Gimhan 
Author URI:   https://www.facebook.com/malindu.gimhan
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  plugin url
Domain Path:  
*/
add_action( 'admin_menu' , 'TMDB_Movie');

function TMDB_Movie(){
    $__page_title = 'TMDB Movie Impoter';
    $__menu_title = 'Movie-import';
    $__capability = 'manage_options';
    $__menu_slug  = 'admin.php';
    $__function   = '__mg__init__';

    add_menu_page( $__page_title, $__menu_title, $__capability, $__menu_slug, $__function );
}

function __mg__init__(){
    require_once plugin_dir_path( __FILE__ ) . '/pages/admin.php';
    wp_enqueue_style('stylesheet', plugins_url('css/style.css',__FILE__ ));
}

?>