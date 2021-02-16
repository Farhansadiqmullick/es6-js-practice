<?php 
/**
 * Jannah Post List Widget
 *
 * @package    WordPress
 * @subpackage Jannah Lite
 * @since      Jannah Lite 1.0
 */

add_action('widgets_init', 'jannah_post_list_widget');
function jannah_post_list_widget() {
    register_widget('jannah_post_list_widget');
}

class jannah_post_list_widget extends WP_Widget{

    public function __construct(){
        parent::__construct('jannah_post_list_widget',esc_html__('Jannah Post List','jannah-lite'),array(
            'description' => __('Post list by various attributes','jannah-lite'),
        ));
        
    }

    public function widget($args,$instance){
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $no_of_posts   = ! empty( $instance['no_of_posts'] )   ? $instance['no_of_posts'] : 5;
        $posts_order   = ! empty( $instance['posts_order'] )   ? $instance['posts_order'] : 'latest';
        $cats_id       = ! empty( $instance['cats_id'] )       ? explode ( ',', $instance['cats_id'] ) : [];
        $before_posts  = '<ul class="posts-list-items widget-posts-wrapper">';
        $after_posts   = '</ul>';
        
        $class = 'widget-posts-list-container';

        $query_args = array(
            'number' => $no_of_posts,
            'order'  => $posts_order,
            'id'     => $cats_id,
        );

        // Style
        $layouts = array(
            1  => '',
            2  => 'posts-list-counter',
            3  => 'posts-list-half-posts'
        );

        if( ! empty( $instance['style'] ) && ! empty( $layouts[ $instance['style'] ] ) ) {
            $class .= ' '.$layouts[ $instance['style'] ];

            if( $instance['style'] == 3 ){
                $query_args['thumbnail'] = 'jannah_blog_post_thumb';
            }
        }
    
        echo $args['before_widget'];

        if ( ! empty($instance['title']) ){
            echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
        }

        echo '<div class="'. $class .'">';
            echo ( $before_posts );

            jannah_widget_posts( $query_args );

            echo ( $after_posts );
        echo "</div>";

        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ){
        $instance                    = $old_instance;
        $instance['title']           = sanitize_text_field( $new_instance['title'] );
        $instance['no_of_posts']     = $new_instance['no_of_posts'];
        $instance['posts_order']     = $new_instance['posts_order'];
        $instance['style']           = $new_instance['style'];

        if( ! empty( $new_instance['cats_id'] ) && is_array( $new_instance['cats_id'] ) ){
            $instance['cats_id'] = implode( ',', $new_instance['cats_id'] );
        }
        else{
            $instance['cats_id'] = false;
        }

        return $instance;
    }

    public function form( $instance ){
        $defaults = array( 'title' => esc_html__('Recent Posts', 'jannah-lite') , 'no_of_posts' => '5', 'posts_order' => 'latest' );
        $instance = wp_parse_args( (array) $instance, $defaults );

        $title           = ! empty( $instance['title'] )           ? $instance['title']       : '';
        $no_of_posts     = ! empty( $instance['no_of_posts'] )     ? $instance['no_of_posts'] : 5;
        $posts_order     = ! empty( $instance['posts_order'] )     ? $instance['posts_order'] : 'latest';
        $style           = ! empty( $instance['style'] )           ? $instance['style'] : 1;    
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
            
            <label><?php esc_html_e( 'Style', 'jannah-lite') ?></label>

            <div class="jannah-widget-radio-img">
				<p>
					<?php
						for ( $i=1; $i < 4; $i++ ){ ?>
							<label class="jannah-widget-options">
								<input name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>" type="radio" value="<?php echo esc_attr( $i ) ?>" <?php echo checked( $style, $i ) ?>> <img src="<?php echo JANNAH_THEME_URI .'/images/widgets/posts-'.$i.'.png'; ?>" />
							</label>
							<?php
						}
					?>
				</p>
			</div>
        <?php 
    }
}