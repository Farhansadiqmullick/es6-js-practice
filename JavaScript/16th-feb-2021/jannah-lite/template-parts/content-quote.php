<?php
    if(is_single()){ ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php 
        if(get_theme_mod('post_cats_switch', true) == true){
            $cats = get_the_category();
            if(!empty($cats)){
                echo '<div class="post-single-categories">';
                foreach($cats as $cat){
                    $color = get_term_meta( $cat->term_id, '_category_color', true ) ? get_term_meta( $cat->term_id, '_category_color', true ) : 'aaaaaa'; 
                    printf('<a href="%s" style="background-color: #%s">%s</a>', get_term_link($cat->term_id), esc_attr($color), $cat->name);
                }
                echo '</div>';
            }
        }
        ?>
        <h1 class="post-title"><?php the_title(); ?></h1>
        <?php if(get_theme_mod('postmeta_switch', true) == true) { ?>
            <div class="post-metas">
                <div>
                    <a class="author-meta post-meta" href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php echo get_avatar(get_the_author_meta('ID'), 30, 'wavatar', get_the_author_meta('display_name'), array('class'=>'img-fluid')); ?><span class="author-name"><?php the_author_meta( 'display_name' ); ?></span></a>
                    <span class="post-date post-meta"><i class="far fa-clock"></i><?php the_time(get_option( 'date_format' )); ?></span>
                </div>
                <div>
                    <a class="post-meta comment-count" href="<?php comments_link(); ?>"><i class="fas fa-comments"></i><?php comments_number( '0', '1', '%' ); ?></a>
                    <span class="post-meta post-view"><?php echo JANNAH_POSTVIEWS::get_views('<i class="fas fa-fire"></i>', get_the_ID()); ?></span>
                </div>
            </div>    
        <?php } ?>
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
			<?php
			if(get_theme_mod('post_tags_switch', true) == true) { ?>
                <div class="post-tags">
                    <?php the_tags('', ''); ?>
                </div>
            <?php } ?>
        </div>
        <!-- Post share link -->
        <?php
        if ( get_theme_mod('post_share_switch', true) == true && function_exists( 'jannah_social_share' ) ) {
            jannah_social_share(get_the_permalink(), get_the_title());
        }
        ?>
    </article>	

    <div class="post-components">
        <?php 
            if(get_theme_mod('post_authorbox_switch', true) == true && function_exists( 'wpsabox_author_box' )) { echo wpsabox_author_box(); }
            if(comments_open() || get_comments_number()) { comments_template(); }
        ?>
    </div>
<?php
    } else {
?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if ( has_post_thumbnail()) { ?>
            <a class="post-thumb" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('jannah_blog_post_thumb', array('class' => 'img-fluid')); ?></a>
        <?php }  ?>
        <div class="post-content">
            <div class="post-metas">
                <div>
                    <a class="author-meta post-meta" href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><i class="far fa-user"></i><?php the_author_meta( 'display_name' ); ?></a>
                    <span class="post-date post-meta"><i class="far fa-clock"></i><?php the_time(get_option( 'date_format' )); ?></span>
                </div>
                <div>
                    <a class="post-meta comment-count" href="<?php comments_link(); ?>"><i class="fas fa-comments"></i><?php comments_number( '0', '1', '%' ); ?></a>
                    <span class="post-meta post-view"><?php echo JANNAH_POSTVIEWS::get_views('<i class="fas fa-fire"></i>', get_the_ID()); ?></span>
                </div>
            </div>
            <h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <p class="post-excerpt">
                <?php print jannah_excerpt(18); ?>
            </p>
            <a class="more-link" href="<?php the_permalink(); ?>"><?php _e('Read More &raquo;', 'jannah-lite'); ?></a>
        </div>
    </article>
<?php } ?>
