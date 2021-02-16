<?php
/**
 * The main template file
 *
 */

defined( 'ABSPATH' ) || exit; 

get_header(); ?>

    <div class="main-wrap page-wrap" id="site-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <article class="error-404">
                        <h2 class="post-title"><?php esc_html_e( '404 Error!', 'jannah-lite' ); ?></h2>
                        <h4><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'jannah-lite' ); ?></h4>
                        <div id="content-404">
                            <?php get_search_form(); ?>
                        </div>
                    </article>	
                </div>
            </div>
        </div>
    </div>
    
<?php get_footer(); ?>
    
