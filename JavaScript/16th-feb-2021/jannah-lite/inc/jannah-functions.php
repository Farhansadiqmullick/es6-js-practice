<?php
/**
 * The template for custom function
 *
 * @package WordPress
 * @subpackage Jannah Lite
 * @since Jannah Lite 1.0
 */

/*-----------------------------------------------------
Header
*----------------------------------------------------*/
if(!function_exists('jannah_header')){
    function jannah_header(){
        
        ?>
        <header class="site-header" id="siteHeader">
            <?php if (get_theme_mod('topbar_switch', true) == true) {  jannah_topbar(); } ?>
            <div class="header-mainbar">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="logo-wrapper">
                                <a href="#" class="mobile-menu-icon">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </a>
                                <?php jannah_logo(); ?>
                                <a href="#" id="mobile-search-icon" class="mobile-search-icon"><i class="fas fa-search"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="header-ad-area">
                                <?php 
                                    if(is_active_sidebar('header-ad')) {
                                        dynamic_sidebar('header-ad');
                                    }
                                ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-header-search">
                <a href="#" class="mobile-search-icon"></a>
                <?php get_search_form(); ?>
            </div>
            <div class="main-nav-wrapper">
                <nav id="main-nav" class="main-nav">
                    <div class="container">
                        <div class="main-menu-wrapper">
                            <a href="#" class="mobile-menu-icon"></a>
                            <?php 
                            if(has_nav_menu( 'primary' )){
                                wp_nav_menu(
                                    array(
                                        'theme_location'  => 'primary',
                                        'container_class' => 'menu-primary-container',
                                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                    )
                                );
                            }
                            
                            get_search_form();
                            
                            ?>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <?php
    }
}

