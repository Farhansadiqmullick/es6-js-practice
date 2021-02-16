<?php
/**
 * The main template file
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

get_header(); ?>

    <div class="main-wrap page-wrap" id="site-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <?php if(get_theme_mod('breadcrumb_switch', true) == true && !is_front_page()) { jannah_breadcrumb();}?>
                    <div class="blog-single">
                        <?php 
                            if(have_posts()) :
                                while (have_posts()) : the_post();
                                    get_template_part('template-parts/content', 'page');
                                endwhile;                            
                            else:
                                get_template_part('template-parts/content', 'none');
                            endif;
                        ?>

                    </div>
                </div>
                <div class="col-lg-4">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>
    
<?php get_footer(); ?>
    
