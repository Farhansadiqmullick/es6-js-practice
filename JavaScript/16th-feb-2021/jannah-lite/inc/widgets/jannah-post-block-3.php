<?php 
/**
 * Jannah Post Block 3
 *
 * @package    WordPress
 * @subpackage Jannah Lite
 * @since      Jannah Lite 1.0
 */

add_action('widgets_init', 'jannah_post_block_3');
function jannah_post_block_3() {
    register_widget('jannah_post_block_3');
}

class jannah_post_block_3 extends WP_Widget{

    public function __construct(){
        parent::__construct('jannah_post_block_3',esc_html__('Jannah Post Block 3','jannah-lite'),array(
            'description' => __('Post block style 3','jannah-lite'),
        ));
        
    }

    public function widget($arg,$instance){
        
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $no_of_posts   = ! empty( $instance['no_of_posts'] )   ? $instance['no_of_posts'] : 3;
        $posts_order   = ! empty( $instance['posts_order'] )   ? $instance['posts_order'] : 'latest';
        $cats_id       = ! empty( $instance['cats_id'] )       ? explode ( ',', $instance['cats_id'] ) : [];
        $archive_link = !empty($instance['archive_link']) ? $instance['archive_link'] : false;
        $bg_color   = ! empty( $instance['bg_color'] )   ? $instance['bg_color']   : '';
        $font_color = ! empty( $instance['font_color'] ) ? $instance['font_color'] : '';
        $before_posts  = '<div class="posts-block-3-items widget-posts-wrapper">';
        $after_posts   = '</div>';
        
        $class = 'widget-posts-list-container';

        if(!empty($instance['half_width'])){
            $arg['before_widget'] = str_replace('class="', 'class="widget-half-width ', $arg['before_widget']);
        }
    
        echo $arg['before_widget'];

        if ( ! empty($instance['title']) ){
            echo $arg['before_title'] . $instance['title'];

            if($archive_link){
                if(empty($cats_id)){
                    if ( 'page' == get_option( 'show_on_front' ) ) {
                        if ( get_option( 'page_for_posts' ) ) {
                            $post_page_url = esc_url( get_permalink( get_option( 'page_for_posts' ) ) );
                        } else {
                            $post_page_url = esc_url( home_url( '/?post_type=post' ) );
                        }
                    } else {
                        $post_page_url = esc_url( home_url( '/' ) );
                    }
                } else {
                    $firstCat = get_category_by_slug($cats_id[0]);
                    $post_page_url = get_category_link($firstCat->term_id);
                }
                echo '<a class="archive-title" href="'.$post_page_url.'">'.esc_html__('See All', 'jannah-lite').'</a>';
            }

            echo $arg['after_title'];
        }

        echo '<div class="'. $class .'">';
            echo ( $before_posts );

            $args = array(
                'post_status'           => array( 'publish' ),
                'ignore_sticky_posts'   => true,
                'posts_per_page'        => $no_of_posts,
            );

            if(isset($posts_order)){
                if($posts_order == 'views'){
                    $args['order'] = 'DESC';
                    $args['orderby'] = 'meta_value_num';
                    $args['meta_key'] = 'jannah_views';
                }
    
                if($posts_order == 'comments'){
                    $args['orderby'] = 'comment_count';
                }
    
                if($posts_order == 'rand'){
                    $args['orderby'] = 'rand';
                    $args['order']   = 'ASC';
                }
                
                if($posts_order == 'modified'){
                    $args['orderby']    = 'modified';
                    $args['order']      = 'DESC';
                }
    
                if($posts_order == 'title'){
                    $args['orderby'] = 'title';
                    $args['order'] = 'ASC';
                }
            }

            if(!empty($instance['cats_id'])){
                $args['category_name'] = $instance['cats_id'];
            }

            $query = new WP_Query( $args );

            if( $query->have_posts() ){
                $featured_1_done = false;
                while( $query->have_posts() ){
                    $query->the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <?php if($featured_1_done == false){ ?>
                            <div class="post-thumb-wrapper">
                                <a href="<?php the_permalink(); ?>" class="post-thumb">
                                <?php if ( has_post_thumbnail() ){ ?>
                                    <?php the_post_thumbnail('jannah_blog_post_thumb', array('class' => 'img-fluid')); ?>
                                <?php } ?>
                                </a>
                                <?php
                                $cats = get_the_category();
                                if(!empty($cats)){
                                    echo '<div class="post-single-categories">';
                                    foreach($cats as $cat){
                                        $color = get_term_meta( $cat->term_id, '_category_color', true ) ? get_term_meta( $cat->term_id, '_category_color', true ) : 'aaaaaa'; 
                                        printf('<a href="%s" style="background-color: #%s">%s</a>', get_term_link($cat->term_id), esc_attr($color), $cat->name);
                                    }
                                    echo '</div>';
                                }
                                ?>
                            </div>
                    
                            <div class="thumb-overlay">

                                <div class="post-content">
                                    <div class="post-metas">
                                        <div>
                                            <a class="author-meta post-meta" href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><i class="far fa-user-circle"></i><span class="author-name"><?php the_author_meta( 'display_name' ); ?></span></a>
                                            <span class="post-date post-meta"><i class="far fa-clock"></i><?php the_time(get_option( 'date_format' )); ?></span>
                                        </div>
                                        <div>
                                            <a class="post-meta comment-count" href="<?php comments_link(); ?>"><i class="fas fa-comments"></i><?php comments_number( '0', '1', '%' ); ?></a>
                                            <span class="post-meta post-view"><?php echo JANNAH_POSTVIEWS::get_views('<i class="fas fa-fire"></i>', get_the_ID()); ?></span>
                                        </div>
                                    </div>  
                                    <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h4>    
                                    <p class="post-excerpt">
                                        <?php print jannah_excerpt(18); ?>
                                    </p> 
                                    <a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More »', 'jannah-lite'); ?></a>                          
                                </div>
                                
                            </div>
                        <?php 
                        $featured_1_done = true;
                        } else { ?>
                            <a href="<?php the_permalink(); ?>" class="post-thumb">
                            <?php if ( has_post_thumbnail() ){ ?>
                                <?php the_post_thumbnail('jannah_small_thumb', array('class' => 'img-fluid')); ?>
                            <?php } ?>
                            </a>

                            <div class="thumb-overlay">
                                <div class="post-content">
                                    <p class="post-date"><i class="far fa-clock"></i><?php the_time(get_option( 'date_format' )); ?></p>
                                    <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h4>                               
                                </div>                                
                            </div>
                        <?php } ?>
                    </article>
                    <?php 
                }
            }

            wp_reset_postdata();

            echo ( $after_posts );
        echo "</div>";

        $widget_id = '#'. $arg['widget_id'];

        if ( ! empty( $bg_color ) || ! empty( $font_color ) ){
            $out = "<style scoped type=\"text/css\">";

            if ( ! empty( $font_color ) ){
                $out .= "
                    $widget_id .widget-title,
                    $widget_id .posts-block-3-items .post .post-title a:hover,
                    $widget_id .posts-block-3-items .post:first-child a.post-meta:hover {
                        color: $font_color;
                    }
                    $widget_id .widget-title:before {
                        border-top-color: $font_color;
                    }
                    $widget_id .widget-title:after {
                        background-color: $font_color;
                    }

                    $widget_id .archive-title:hover{
                        background-color: $font_color;
                        border-color: $font_color;
                    }
                    $widget_id .posts-block-3-items .post:first-child a.post-meta:hover{
                        color: $font_color;
                    }
                    $widget_id .more-link{
                        background-color: $font_color;
                    }
                    $widget_id .more-link:hover{
                        opacity: 0.85;
                    }
                ";
            }

            if( !empty( $bg_color ) ) {
                $out .= "
                    $widget_id {
                        padding: 30px;
                        background-color: $bg_color;
                    }
                    $widget_id .widget-title{
                        border-color: rgba(255,255,255,0.1);
                    }
                    $widget_id .archive-title{
                        color: white;
                        border-color: rgba(255,255,255, 0.1);
                    }

                    $widget_id .posts-block-3-items .post .post-title{
                        color: white;
                    }

                    $widget_id .posts-block-3-items .post:first-child .post-metas,
                    $widget_id .posts-block-3-items .post .post-date{
                        color: #ccc;
                    }

                    $widget_id .posts-block-3-items .post:first-child .post-excerpt{
                        color: #666666;
                    }
                ";
            }

            $out .= '</style>';

            echo $out;
        }

        echo $arg['after_widget'];
    }

