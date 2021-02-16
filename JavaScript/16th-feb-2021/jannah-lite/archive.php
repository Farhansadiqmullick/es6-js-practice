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
                    <?php if(!is_front_page()) { jannah_breadcrumb();}?>
                    <div class="blog-list">
                    <?php 
                        if(have_posts()) :
                            while (have_posts()) : the_post();
                                get_template_part('template-parts/content', get_post_format());
                            endwhile;
                        
                        the_posts_pagination( array('prev_text' => '<i class="fa fa-angle-double-left"></i>', 'next_text' => '<i class="fa fa-angle-double-right"></i>', 'mid_size' => 2,'screen_reader_text'=>'' ) );
                        
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
    
