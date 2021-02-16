<?php 
/**
 * Jannah Categories Widget
 *
 * @package    WordPress
 * @subpackage Jannah Lite
 * @since      Jannah Lite 1.0
 */

add_action('widgets_init', 'jannah_categories_widget');
function jannah_categories_widget() {
    register_widget('jannah_categories_widget');
}

class jannah_categories_widget extends WP_Widget{

    public function __construct(){
        parent::__construct('jannah_categories_widget',esc_html__('Jannah Categories','jannah-lite'),array(
            'description' => __('Category list with count','jannah-lite'),
        ));
        
    }

    public function widget( $args, $instance ){
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        echo ( $args['before_widget'] );

        if ( ! empty($instance['title']) ){
            echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
        }

        $depth = empty( $instance['depth'] ) ? 1 : 0;

        $categories = wp_list_categories( array(
            'echo'       => false,
            'title_li'   => 0,
            'show_count' => 1,
            'depth'      => $depth,
            'orderby'    => 'count',
            'order'      => 'DESC',
        ));

        $categories = str_replace( 'cat-item-', 'cat-counter jannah-cat-item-', $categories );
        $categories = preg_replace( '~\((.*?)\)~', '<span>$1</span>', $categories );

        echo "<ul>$categories</ul>";

        echo ( $args['after_widget'] );
    }

    public function update( $new_instance, $old_instance ){
        $instance          = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['depth'] = ! empty( $new_instance['depth'] ) ? 'true' : 0;
        return $instance;
    }

    public function form( $instance ){
        $defaults = array( 'title' => esc_html__('Categories', 'jannah-lite')  );
        $instance = wp_parse_args( (array) $instance, $defaults );
        $title    = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $depth    = ! empty( $instance['depth'] ) ? $instance['depth'] : ''; ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'jannah-lite') ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
        </p>

        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'depth' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'depth' ) ); ?>" value="true" <?php checked( $depth, 'true' ); ?> type="checkbox" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'depth' ) ); ?>"><?php esc_html_e( 'Show child categories?', 'jannah-lite') ?></label>
        </p>
    <?php
    }
}