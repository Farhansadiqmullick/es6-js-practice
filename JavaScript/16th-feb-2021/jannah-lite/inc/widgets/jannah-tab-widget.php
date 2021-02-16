<?php 
/**
 * Jannah Tab Widget
 *
 * @package    WordPress
 * @subpackage Jannah Lite
 * @since      Jannah Lite 1.0
 */

add_action('widgets_init', 'jannah_tabs_widget');
function jannah_tabs_widget() {
    register_widget('jannah_tabs_widget');
}

class jannah_tabs_widget extends WP_Widget{

    public function __construct(){
        parent::__construct('jannah_tabs_widget',esc_html__('Jannah Tabs','jannah-lite'),array(
            'description' => __('Post by tab','jannah-lite'),
        ));
        
    }

    private static function get_defaults() {

        $defaults = array(
            'title' => '',
            'posts_order' => 'views',
            'posts_number' => 5

        );
        return $defaults;
    }



    public function form($instance){
        $instance = wp_parse_args( (array) $instance, self::get_defaults() );
        $title  = isset($instance['title'])? $instance['title']:'';
        $posts_number = empty( $instance['posts_number'] ) ? 5 : $instance['posts_number'];
		$posts_order  = isset( $instance['posts_order'] )  ? $instance['posts_order'] : 'views';
        ?>
        <p>
            <label for="title"><?php esc_html_e('Title:','jannah-lite'); ?></label>
            <input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>"  name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>"><?php esc_html_e( 'Number of items to show:', 'jannah-lite') ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_number' ) ); ?>" value="<?php echo esc_attr( $posts_number ) ?>" type="number" step="1" min="1" size="3" class="tiny-text" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'posts_order' ) ); ?>"><?php esc_html_e( 'Popular tab order', 'jannah-lite') ?></label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'posts_order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_order' ) ); ?>" class="widefat">
                <option value="comments" <?php selected( $posts_order, 'comments' ) ?>><?php esc_html_e( 'Most Commented', 'jannah-lite') ?></option>
                <option value="views" <?php selected( $posts_order, 'views' )  ?>><?php esc_html_e( 'Most Viewed', 'jannah-lite') ?></option>
            </select>
        </p>
        <?php
    }

    public function widget($args,$instance){
        $title  = !empty($instance['title'])? $instance['title']:'';
        $posts_number = empty( $instance['posts_number'] ) ? 5 : $instance['posts_number'];

        // Get the Order of tabs
        $tabs_order = 'r,p,c';
        if( ! empty( $instance['tabs_order'] ) ){
            $tabs_order = $instance['tabs_order'];
        }

        $tabs_order_array = explode( ',', $tabs_order );

        // Check the disabled tabs
        $disabled_tabs = array(
            'disable_recent'   => 'r',
            'disable_popular'  => 'p',
            'disable_comments' => 'c',
        );

        foreach ( $disabled_tabs as $option => $tab_id ) {
            if( ! empty( $instance[ $option ] ) && ( $key = array_search( $tab_id, $tabs_order_array ) ) !== false ){
                unset( $tabs_order_array[ $key ] );
            }
        }

        // Return if all Tabs are disabled !!
        if( empty( $tabs_order_array ) ){
            return;
        }

        $popular_order = 'views';

        if( ! empty( $instance['posts_order'] ) ){
            $popular_order = $instance['posts_order'];
        }
    
        echo $args['before_widget'];

        if ( ! empty($instance['title']) ){
            echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
        }
        
        ?>
        <div class="container-wrapper tabs-container-wrapper tabs-container-<?php echo count( $tabs_order_array ) ?>">
            <ul class="tabs">
                <?php

                    // Widget ID
                    $id        = explode( '-', $this->get_field_id( 'widget_id' ));
                    $widget_id =  $id[1] .'-'. $id[2];

                    foreach ( $tabs_order_array as $tab ){

                        if( $tab == 'p' ){
                            echo '<li><a href="#'.$widget_id.'-popular">'. __('Popular', 'jannah-lite') .'</a></li>';
                        }

                        elseif( $tab == 'r' ){
                            echo '<li class="active"><a href="#'.$widget_id.'-recent">'. __('Recent', 'jannah-lite') .'</a></li>';
                        }

                        elseif( $tab == 'c' ){
                            echo '<li><a href="#'.$widget_id.'-comments">'. __('Comments', 'jannah-lite') .'</a></li>';
                        }

                    }

                ?>
            </ul>
            <?php
                foreach ( $tabs_order_array as $tab ){
                    if( $tab == 'p' ): ?>
                        <div id="<?php echo esc_attr( $widget_id ) ?>-popular" class="tab-content tab-content-popular">
                            <ul class="tab-content-elements">
                                <?php jannah_widget_posts( array( 'number' => $posts_number, 'order' => $popular_order )); ?>
                            </ul>
                        </div>
                    <?php 
                    elseif( $tab == 'r' ): ?>

                        <div id="<?php echo esc_attr( $widget_id ) ?>-recent" class="tab-content tab-content-recent active">
                            <ul class="tab-content-elements">
                                <?php jannah_widget_posts( array( 'number' => $posts_number ));?>
                            </ul>
                        </div>

                    <?php
                    elseif( $tab == 'c' ): ?>

                        <div id="<?php echo esc_attr( $widget_id ) ?>-comments" class="tab-content tab-content-comments">
                            <ul class="tab-content-elements">
                                <?php jannah_recent_comments( $posts_number );?>
                            </ul>
                        </div>
                    <?php 
                    endif;
                } 
            ?>
        </div>
        <?php 

        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        //$instance = $old_instance;
        $new_instance = wp_parse_args( (array) $new_instance, self::get_defaults() );
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['posts_number']     = $new_instance['posts_number'];
		$instance['posts_order']      = $new_instance['posts_order'];
        return $instance;
    }
}