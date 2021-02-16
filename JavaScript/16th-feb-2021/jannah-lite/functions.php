<?php
/**
 * Jannah Lite functions related to defining constants, adding files and WordPress core functionality.
 *
 * Defining some constants, loading all the required files and Adding some core functionality.
 *
 * @uses       add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses       register_nav_menu() To add support for navigation menu.
 * @uses       set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @package    WordPress
 * @subpackage Jannah Lite
 * @since      Jannah Lite 1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 /*-----------------------------------------------------
 * 				Define Default Constants
 *----------------------------------------------------*/
define( 'JANNAH_THEME_DIR', get_template_directory() );
define( 'JANNAH_THEME_URI', get_template_directory_uri() );
define( 'JANNAH_THEME_SUB_DIR', JANNAH_THEME_DIR.'/inc/' );
define( 'JANNAH_CSS', JANNAH_THEME_URI.'/css/' );
define( 'JANNAH_JS', JANNAH_THEME_URI.'/js/' );

/*-----------------------------------------------------
 * 				Load Require File
 *----------------------------------------------------*/
require_once JANNAH_THEME_SUB_DIR.'jannah-functions.php';
require_once JANNAH_THEME_SUB_DIR.'jannah-customizer-switch.php';
require_once JANNAH_THEME_SUB_DIR.'jannah-customizer.php';
require_once JANNAH_THEME_SUB_DIR.'jannah-widgets.php';
require_once JANNAH_THEME_SUB_DIR.'jannah-postviews.php';
require_once JANNAH_THEME_SUB_DIR.'jannah-weather.php';
require_once JANNAH_THEME_SUB_DIR . 'class-tgm-plugin-activation.php';

/*-----------------------------------------------------
 * 				Jannah Lite Theme Setup
 *----------------------------------------------------*/
if( ! function_exists( 'jannah_setup' )):
    function jannah_setup(){

		// * Load Language File *//
        load_theme_textdomain('jannah-lite', get_template_directory() . '/languages');

		// Add theme supports
        add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'automatic-feed-links' );

		//*set image size *//
		add_image_size('jannah_big_thumb',780,470,true);
		add_image_size('jannah_blog_post_thumb',390,220,true);
		add_image_size('jannah_small_thumb',220,150,true);

        /*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

        /*
		 * Enable support for custom logo.
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 49,
			'width'       => 300,
			'flex-height' => true,
		) );


        /*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1200, 9999 );

        // Register nav menu locations.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'jannah-lite'),
			'footer' => esc_html__( 'Footer Menu', 'jannah-lite'),
		) );

        /*
		 * Switch default core markup for search form, comment form, comments etc.
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
		) );

        /*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'status',
			'audio',
			'chat',
		) );

        // Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'editor-styles' );
		add_editor_style( JANNAH_CSS . 'editor-style.css' );
		
		if ( ! isset( $content_width ) ) $content_width = 660;
    }
endif;
add_action ('after_setup_theme', 'jannah_setup');

/*-----------------------------------------------------
 * 				Load  Style And Script
 *----------------------------------------------------*/
function jannah_enqueue_styles_scripts(){

    //add stylesheet
    wp_enqueue_style('bootstrap', JANNAH_CSS . 'bootstrap.min.css', array(), true);
    wp_enqueue_style('font-awesome', JANNAH_CSS . 'font-awesome.css', array(), true);
	wp_enqueue_style('ticker-style', JANNAH_CSS . 'ticker-style.css', array(), true);
	wp_enqueue_style('jannah-lite',get_stylesheet_uri());
    wp_enqueue_style('jannah-main-style', JANNAH_CSS . 'style.css', array(), filemtime(JANNAH_THEME_DIR . '/css/style.css'), 'all' );

    //add script
    wp_enqueue_script('bootstrap', JANNAH_JS . 'bootstrap.min.js',array('jquery'),false,true);
    wp_enqueue_script('jquery-ticker', JANNAH_JS . 'jquery.ticker.js',array('jquery'),false,true);
    wp_enqueue_script('jquery-resize-sensor', JANNAH_JS . 'ResizeSensor.js',array('jquery'),false,true);
    wp_enqueue_script('jquery-sticky-sidebar', JANNAH_JS . 'jquery.sticky-sidebar.min.js',array('jquery'),false,true);
	wp_enqueue_script('jannah-instagram', JANNAH_JS . 'instagramFeed.min.js', array('jquery'), false, true);
	wp_enqueue_script( 'navigation', JANNAH_JS . 'navigation.js', array(), false, true );
	wp_enqueue_script( 'countdown', JANNAH_JS . 'jquery.countdown.min.js', array('jquery'), false, true );
	wp_enqueue_script('jannah-custom', JANNAH_JS . 'theme.js',array('jquery'),filemtime(JANNAH_THEME_DIR . '/js/theme.js'),true);
	
    //reply comments
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
	  
}
add_action('wp_enqueue_scripts', 'jannah_enqueue_styles_scripts');

// Load Google Font
if (!function_exists('jannah_web_fonts_url')):
    function jannah_web_fonts_url($font)
    {
        $font_url = '';

        if ('off' !== _x('on', 'Google font: on or off', 'jannah-lite')) {
            $font_url = add_query_arg(array(
				'family' 	=> urlencode($font),
				'display'	=> 'swap'
			), "//fonts.googleapis.com/css2");
        }
        return $font_url;
    }
