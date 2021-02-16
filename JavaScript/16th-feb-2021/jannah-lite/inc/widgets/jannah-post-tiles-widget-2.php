<?php 
/**
 * Jannah Post Tiles Widget 2
 *
 * @package    WordPress
 * @subpackage Jannah Lite
 * @since      Jannah Lite 1.0
 */

add_action('widgets_init', 'jannah_post_tiles_widget_2');
function jannah_post_tiles_widget_2() {
    register_widget('jannah_post_tiles_widget_2');
}

class jannah_post_tiles_widget_2 extends WP_Widget{

    public function __construct(){
        parent::__construct('jannah_post_tiles_widget_2',esc_html__('Jannah Post Tiles 2','jannah-lite'),array(
            'description' => __('Post tiles style 2','jannah-lite'),
        ));
        
    }

    public function widget($arg,$instance){
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $no_of_posts   = ! empty( $instance['no_of_posts'] )   ? $instance['no_of_posts'] : 3;
        $posts_order   = ! empty( $instance['posts_order'] )   ? $instance['posts_order'] : 'latest';
        $cats_id       = ! empty( $instance['cats_id'] )       ? explode ( ',', $instance['cats_id'] ) : [];
        $before_posts  = '<div class="posts-tile-2-items widget-posts-wrapper">';
        $after_posts   = '</div>';
        
        $class = 'widget-posts-list-container';
    
        echo $arg['before_widget'];

        if ( ! empty($instance['title']) ){
            echo ( $arg['before_title'] . $instance['title'] . $arg['after_title'] );
        }

        echo '<div class="'. $class .'">';
            echo $before_posts;

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
                while( $query->have_posts() ){
                    $query->the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <a href="<?php the_permalink(); ?>" class="post-thumb" style="background-image: url(<?php the_post_thumbnail_url('jannah_big_thumb'); ?>)"></a>
                        <div class="thumb-overlay">

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

                            <div class="post-content">
                                <p class="post-date"><i class="far fa-clock"></i><?php the_time(get_option( 'date_format' )); ?></p>
                                <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h4>
                                <p class="post-excerpt">
                                    <?php print jannah_excerpt(18); ?>
                                </p>                                
                            </div>
                            
                        </div>
                    </article>
                    <?php 
                }
            }

            wp_reset_postdata();

            echo $after_posts;
        echo "</div>";

        echo $arg['after_widget'];
    }

    public function update( $new_instance, $old_instance ){
        $instance                    = $old_instance;
        $instance['title']           = sanitize_text_field( $new_instance['title'] );
        $instance['posts_order']     = $new_instance['posts_order'];
        $instance['no_of_posts']     = $new_instance['no_of_posts'];

        if( ! empty( $new_instance['cats_id'] ) && is_array( $new_instance['cats_id'] ) ){
            $instance['cats_id'] = implode( ',', $new_instance['cats_id'] );
        }
        else{
            $instance['cats_id'] = false;
        }

        return $instance;
    }

    public function form( $instance ){
        $defaults = array( 'title' => '', 'posts_order' => 'latest' );
        $instance = wp_parse_args( (array) $instance, $defaults );

        $title           = ! empty( $instance['title'] )           ? $instance['title']       : '';
        $no_of_posts     = ! empty( $instance['no_of_posts'] )     ? $instance['no_of_posts'] : 3;
        $posts_order     = ! empty( $instance['posts_order'] )     ? $instance['posts_order'] : 'latest';  
        $cats_id         = array();

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
        <?php 
    }
}