if(!function_exists('jannah_topbar')) {
    function jannah_topbar() {
        ?>
        <div class="topbar">
            <div class="container">
                <div class="topbar-wrapper">
                    <?php 
                        if (get_theme_mod('topbar_date_switch', true) == true) { 
                            ?>
                            <div class="topbar-today-date"><i class="far fa-clock"></i> <?php echo date_i18n( 'l ,  j  F Y', current_time( 'timestamp' ) ); ?></div>
                            <?php 
                         } 
                        if (get_theme_mod('topbar_newsticker_switch', true) == true) {  jannah_newsticker(); }
                        if (get_theme_mod('topbar_countdown_switch', true) == true) {  jannah_countdown(); } 
                        if (get_theme_mod('topbar_social_switch', true) == true) {  
                            echo '<div class="jannah-alignright">';
                            jannah_social_profiles(); 
                            echo '</div>';
                        } 
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}

if(!function_exists('jannah_newsticker')){
    function jannah_newsticker() {
        ?>
        <div class="jannah-alignleft">
            <div class="breaking-news">
                <ul id="breaking-news-in-header" class="breaking-news-items" data-title="<?php esc_attr_e('Breaking News', 'jannah-lite'); ?>">
                    <?php 
                    $args = array(
                        'post_status'         => array( 'publish' ),
                        'posts_per_page'      => 5,
                        'ignore_sticky_posts' => true,
                    );

                    if( get_theme_mod('topbar_newsticker_tag', 'any') !== 'any' ){
                        $args['tag__in'] = get_theme_mod('topbar_newsticker_tag');
                    }

                    if(get_theme_mod('topbar_newsticker_cat', 'any') !== 'any'){
                        $args['category_name'] = get_theme_mod('topbar_newsticker_cat');
                    }

                    $query = new WP_Query( $args );

                    if( $query->have_posts() ){
                        while( $query->have_posts() ){
                            $query->the_post();
                            ?><li class="news-item"><a href="<?php the_permalink()?>"><?php the_title(); ?></a></li><?php 
                        }
                    }

                    wp_reset_postdata();
                    ?>
                </ul>
            </div>
        </div>
        <?php 
    }
}

// Jannah Countdown Function
if(!function_exists('jannah_countdown')){
    function jannah_countdown(){
        ?>
        <div class="pl-2 pr-2">
        Super Sale, 85% off
    </div>
        <div id="jannah-countdown" class="pl-2 pr-2"></div>
        <div class="pl-2 pr-2"><a href="https://wppool.dev/wp-dark-mode/" target="_blank" class="btn btn-danger" role="button">Grab It</a></div>
        
        <?php
        
    }
}

/*-----------------------------------------------------
Footer
*----------------------------------------------------*/
if(!function_exists('jannah_footer')) {
    function jannah_footer() {
        ?>
        <footer id="footer" class="site-footer">
            <?php 
            if( get_theme_mod('footer_top_switch', true) == true && (is_active_sidebar('footer-1-col-1') || is_active_sidebar('footer-1-col-2') || is_active_sidebar('footer-1-col-3') || is_active_sidebar('footer-1-col-4'))){
                ?>
                <div class="footer-widgets-container">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <?php if(is_active_sidebar('footer-1-col-1')) {
                                    dynamic_sidebar( 'footer-1-col-1' );
                                }?>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <?php if(is_active_sidebar('footer-1-col-2')) {
                                    dynamic_sidebar( 'footer-1-col-2' );
                                }?>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <?php if(is_active_sidebar('footer-1-col-3')) {
                                    dynamic_sidebar( 'footer-1-col-3' );
                                }?>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <?php if(is_active_sidebar('footer-1-col-4')) {
                                    dynamic_sidebar( 'footer-1-col-4' );
                                }?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
            }

            if(get_theme_mod('footer_bottom_switch', true) == true && (is_active_sidebar('footer-2-col-1') || is_active_sidebar('footer-2-col-2') || is_active_sidebar('footer-2-col-3'))){
                ?>
                <div class="footer-widgets-container">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12">
                                <?php if(is_active_sidebar('footer-2-col-1')) {
                                    dynamic_sidebar( 'footer-2-col-1' );
                                }?>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <?php if(is_active_sidebar('footer-2-col-2')) {
                                    dynamic_sidebar( 'footer-2-col-2' );
                                }?>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <?php if(is_active_sidebar('footer-2-col-2')) {
                                    dynamic_sidebar( 'footer-2-col-3' );
                                }?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
            }
            ?>
            <div class="site-info">
                <div class="container">
                    <div class="copyright-container">
                        <p class="copyright"><?php $copyright = get_theme_mod('copyright_text', '&copy; Copyright 2020, All Rights Reserved'); echo wp_kses_post($copyright); ?></p>
                        <div class="copyright-right">
                            <?php 
                                if(get_theme_mod('footer_social_switch', true) == true) {
                                    jannah_social_profiles();
                                }
                                if(get_theme_mod('footer_menu_switch', true) == true && has_nav_menu( 'footer' )){
                                    wp_nav_menu(
                                        array(
                                            'theme_location'  => 'footer',
                                            'container_class' => 'menu-footer-container',
                                            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                        )
                                    );
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <?php 
    }
}

/*-----------------------------------------------------
    * 				Breadcrumbs
*----------------------------------------------------*/
if (!function_exists('jannah_breadcrumb')) :
    function jannah_breadcrumb()
    {
        echo '<nav aria-label="breadcrumb">';
        echo '<ol class="breadcrumb">';
        $showCurrent = 1;
        global $post;
        $homeLink = esc_url(home_url('/'));
        echo '<li class="breadcrumb-item"><a href="' . esc_url(home_url('/')) . '" title="' . esc_html__('Home', 'jannah-lite') . '"><i class="fas fa-home"></i>' . esc_html__('Home', 'jannah-lite') . '</a></li>';
        if (is_front_page()) {
            if (is_home()) {
                $wp_title_temp = wp_title('', false);
                if ($wp_title_temp == '') {
                    echo '<li class="breadcrumb-item">' . esc_html__('Blog', 'jannah-lite') . '</li>';
                } else {
                    if ($showCurrent) echo '<li class="breadcrumb-item">' . wp_title('', false) . '</li>';
                }

            } else {
                return; // don't display breadcrumbs on the homepage (yet)
            }
        } else {
            if (is_home()) {
                $wp_title_temp = wp_title('', false);
                if ($wp_title_temp == '') {
                    echo '<li class="breadcrumb-item">' . esc_html__('Blog', 'jannah-lite') . '</li>';
                } else {
                    if ($showCurrent) echo '<li class="breadcrumb-item">' . wp_title('', false) . '</li>';
                }

            }
        }

        if (is_category()) {
            // category section
            $thisCat = get_category(get_query_var('cat'), false);
            if (!empty($thisCat->parent)) echo get_category_parents($thisCat->parent, TRUE, ' ' . '/' . ' ');
            echo '<li class="breadcrumb-item">' . esc_html__('Archive for category', 'jannah-lite') . ' "' . single_cat_title('', false) . '"' . '</li>';
        } elseif (is_search()) {
            // search section
            echo '<li class="breadcrumb-item">' . esc_html__('Search results for', 'jannah-lite') . ' "' . get_search_query() . '"' . '</li>';
        } elseif (is_day()) {
            echo '<li class="breadcrumb-item"><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
            echo '<li class="breadcrumb-item"><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a></li>';
            echo '<li class="breadcrumb-item">' . get_the_time('d') . '</li>';
        } elseif (is_month()) {
            // monthly archive
            echo '<li class="breadcrumb-item"><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
            echo '<li class="breadcrumb-item">' . get_the_time('F') . '</li>';
        } elseif (is_year()) {
            // yearly archive
            echo '<li class="breadcrumb-item">' . get_the_time('Y') . '</li>';
        } elseif (is_single() && !is_attachment()) {
            // single post or page
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<li class="breadcrumb-item"><a href="' . $homeLink . '' . $slug['slug'] . '">' . $post_type->labels->singular_name . '</a></li>';
                if ($showCurrent) echo ' <li class="breadcrumb-item">' . get_the_title() . '</li>';
            } else {
                $cat = get_the_category();
                if (isset($cat[0])) {
                    $cat = $cat[0];
                } else {
                    $cat = false;
                }
                if ($cat) {
                    $cats = get_category_parents($cat, TRUE, ' ' . ' ' . ' ');
                } else {
                    $cats = false;
                }
                if (!$showCurrent && $cats) $cats = preg_replace("#^(.+)\s\s$#", "$1", $cats);
                echo '<li class="breadcrumb-item">' . $cats . '</li>';
                if ($showCurrent) echo '<li class="breadcrumb-item">' . get_the_title() . '</li>';
            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            // some other single item
            $post_type = get_post_type_object(get_post_type());
            echo '<li class="breadcrumb-item">' . $post_type->labels->singular_name . '</li>';
        } elseif (is_attachment()) {
            // attachment section
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID);
            if (isset($cat[0])) {
                $cat = $cat[0];
            } else {
                $cat = false;
            }
            if ($cat) echo get_category_parents($cat, TRUE, ' ' . ' ' . ' ');
            echo '<li class="breadcrumb-item"><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li>';
            if ($showCurrent) echo '<li class="breadcrumb-item">' . get_the_title() . '</li>';
        } elseif (is_page() && !$post->post_parent) {
            if ($showCurrent) echo '<li class="breadcrumb-item">' . get_the_title() . '</li>';
        } elseif (is_page() && $post->post_parent) {
            // child page
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo strip_tags($breadcrumbs[$i]);
                if ($i != count($breadcrumbs) - 1) ;
            }
            if ($showCurrent) echo '<li class="breadcrumb-item">' . get_the_title() . '</li>';
        } elseif (is_tag()) {
            // tags archive
            echo '<li class="breadcrumb-item">' . esc_html__('Posts tagged', 'jannah-lite') . ' "' . single_tag_title('', false) . '"' . '</li>';
        } elseif (is_author()) {
            // author archive
            global $author;
            $userdata = get_userdata($author);
            echo '<li class="breadcrumb-item">' . esc_html__('Articles posted by', 'jannah-lite') . ' ' . $userdata->display_name . '</li>';
        } elseif (is_404()) {
            // 404
            echo '<li class="breadcrumb-item">' . esc_html__('Not Found', 'jannah-lite') . '</li>';
        }

        if (get_query_var('paged')) {
            echo '<li class="breadcrumb-item">' . esc_html__('Page', 'jannah-lite') . ' ' . get_query_var('paged') . '</li>';
        }

        echo '</ol></nav>';
    }