endif;


// Enqueue Scripts and Styles.
if (!function_exists('jannah_font_scripts')):
    function jannah_font_scripts(){
        wp_enqueue_style('jannah-web-font', esc_url(jannah_web_fonts_url('Lato:wght@400;700')), array(), '1.0.0');
    }
endif;
add_action('wp_enqueue_scripts', 'jannah_font_scripts');

add_action( 'admin_enqueue_scripts', 'jannah_admin_enqueue_scripts' );
function jannah_admin_enqueue_scripts(){
	wp_enqueue_style('jannah-admin-style', JANNAH_CSS . 'style-admin.css', array(), filemtime(JANNAH_THEME_DIR . '/css/style-admin.css'), 'all' );
	wp_enqueue_script( 'jannah-admin-scripts', JANNAH_JS . 'theme-admin.js',    array( 'jquery', 'wp-color-picker' ), false, true );
}

/*-----------------------------------------------------
 * 				Logo
 *----------------------------------------------------*/
function jannah_logo(){
	$logo = '';
	$logo_id = get_theme_mod('custom_logo');
	$logo_array = wp_get_attachment_image_src( $logo_id , 'full' );
	if($logo_array != false){
		$logo = $logo_array[0];
	}
	if($logo == '')
	{
		$logo = get_template_directory_uri().'/images/logo.png';
	}
	echo '<a class="navbar-brand" href="'.esc_url(home_url('/')).'"><img src="'.esc_url($logo).'" alt="'.get_bloginfo('name').'"></a>';
}


/*-----------------------------------------------------
 * 				Required Plugins
 *----------------------------------------------------*/
add_action( 'tgmpa_register', 'jannah_register_required_plugins' );
function jannah_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => esc_html__('One Click Demo Import','jannah-lite'),
			'slug'               => 'one-click-demo-import',
			'required'           => false,
		),
		array(
			'name'               => esc_html__('Simple Author Box','jannah-lite'),
			'slug'               => 'simple-author-box',
			'required'           => false,
		)
	);
	$config = array(
		'id'           => 'jannah-lite',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		
		'strings'      => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'jannah-lite' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'jannah-lite' ),
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'jannah-lite' ),
			'updating'                        => esc_html__( 'Updating Plugin: %s', 'jannah-lite' ),
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'jannah-lite' ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'jannah-lite'
			),
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'jannah-lite'
			),
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'jannah-lite'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'jannah-lite'
			),
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'jannah-lite'
			),
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'jannah-lite'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'jannah-lite'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'jannah-lite'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'jannah-lite'
			),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'jannah-lite' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'jannah-lite' ),
			'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'jannah-lite' ),
			'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.', 'jannah-lite' ),
			'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'jannah-lite' ),
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s', 'jannah-lite' ),
			'dismiss'                         => esc_html__( 'Dismiss this notice', 'jannah-lite' ),
			'notice_cannot_install_activate'  => esc_html__( 'There are one or more required or recommended plugins to install, update or activate.', 'jannah-lite' ),
			'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'jannah-lite' ),
			'nag_type'                        => '', 
		),
	);
	tgmpa( $plugins, $config );
}

/*-----------------------------------------------------
 * 				One Click Demo
 *----------------------------------------------------*/
if(!function_exists('jannah_demo_import_files')){
	function jannah_demo_import_files() {
		return array(
			array(
			  'import_file_name'            => esc_html__('Default Demo','jannah-lite'),
			  'import_file_url'            	=> 'https://jannah.wppool.dev/demos/default/content.xml',
			  'import_widget_file_url'    	=> 'https://jannah.wppool.dev/demos/default/widgets.wie',
			  'import_customizer_file_url'	=> 'https://jannah.wppool.dev/demos/default/customizer.dat',
			  'import_notice'               => esc_html__( 'Please wait a few minutes after clicking import, do not close the window or refresh the page until the data is imported.', 'jannah-lite' ),
			  'import_preview_image_url'  	=> 'https://jannah.wppool.dev/demos/default/screenshot.png',
			  'preview_url'               	=> 'https://jannah.wppool.dev/',
			),
		);
	}
	add_filter( 'pt-ocdi/import_files', 'jannah_demo_import_files');
}

if(!function_exists('jannah_demo_page_setting')){
	function jannah_demo_page_setting() {
		// Assign menus to their locations.
		$main_menu = get_term_by('name', 'Main Menu', 'nav_menu');
		$footer_menu = get_term_by('name', 'Footer Menu', 'nav_menu');

		set_theme_mod( 'nav_menu_locations', array(
				'primary' => $main_menu->term_id,
				'footer'=> $footer_menu->term_id
			)
		);

		// Assign front page and posts page (blog page).
		$front_page_id = get_page_by_title( 'Home' );
		$blog_page_id  = get_page_by_title( 'Blog' );

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
		update_option( 'page_for_posts', $blog_page_id->ID );

	}
	add_action( 'pt-ocdi/after_import', 'jannah_demo_page_setting' );
}