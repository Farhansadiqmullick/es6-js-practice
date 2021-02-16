<?php 
/**
 * Jannah Social Widget
 *
 * @package    WordPress
 * @subpackage Jannah Lite
 * @since      Jannah Lite 1.0
 */

add_action('widgets_init', 'jannah_social_widget');
function jannah_social_widget() {
    register_widget('jannah_social_widget');
}

class jannah_social_widget extends WP_Widget{

    public function __construct(){
        parent::__construct('jannah_social_widget',esc_html__('Jannah Social','jannah-lite'),array(
            'description' => __('Social profile links. Profile link settins on Customizer','jannah-lite'),
        ));
        
    }

    private static function get_defaults() {

        $defaults = array(
            'title' => 'Follow Us',
        );
        return $defaults;
    }



    public function form($instance){
        $instance = wp_parse_args( (array) $instance, self::get_defaults() );
        $title  = isset($instance['title'])? $instance['title']:'';
        ?>
        <p><?php _e('Set social share links from ', 'jannah-lite'); ?><strong><?php esc_html_e('Customize > Jannah Lite Settings > Social Profiles', 'jannah-lite'); ?></strong></p>
        <p>
            <label for="title"><?php esc_html_e('Title:','jannah-lite'); ?></label>
            <input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>"  name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function widget($args,$instance){
        $title  = !empty($instance['title'])? $instance['title']:'Follow Us';
    
        echo $args['before_widget'];

        if ( ! empty($instance['title']) ){
            echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
        }
        
        if(function_exists('jannah_social_profiles')){
            jannah_social_profiles();
        }

        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        //$instance = $old_instance;
        $new_instance = wp_parse_args( (array) $new_instance, self::get_defaults() );
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
}