<?php
/*
Plugin Name:  TMDB-impoter Plugin 
Plugin URI:   https://www.tmdb-impoter.com 
Description:  Intigrate with TMDB Api. 
Version:      1.0
Author:       Malindu Gimhan 
Author URI:   https://www.tmdb-impoter.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  
Domain Path:  
*/
add_action( 'admin_menu' , 'TMDB_Movie');

function TMDB_Movie(){
    $page_title = 'TMDB Movie Impoter';
    $menu_title = 'Movie-import';
    $capability = 'manage_options';
    $menu_slug  = 'admin.php';
    $function   = 'Counter_pagina_inhoud';

    add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function );
}

function Counter_pagina_inhoud(){
    require_once plugin_dir_path( __FILE__ ) . 'admin.php';
    wp_enqueue_style('stylesheet', plugins_url('css/style.css',__FILE__ ));
}

?>