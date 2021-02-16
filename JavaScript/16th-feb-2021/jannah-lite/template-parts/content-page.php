<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h1 class="post-title"><?php the_title(); ?></h1>
    <?php if ( get_theme_mod('postthumbnail_switch', true) == true && has_post_thumbnail()) { ?>
        <div class="post-thumb"><?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?></div>
    <?php }  ?>
    <div class="post-content">
        <div class="post-entry">
            <?php the_content(); ?>
        </div>
        <?php
            wp_link_pages( array(
                'before' => '<div class="page-links"><span class="page-link-label">' . esc_html__( 'Pages:', 'jannah-lite' ) . '</span>',
                'after'  => '</div>',
            ) );
        ?>
    </div>
</article>	