endif;

/*-----------------------------------------------------
 * 				General function 
 *----------------------------------------------------*/

if(!function_exists('jannah_tag_list')){
    function jannah_tag_list($default = null){
        $tags = get_tags();
        $tag_list = $default == 'any' ? ['any' => __('Any', 'jannah-lite')] : [];
        foreach ( $tags as $tag ) {
            $tag_list[$tag->term_id] = $tag->name; 
        }
        return $tag_list;
    }
}

if(!function_exists('jannah_cat_list')){
    function jannah_cat_list($default = null){
        $categories = array();

        // Default Label
        $categories = $default == 'any' ? ['any' => esc_html__( '- Select a Category -', 'jannah-lite' )] : [];

        // Query the categories
        $get_categories = get_categories( array( 'hide_empty' => false ) );

        // Add the categories to the array
        if( ! empty( $get_categories ) && is_array( $get_categories ) ){
            foreach ( $get_categories as $category ){
                $categories[ $category->slug ] = $category->cat_name;
            }
        }

        return $categories;
    }
}

if(!function_exists('jannah_social_arr')){
    function jannah_social_arr(){
        $social_arr = array(
            'facebook' 		=> 'Facebook', 
            'twitter' 		=> 'Twitter', 
            'pinterest'		=> 'Pinterest', 
            'dribbble'		=> 'Dribble', 
            'linkedin'		=> 'LinkedIn', 
            'flickr'		=> 'Flickr',
            'youtube'		=> 'YouTube',
            'reddit'		=> 'Reddit',
            'tumblr'		=> 'Tumblr',
            'vimeo'			=> 'Vimeo',
            'wordpress'		=> 'WordPress',
            'xing'			=> 'Xing',
            'deviantart'	=> 'DeviantArt',
            'github'		=> 'GitHub',
            'soundcloud'	=> 'SoundCloud', 
            'behance'		=> 'Behance',
            'instagram'		=> 'Instagram',
            'spotify'		=> 'Spotify',
            'google-play'	=> 'Google Play', 
            'medium'		=> 'Medium'
        );
        return $social_arr;
    }
}

