<?php
/**
 * Contains all the functions related to sidebar and widget.
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
 * 				Register Widget Areas
 *----------------------------------------------------*/
if( ! function_exists('jannah_register_sidebar')):
    function jannah_register_sidebar(){
		register_sidebar(
            array(
                'name' 			=> esc_html__( 'Header Advertise', 'jannah-lite' ),
				'id' 			=> 'header-ad',
				'description' 	=> esc_html__( 'Widgets in this area will be shown beside site logo.', 'jannah-lite' ),
				'before_title' 	=> '<h4 class="widget-title">',
				'after_title' 	=> '</h4>',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' 	=> '</aside>'
            )
		);
		
        register_sidebar(
            array(
                'name' 			=> esc_html__( 'Right Sidebar', 'jannah-lite' ),
				'id' 			=> 'right-sidebar',
				'description' 	=> esc_html__( 'Widgets in this area will be shown on Sidebar.', 'jannah-lite' ),
				'before_title' 	=> '<h4 class="widget-title">',
				'after_title' 	=> '</h4>',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' 	=> '</aside>'
            )
		);

		register_sidebar(
			array(
				'name' 			=> esc_html__( 'First Footer - 1st Column', 'jannah-lite' ),
				'id' 			=> 'footer-1-col-1',
				'before_title' 	=> '<h4 class="widget-title">',
				'after_title' 	=> '</h4>',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' 	=> '</aside>'
			)
		);

		register_sidebar(
			array(
				'name' 			=> esc_html__( 'First Footer - 2nd Column', 'jannah-lite' ),
				'id' 			=> 'footer-1-col-2',
				'before_title' 	=> '<h4 class="widget-title">',
				'after_title' 	=> '</h4>',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' 	=> '</aside>'
			)
		);

		register_sidebar(
			array(
				'name' 			=> esc_html__( 'First Footer - 3rd Column', 'jannah-lite' ),
				'id' 			=> 'footer-1-col-3',
				'before_title' 	=> '<h4 class="widget-title">',
				'after_title' 	=> '</h4>',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' 	=> '</aside>'
			)
		);

		register_sidebar(
			array(
				'name' 			=> esc_html__( 'First Footer - 4th Column', 'jannah-lite' ),
				'id' 			=> 'footer-1-col-4',
				'before_title' 	=> '<h4 class="widget-title">',
				'after_title' 	=> '</h4>',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' 	=> '</aside>'
			)
		);

		register_sidebar(
			array(
				'name' 			=> esc_html__( 'Second Footer - 1st Column', 'jannah-lite' ),
				'id' 			=> 'footer-2-col-1',
				'before_title' 	=> '<h4 class="widget-title">',
				'after_title' 	=> '</h4>',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' 	=> '</aside>'
			)
		);

		register_sidebar(
			array(
				'name' 			=> esc_html__( 'Second Footer - 2nd Column', 'jannah-lite' ),
				'id' 			=> 'footer-2-col-2',
				'before_title' 	=> '<h4 class="widget-title">',
				'after_title' 	=> '</h4>',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' 	=> '</aside>'
			)
		);

		register_sidebar(
			array(
				'name' 			=> esc_html__( 'Second Footer - 3rd Column', 'jannah-lite' ),
				'id' 			=> 'footer-2-col-3',
				'before_title' 	=> '<h4 class="widget-title">',
				'after_title' 	=> '</h4>',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' 	=> '</aside>'
			)
		);

		register_sidebar(
			array(
				'name' 			=> esc_html__( 'Home Section 1 - Left', 'jannah-lite' ),
				'id' 			=> 'home-section-1-left',
				'before_title' 	=> '<h3 class="widget-title">',
				'after_title' 	=> '</h3>',
				'before_widget' => '<div class="widget section-widget %2$s" id="%1$s">',
				'after_widget' 	=> '</div>'
			)
		);

		register_sidebar(
			array(
				'name' 			=> esc_html__( 'Home Section 1 - Right', 'jannah-lite' ),
				'id' 			=> 'home-section-1-right',
				'before_title' 	=> '<h3 class="widget-title">',
				'after_title' 	=> '</h3>',
				'before_widget' => '<div class="widget section-widget %2$s" id="%1$s">',
				'after_widget' 	=> '</div>'
			)
		);

		register_sidebar(
			array(
				'name' 			=> esc_html__( 'Home Section 2 - Left', 'jannah-lite' ),
				'id' 			=> 'home-section-2-left',
				'before_title' 	=> '<h3 class="widget-title">',
				'after_title' 	=> '</h3>',
				'before_widget' => '<div class="widget section-widget %2$s" id="%1$s">',
				'after_widget' 	=> '</div>'
			)
		);

		register_sidebar(
			array(
				'name' 			=> esc_html__( 'Home Section 2 - Right', 'jannah-lite' ),
				'id' 			=> 'home-section-2-right',
				'before_title' 	=> '<h3 class="widget-title">',
				'after_title' 	=> '</h3>',
				'before_widget' => '<div class="widget section-widget %2$s" id="%1$s">',
				'after_widget' 	=> '</div>'
			)
		);

		register_sidebar(
			array(
				'name' 			=> esc_html__( 'Home Section 3 - Left', 'jannah-lite' ),
				'id' 			=> 'home-section-3-left',
				'before_title' 	=> '<h3 class="widget-title">',
				'after_title' 	=> '</h3>',
				'before_widget' => '<div class="widget section-widget %2$s" id="%1$s">',
				'after_widget' 	=> '</div>'
			)
		);

		register_sidebar(
			array(
				'name' 			=> esc_html__( 'Home Section 3 - Right', 'jannah-lite' ),
				'id' 			=> 'home-section-3-right',
				'before_title' 	=> '<h3 class="widget-title">',
				'after_title' 	=> '</h3>',
				'before_widget' => '<div class="widget section-widget %2$s" id="%1$s">',
				'after_widget' 	=> '</div>'
			)
		);

		register_sidebar(
			array(
				'name' 			=> esc_html__( 'Home Section 4 - Left', 'jannah-lite' ),
				'id' 			=> 'home-section-4-left',
				'before_title' 	=> '<h3 class="widget-title">',
				'after_title' 	=> '</h3>',
				'before_widget' => '<div class="widget section-widget %2$s" id="%1$s">',
				'after_widget' 	=> '</div>'
			)
		);

		register_sidebar(
			array(
				'name' 			=> esc_html__( 'Home Section 4 - Right', 'jannah-lite' ),
				'id' 			=> 'home-section-4-right',
				'before_title' 	=> '<h3 class="widget-title">',
				'after_title' 	=> '</h3>',
				'before_widget' => '<div class="widget section-widget %2$s" id="%1$s">',
				'after_widget' 	=> '</div>'
			)
		);
    }

    add_action('widgets_init', 'jannah_register_sidebar');
endif;

/*-----------------------------------------------------
 * 				Include custom widgets
 *----------------------------------------------------*/
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-advertisement-widget.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-social-widget.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-tab-widget.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-weather-widget.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-post-list-widget.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-post-tiles-widget.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-post-tiles-widget-2.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-post-block-1.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-post-block-2.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-post-block-3.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-post-block-4.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-post-block-5.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-post-block-6.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-popular-post-widget.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-subscribe-widget.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-categories-widget.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-instagram-widget.php';
require JANNAH_THEME_SUB_DIR . 'widgets/jannah-twitter-widget.php';