<?php 
/**
 * Post views Class
 *
 */

defined( 'ABSPATH' ) || exit; 

if( ! class_exists( 'JANNAH_POSTVIEWS' ) ) {
    class JANNAH_POSTVIEWS{
        /**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
        function __construct(){
            add_filter( 'Jannah/post_options_meta', array( $this, 'save_custom_views' ) );
            add_filter( 'Jannah/views_meta_field', array( $this, 'custom_views_meta_field' ) );
            add_filter( 'manage_posts_columns', array( $this, 'posts_column_views' ) );
            add_filter( 'manage_edit-post_sortable_columns', array( $this, 'sort_postviews_column' ) );
            add_action( 'manage_posts_custom_column', array( $this, 'posts_custom_column_views' ), 5, 2 );
            add_action( 'pre_get_posts', array( $this, 'sort_postviews' ) );
            add_action( 'wp_footer', array( $this, 'set_post_views' ) );
            add_action( 'amp_post_template_head', array( $this, 'set_post_views' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'postview_cache_enqueue' ), 25 );
            add_action( 'wp_ajax_jannah_postviews', array( $this, 'increment_views' ) );
			add_action( 'wp_ajax_nopriv_jannah_postviews', array( $this, 'increment_views' ) );
        }

        /**
		 * set_post_views
		 *
		 * Count number of views
		 */
		function set_post_views(){

			// Disable via filter
			if( ! apply_filters( 'Jannah/Post_Views/increment', true ) ){
				return;
			}

			if( ! is_single() || JANNAH_POSTVIEWS::is_bot() ){
				return;
			}

			// Run only on the first page of the post
			$page = get_query_var( 'paged', 1 );

			if( $page > 1 ){
				return false;
			}

			if( ! self::is_cache_enabled() || ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) ){

				// Increase number of views +1
				$count     = 0;
				$post_id   = get_the_ID();
				$count_key = apply_filters( 'Jannah/views_meta_field', 'jannah_views' );
				$count     = (int) get_post_meta( $post_id, $count_key, true );

				// The Starter Number
				if( empty( $count ) || $count == 0 ){
					$count = (int) 0;
				}

				$new_count = $count + 1;
				update_post_meta( $post_id, $count_key, jannah_sanitize_integer($new_count) );
			}
        }
        
        /**
		 * Check if the current request made by a known bot?
		 */
		public static function is_bot( $ua = null ){

			if ( empty( $ua ) && ! empty( $_SERVER['HTTP_USER_AGENT'] ) ){
				$ua = $_SERVER['HTTP_USER_AGENT'];
			}

			if( ! empty( $ua ) ){

				$bot_agents = array(
					'alexa', 'altavista', 'ask jeeves', 'attentio', 'baiduspider', 'bingbot', 'chtml generic', 'crawler', 'fastmobilecrawl',
					'feedfetcher-google', 'firefly', 'froogle', 'gigabot', 'googlebot', 'googlebot-mobile', 'heritrix', 'httrack', 'ia_archiver', 'irlbot',
					'iescholar', 'infoseek', 'jumpbot', 'linkcheck', 'lycos', 'mediapartners', 'mediobot', 'motionbot', 'msnbot', 'mshots', 'openbot',
					'pss-webkit-request', 'pythumbnail', 'scooter', 'slurp', 'Speed Insights', 'snapbot', 'spider', 'taptubot', 'technoratisnoop',
					'teoma', 'twiceler', 'yahooseeker', 'yahooysmcm', 'yammybot', 'ahrefsbot', 'Pingdom', 'GTmetrix', 'PageSpeed', 'Google Page Speed',
					'kraken', 'yandexbot', 'twitterbot', 'tweetmemebot', 'openhosebot', 'queryseekerspider', 'linkdexbot', 'grokkit-crawler',
					'livelapbot', 'germcrawler', 'domaintunocrawler', 'grapeshotcrawler', 'cloudflare-alwaysonline',
				);

				foreach ( $bot_agents as $bot_agent ) {
					if ( false !== stripos( $ua, $bot_agent ) ) {
						return true;
					}
				}
			}

			return false;
        }

        /**
		 * postview_cache_enqueue
		 *
		 * Calculate Post Views With WP_CACHE Enabled
		 */
		function postview_cache_enqueue(){

			// Disable via filter
			if( ! apply_filters( 'Jannah/Post_Views/increment', true ) ){
				return;
			}

			// Run only if the post views option is set to THEME's post views module
			// Single Post page
			// Cache is active
			if( ! is_single() || ! self::is_cache_enabled() ){
				return;
			}

			// Add the js code
			$cache_js = '
				jQuery.ajax({
					type : "GET",
					url  : "'. esc_url( admin_url('admin-ajax.php') ) .'",
					data : "postviews_id='. get_the_ID() .'&action=jannah_postviews",
					cache: !1,
					success: function( data ){
						jQuery("#single-post-meta").find(".meta-views").html( data );
					}
				});

			';

			jannah_inline_script( 'jannah-custom', $cache_js );
		}
        
        /**
		 * is_cache_enabled
		 *
		 */
		function is_cache_enabled(){

			// Most of the Cache plugins uses the WP_CACHE
			if ( defined( 'WP_CACHE' ) && WP_CACHE ){
				return true;
			}

			// Wp Fatest Cache
			if( class_exists( 'WpFastestCache' ) ){
				if( ! empty( $GLOBALS['wp_fastest_cache_options']->wpFastestCacheStatus ) && $GLOBALS['wp_fastest_cache_options']->wpFastestCacheStatus == 'on' ){
					return true;
				}
			}

			return false;
        }
        
        /**
		 * increment_views
		 *
		 * Increment Post Views With WP_CACHE Enabled
		 */
		function increment_views(){

			// Run only if the post views option is set to THEME's post views module
			if( JANNAH_POSTVIEWS::is_bot() ){
				return;
			}

			// Increase number of views +1
			if( ! empty( $_GET['postviews_id'] ) && self::is_cache_enabled() ){

				$post_id = intval($_GET['postviews_id']);

				if( $post_id > 0 ){
					$count     = 0;
					$count_key = apply_filters( 'Jannah/views_meta_field', 'jannah_views' );
					$count     = (int) get_post_meta( $post_id, $count_key, true );

					// The Starter Number
					if( ( empty( $count ) || $count == 0 ) ){
						$count = (int) 0;
					}

					$new_count = $count + 1;
					update_post_meta( $post_id, $count_key, jannah_sanitize_integer($new_count) );

					$formated = apply_filters( 'Jannah/post_views_number', number_format_i18n( $new_count ) );
					echo '<span class="meta-views meta-item">'. $formated .'</span>';
				}
			}

			exit();
		}

        /**
		 * custom_views_meta_field
		 *
		 * Custom meta_field name
		 */
		function custom_views_meta_field( $field ){
			return $field;
		}

        /**
		 * save_custom_views
		 *
		 * Add the views meta name to the meta_fields array
		 */
		function save_custom_views( $meta_fields ){
			$meta_fields[] = apply_filters( 'Jannah/views_meta_field', 'jannah_views' );
			return $meta_fields;
        }
        
        /**
		 * posts_column_views
		 *
		 * Dashboared column title
		 */
		function posts_column_views( $defaults ){
			$defaults['jannah_post_views'] = esc_html__( 'Views', 'jannah-lite' );
			return $defaults;
        }

        /**
		 * posts_custom_column_views
		 *
		 * Dashboared column content
		 */
		function posts_custom_column_views( $column_name, $id ){
			if( $column_name === 'jannah_post_views' ){
				echo JANNAH_POSTVIEWS::get_views( '', get_the_ID() );
			}
        }

        /**
		 * sort_postviews
		 *
		 * Sort Post views in the dashboared
		 */
		function sort_postviews( $query ) {

			if( ! is_admin() ){
				return;
			}

			$orderby   = $query->get('orderby');
			$count_key = apply_filters( 'Jannah/views_meta_field', 'jannah_views' );

			if( $orderby == 'jannah-views' ) {
				$query->set( 'meta_key', $count_key );
				$query->set( 'orderby',  'meta_value_num' );
			}
		}
        
        /*
		 * Display number of views
		 */
		public static function get_views( $text = '', $post_id = 0 ){

			if( empty( $post_id ) ) {
				$post_id = get_the_ID();
			}

			$views_class = '';
			$formated = $count = 0;


			$count_key = apply_filters( 'Jannah/views_meta_field', 'jannah_views' );
			$count     = get_post_meta( $post_id, $count_key, true );
			$count     = empty( $count ) ? 0 : $count;

			$formated = apply_filters( 'Jannah/post_views_number', number_format_i18n( $count ) );

			$output = '<span class="meta-views meta-item">'.$text.' '.$formated.'</span>';

			return apply_filters( 'Jannah/post_views_output', $output, $post_id, $formated, $text );
		}
        
        /**
		 * sort_postviews_column
		 *
		 * Sort Post views column in the dashboared
		 */
		function sort_postviews_column( $defaults ){
			$defaults['jannah_post_views'] = 'jannah-views';
			return $defaults;
		}
    }

    // Instantiate the class
	new JANNAH_POSTVIEWS();
}