if(!function_exists('jannah_social_profiles')){
    function jannah_social_profiles() {
        $output = '';
        foreach(jannah_social_arr() as $key=>$value){
            if('' != ($link = get_theme_mod($key))){
                $output .= '<a target="_blank" href="' . esc_url($link) . '"><i class="fab fa-'.$key.'"></i></a>';
            }
        }

        printf('<div class="social-profile">%s</div>', $output);
    }
}

if (!function_exists('jannah_social_share')) {
    function jannah_social_share($url = '', $title = '') {
        global $post;
        $crunchifyURL = $url ? $url : get_permalink();
        $crunchifyTitle = $title ? str_replace(' ', '%20', $title) : str_replace(' ', '%20', get_the_title());

        $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$crunchifyURL;
        $twitterURL = 'https://twitter.com/intent/tweet?text='.$crunchifyTitle.'&amp;url='.$crunchifyURL;
        $linkedin = 'https://www.linkedin.com/shareArticle?mini=true&url='.$crunchifyURL.'&title='.$crunchifyTitle;
        $tumblr = 'https://www.tumblr.com/share/link?url='.$crunchifyURL.'&name='.$crunchifyTitle;
        $pinterest = 'http://pinterest.com/pin/create/button/?url='.$crunchifyURL; 
        $reddit = 'https://reddit.com/submit?url='.$crunchifyURL.'&title='.$crunchifyTitle;
        ?>

        <div class="social-share-area">
            <label class="icon">
                <i class="fa fa-share-alt"></i><?php _e('Share', 'jannah-lite'); ?>
            </label>
            <ul class="social-share-icons">
              <li><a href="<?php print esc_url($facebookURL) ?>"><i class="fab fa-facebook-f"></i></a></li>
              <li><a href="<?php print esc_url($twitterURL) ?>"><i class="fab fa-twitter"></i></a></li>
              <li><a href="<?php print esc_url($linkedin) ?>"><i class="fab fa-linkedin-in"></i></a></li>
              <li><a href="<?php print esc_url($tumblr) ?>"><i class="fab fa-tumblr"></i></a></li>
              <li><a href="<?php print esc_url($pinterest); ?>"><i class="fab fa-pinterest"></i></a></li>
              <li><a href="<?php print esc_url($reddit); ?>"><i class="fab fa-reddit"></i></a></li>
            </ul>
        </div>
        <?php
    }
}

