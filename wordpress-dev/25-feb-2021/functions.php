<?php
require_once('wp_bootstrap_navwalker.php');
function spendebt_setup(){
    //Translation
    load_theme_textdomain( 'spendebt', get_template_directory( ).'/languages');
    
    //Post Thumbnails for Post and Pages
    add_theme_support('post_thumbnails');
    add_image_size( 'post_thumb', 737, 452, true);
    add_image_size( 'blog_post', 555, 272, true);
    add_image_size('banner_image', 578, 982, true);

    //wp_nav_menus initialization
    register_nav_menus( array(
        'menu' => esc_html__('Primary Menu', 'spendebt'),
    ) );

}

add_action('after_setup_theme','spendebt_setup');

//Enqueue Scripts and Styles
function spendebt_scripts(){
    //Enqueue Style
    wp_enqueue_style('typekit-cs', '//use.typekit.net/sos3edy.css', array(), false, 'all');
    wp_enqueue_style('plugins-cs', get_template_directory_uri() . '/css/plugins.css', array(), date("ymd-Gis", filemtime( get_template_directory() . '/css/plugins.css' )), 'all');
	wp_enqueue_style( 'spendebt-style', get_stylesheet_uri(), array(), date("ymd-Gis", filemtime( get_stylesheet_directory())));
    
    //Enqueue Scripts
    wp_enqueue_script('jquery');
	wp_enqueue_script('plugins', get_template_directory_uri() . '/js/plugins.js', array(), date("ymd-Gis", filemtime( get_template_directory() . '/js/plugins.js' )), true);
	wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.js', array(), date("ymd-Gis", filemtime( get_template_directory() . '/js/scripts.js' )), true);

}

add_action('wp_enqueue_scripts', 'spendebt_scripts');

//Allow SVG and DOC file details

function spendebt_custom_mime_types( $mimes ) {
	// New allowed mime types.
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	$mimes['doc'] = 'application/msword';
	 
	// Optional. Remove a mime type.
	unset( $mimes['exe'] );
	 
	return $mimes;
}
add_filter( 'upload_mimes', 'spendebt_custom_mime_types' );





?>