    public function update( $new_instance, $old_instance ){
        $instance                    = $old_instance;
        $instance['title']           = sanitize_text_field( $new_instance['title'] );
        $instance['no_of_posts']     = $new_instance['no_of_posts'];
        $instance['posts_order']     = $new_instance['posts_order'];
        $instance['archive_link']   = ! empty( $new_instance['archive_link'] )   ? 'true' : false;
        $instance['half_width']   = ! empty( $new_instance['half_width'] )   ? 'true' : false;
        $instance['font_color']    = strip_tags($new_instance['font_color']);
        $instance['bg_color']      = strip_tags($new_instance['bg_color']);

        if( ! empty( $new_instance['cats_id'] ) && is_array( $new_instance['cats_id'] ) ){
            $instance['cats_id'] = implode( ',', $new_instance['cats_id'] );
        }
        else{
            $instance['cats_id'] = false;
        }

        return $instance;
    }

    public function form( $instance ){
        $defaults = array( 'title' => '', 'posts_order' => 'latest', 'archive_link' => false );
        $instance = wp_parse_args( (array) $instance, $defaults );

        $title           = ! empty( $instance['title'] )           ? $instance['title']       : '';
        $no_of_posts     = ! empty( $instance['no_of_posts'] )     ? $instance['no_of_posts'] : 3;
        $posts_order     = ! empty( $instance['posts_order'] )     ? $instance['posts_order'] : 'latest';  
        $cats_id         = array();
        $archive_link    = isset( $instance['archive_link'] ) ?   esc_attr( $instance['archive_link'] )   : false;
        $half_width    = isset( $instance['half_width'] ) ?   esc_attr( $instance['half_width'] )   : false;
        $font_color    = isset( $instance['font_color'] )    ? esc_attr( $instance['font_color'])     : '';
        $bg_color      = isset( $instance['bg_color'] )      ? esc_attr( $instance['bg_color'])       : '';

        if( ! empty( $instance['cats_id'] ) ) {
            $cats_id = explode ( ',', $instance['cats_id'] );
        }

        $post_order = array(
            'latest'   => esc_html__( 'Recent Posts',         'jannah-lite' ),
            'rand'     => esc_html__( 'Random Posts',         'jannah-lite' ),
            'modified' => esc_html__( 'Last Modified Posts',  'jannah-lite' ),
            'comments'  => esc_html__( 'Most Commented posts', 'jannah-lite' ),
            'title'    => esc_html__( 'Alphabetically',       'jannah-lite' ),
            'views'    => esc_html__( 'Most Viewed posts',    'jannah-lite' )
        );

        $categories = jannah_cat_list();

        ?>
            <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'jannah-lite') ?></label>
				<input id="<?php echo esc_attr(  $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
            </p>
            