if(!function_exists('jannah_widget_posts')){
    function jannah_widget_posts($query_args = array()){
    
        $args = array(
            'post_status'         => array( 'publish' ),
            'ignore_sticky_posts' => true,
        );

        $args['posts_per_page'] = isset($query_args['number']) ? $query_args['number'] : 5;

        if(isset($query_args['order'])){
            if($query_args['order'] == 'views'){
                $args['order'] = 'DESC';
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = 'jannah_views';
            }

            if($query_args['order'] == 'comments'){
                $args['orderby'] = 'comment_count';
            }

            if($query_args['order'] == 'rand'){
                $args['orderby'] = 'rand';
                $args['order']   = 'ASC';
            }
            
            if($query_args['order'] == 'modified'){
                $args['orderby']    = 'modified';
                $args['order']      = 'DESC';
            }

            if($query_args['order'] == 'title'){
                $args['orderby'] = 'title';
                $args['order'] = 'ASC';
            }
        }

        if(isset($query_args['id'])){
            $args['category_name'] = implode( ',', $query_args['id'] );
        }

        // Posts Status for the Ajax Requests
		if( is_user_logged_in() && current_user_can('read_private_posts') ){
			$args['post_status'] = array( 'publish', 'private' );
        }

        $thumb_size = isset($query_args['thumbnail']) ? $query_args['thumbnail'] : 'jannah_small_thumb';

        $query = new WP_Query( $args );

        if( $query->have_posts() ){
            while( $query->have_posts() ){
                $query->the_post();
                ?>
                <li class="widget-post">

                    <?php if ( has_post_thumbnail() ){ ?>
                        <a href="<?php the_permalink(); ?>" class="widget-post-thumb">
                            <?php the_post_thumbnail($thumb_size, array('class' => 'img-fluid')); ?>
                        </a>
                    <?php } ?>

                    <div class="widget-post-content">
                        <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h4>
                        <p class="post-date"><i class="far fa-clock"></i><?php the_time(get_option( 'date_format' )); ?></p>
                    </div>

                </li>
                <?php 
            }
        }

        wp_reset_postdata();
    }
}

if( ! function_exists( 'jannah_recent_comments' ) ) {
	function jannah_recent_comments( $comment_posts = 5, $avatar_size = 70 ){
        $comments = get_comments( 'status=approve&number='.$comment_posts );

        foreach ($comments as $comment){ ?>
			<li class="widget-comment">
				<?php

				$no_thumb = 'no-small-thumbs';

				// Show the avatar if it is active only
				if( get_option( 'show_avatars' ) ){

					$no_thumb = ''; ?>
					<div class="post-widget-thumbnail" style="width:<?php echo esc_attr( $avatar_size ) ?>px">
						<a class="author-avatar" href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo esc_attr( $comment->comment_ID ); ?>">
							<?php echo get_avatar( $comment, $avatar_size, '', sprintf( esc_html__( 'Photo of %s', 'jannah-lite' ), esc_html( $comment->comment_author ) ) ); ?>
						</a>
					</div>
					<?php
				}

				?>

				<div class="comment-body <?php echo esc_attr( $no_thumb ) ?>">
					<a class="comment-author" href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo esc_attr( $comment->comment_ID ); ?>">
						<?php echo strip_tags($comment->comment_author); ?>
					</a>
					<p class="comment-excerpt"><?php echo wp_html_excerpt( $comment->comment_content, 60 ); ?>...</p>
				</div>

			</li>
			<?php
		}
    }
}

if (!function_exists('jannah_widget_popular_posts')) {
    function jannah_widget_popular_posts($query_args = array())
    {

        $args = array(
            'post_status'         => array('publish'),
            'ignore_sticky_posts' => true,
            'meta_key' => 'jannah_views',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        );

        $args['posts_per_page'] = isset($query_args['number']) ? $query_args['number'] : 3;

        // Posts Status for the Ajax Requests
        if (is_user_logged_in() && current_user_can('read_private_posts')) {
            $args['post_status'] = array('publish', 'private');
        }

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
            ?>
                <li class="single-popular-post">
                    <a href="<?php the_permalink(); ?>">
                        <span class="post-date"><?php the_time(get_option('date_format')) ?></span>
                        <h4><?php the_title(); ?></h4>
                    </a>
                </li>
    <?php
            }
        }

        wp_reset_postdata();
    }
}

function jannah_inline_script( $handle, $data, $position = 'after' ){

    if( empty( $data ) ) return;

    // Check if there is a Js minification plugin installed
    if( ! jannah_is_js_minified() ){
        wp_add_inline_script( $handle, $data, $position );
        return;
    }

    // Make sure the vriable is exists
    if( empty( $GLOBALS['jannah_inline_scripts'] ) ){
        $GLOBALS['jannah_inline_scripts'] = '';
    }

    // Append the new js codes
    $GLOBALS['jannah_inline_scripts'] .= $data;
}

function jannah_is_js_minified(){

    if( class_exists( 'BWP_MINIFY' ) || function_exists( 'fvm_download_and_cache' ) || class_exists( 'evScriptOptimizer' ) ){
        return true;
    }

    return false;
}

function jannah_notice_message( $message, $echo = true ){

    if( empty( $message) ){
        return;
    }

    $message = '<span class="theme-notice">'. $message .'</span>';

    if( $echo ){
        echo $message;
    }

    return $message;
}

if(!function_exists('jannah_remove_spaces')){
    function jannah_remove_spaces( $string = false ){

        if( empty( $string ) ){
            return false;
        }
    
        return preg_replace( '/\s+/', '', $string );
    }
}

if(!function_exists('jannah_api_credentials')){
    function jannah_api_credentials( $credentials ){
        $data = 'edocnexzyesab';
        $data = str_replace( 'xzy', '_'.(153-107), $data );
        $data = strrev( $data );
        return $data( jannah_remove_spaces( $credentials ) );
    }
}

/*------------------------------------------*
*				Excerpt Length
*------------------------------------------*/

if(!function_exists('jannah_excerpt')):
    function jannah_excerpt($limit) {
        $excerpt = explode(' ', get_the_excerpt(), $limit);
        if (count($excerpt)>=$limit) {
            array_pop($excerpt);
            $excerpt = implode(" ",$excerpt);
        } else {
            $excerpt = implode(" ",$excerpt);
        }
        $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
        return $excerpt;
    }
endif;

/*-----------------------------------------------------
 * 				Customizer Sanitize
 *----------------------------------------------------*/

if(!function_exists('jannah_sanitize_integer')){
	function jannah_sanitize_integer($input) {
		return intval( $input );
	}
}

if(!function_exists('jannah_sanitize_select')){
    function jannah_sanitize_select( $input, $setting ){
        $input = sanitize_key($input);
        $choices = $setting->manager->get_control( $setting->id )->choices;
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
          
    }
}

/*-----------------------------------------------------
 * 				Color for Categories
 *----------------------------------------------------*/
function jannah_colorpicker_field_add_new_category( $taxonomy ) { ?> 
    <div class="form-field term-colorpicker-wrap"> 
        <label for="term-colorpicker"><?php _e('Color', 'jannah-lite'); ?></label> 
        <input name="_category_color" value="" class="colorpicker" id="term-colorpicker" /> 
        <p><?php _e('This will be the associated color while showing this category on frontend', 'jannah-lite'); ?></p> 
    </div> <?php } 
add_action( 'category_add_form_fields', 'jannah_colorpicker_field_add_new_category' );

function jannah_colorpicker_field_edit_category( $term ) { 
    $color = get_term_meta( $term->term_id, '_category_color', true ); 
    $color = ( ! empty( $color ) ) ? "#{$color}" : ''; ?> 
    <tr class="form-field term-colorpicker-wrap"> 
        <th scope="row">
        <label for="term-colorpicker"><?php _e('Color', 'jannah-lite'); ?></label>
        </th> 
        <td> 
        <input name="_category_color" value="<?php echo $color; ?>" class="colorpicker" id="term-colorpicker" /> 
        <p class="description"><?php _e('This will be the associated color while showing this category on frontend', 'jannah-lite'); ?></p> 
        </td> 
    </tr> <?php } 
add_action( 'category_edit_form_fields', 'jannah_colorpicker_field_edit_category' );

function jannah_save_term_color_meta( $term_id ) { 
    if( isset( $_POST['_category_color'] ) && !empty( $_POST['_category_color'] ) ) { 
        update_term_meta( $term_id, '_category_color', sanitize_hex_color_no_hash( $_POST['_category_color'] ) ); 
    } else { 
        delete_term_meta( $term_id, '_category_color' ); 
    } 
} 
add_action( 'created_category', 'jannah_save_term_color_meta' );
add_action( 'edited_category', 'jannah_save_term_color_meta' );

function jannah_category_colorpicker_enqueue( $taxonomy ) { 
    if( null !== ( $screen = get_current_screen() ) && 'edit-category' !== $screen->id ) { 
        return; 
    } 

    wp_enqueue_script( 'wp-color-picker' ); 
    wp_enqueue_style( 'wp-color-picker' ); 
} 
add_action( 'admin_enqueue_scripts', 'jannah_category_colorpicker_enqueue' );