            <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'posts_order' ) ); ?>"><?php esc_html_e( 'Posts order:', 'jannah-lite') ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'posts_order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_order' ) ); ?>" class="widefat">
					<?php
						foreach( $post_order as $order => $text ){ ?>
                            <option value="<?php echo esc_attr( $order ) ?>" <?php selected( $posts_order, $order ); ?>><?php echo esc_html( $text ) ?></option>
                        <?php
						}
					?>
				</select>
            </p>
            
            <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cats_id' ) ); ?>"><?php esc_html_e( 'Categories', 'jannah-lite') ?></label>
				<select multiple="multiple" id="<?php echo esc_attr( $this->get_field_id( 'cats_id' ) ); ?>[]" name="<?php echo esc_attr( $this->get_field_name( 'cats_id' ) ); ?>[]" class="widefat">
					<?php foreach ($categories as $key => $option){ ?>
					<option value="<?php echo esc_attr( $key ) ?>" <?php if ( in_array( $key , $cats_id ) ){ echo ' selected="selected"' ; } ?>><?php echo esc_html( $option ); ?></option>
					<?php } ?>
				</select>
            </p>

            <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'no_of_posts' ) ); ?>"><?php esc_html_e( 'Number of posts to show', 'jannah-lite') ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'no_of_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'no_of_posts' ) ); ?>" value="<?php echo esc_attr( $no_of_posts ) ?>" type="number" step="1" min="1" size="3" class="tiny-text" />
            </p>

            <p>
                <input id="<?php echo esc_attr( $this->get_field_id( 'archive_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'archive_link' ) ); ?>" value="true" <?php checked( $archive_link, 'true' ); ?> type="checkbox" />
                <label for="<?php echo esc_attr( $this->get_field_id( 'archive_link' ) ); ?>"><?php esc_html_e( 'Archive link on header?', 'jannah-lite') ?></label>
            </p>

            <p>
                <input id="<?php echo esc_attr( $this->get_field_id( 'half_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'half_width' ) ); ?>" value="true" <?php checked( $half_width, 'true' ); ?> type="checkbox" />
                <label for="<?php echo esc_attr( $this->get_field_id( 'half_width' ) ); ?>"><?php esc_html_e( 'Half width widget?', 'jannah-lite') ?></label>
            </p>

            <hr />
            <br />
            <strong><?php esc_html_e('Style', 'jannah-lite'); ?><br /></strong>

            <div class="jannah-custom-color-picker">
                <label for="<?php echo esc_attr( $this->get_field_id( 'bg_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Background Color', 'jannah-lite' ); ?></label>
                <input class="widget-colorpicker" id="<?php echo esc_attr( $this->get_field_id( 'bg_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'bg_color' ) ); ?>" type="text" value="<?php echo esc_attr( $bg_color ) ?>" />
            </div>

            <div class="jannah-custom-color-picker">
                <label for="<?php echo esc_attr( $this->get_field_id( 'font_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Text Color', 'jannah-lite' ); ?></label>
                <input class="widget-colorpicker" id="<?php echo esc_attr( $this->get_field_id( 'font_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'font_color' ) ); ?>" type="text" value="<?php echo esc_attr( $font_color ) ?>" />
            </div>
        <?php 
    }
}