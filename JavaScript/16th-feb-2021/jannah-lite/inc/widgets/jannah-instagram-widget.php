<?php

/**
 * Jannah Instagram Widget
 *
 * @package    WordPress
 * @subpackage Jannah Lite
 * @since      Jannah Lite 1.0
 * @see https://publish.instagram.com/
 * @see https://dev.instagram.com/web/embedded-timelines
 * 
 */

add_action('widgets_init', 'jannah_instagram_widget');
function jannah_instagram_widget()
{
    register_widget('jannah_instagram_widget');
}

class jannah_instagram_widget extends WP_Widget
{

    /**
     * Default instance.
     */
    protected $default_instance;

    /**
     * Form Options
     */
    protected $instagram_timeline_type;


    public function __construct()
    {
        // Initialize Default Instance
        $this->default_instance = array(
            'title'               => esc_html__('Instagram Feed', 'jannah-lite'),
            'instagram_username'     => 'instagram',
            'instagram_items'       => 9,
            'instagram_items_per_row'  => 3,
        );

        parent::__construct('jannah_instagram_widget', esc_html__('Jannah Instagram', 'jannah-lite'), array(
            'customize_selective_refresh' => true,
        ));
    }

    public function widget($args, $instance)
    {
        $instance = wp_parse_args((array) $instance, $this->default_instance);

        $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo ($args['before_title'] . $instance['title'] . $args['after_title']);
        }
?>
        <div class="instagram-widget widget-inner-wraper">
            <div class="jannah-instagram-gallery gallery-row-<?php echo esc_attr($instance['instagram_items_per_row']); ?>" data-username="<?php echo esc_attr($instance['instagram_username']); ?>" data-items="<?php echo esc_attr($instance['instagram_items']); ?>" data-row="<?php echo esc_attr($instance['instagram_items_per_row']); ?>"></div>
        </div>

    <?php
        echo $args['after_widget'];
    }

    public function update($new_instance, $old_instance)
    {
        // Instance
        $instance = $old_instance;

        // Sanitization
        $instance['title'] = sanitize_text_field($new_instance['title']);

        $instance['instagram_username'] = sanitize_text_field($new_instance['instagram_username']);

        $instagram_items = absint($new_instance['instagram_items']);
        $instance['instagram_items'] = ($instagram_items ? $instagram_items : null);

        $instagram_items_per_row = absint($new_instance['instagram_items_per_row']);
        $instance['instagram_items_per_row'] = ($instagram_items_per_row ? $instagram_items_per_row : null);

        return $instance;
    }

    public function form($instance)
    {
        // Merge the instance arguments with the defaults.
        $instance = wp_parse_args((array) $instance, $this->default_instance);

    ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'jannah-lite'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('instagram_username')); ?>"><?php esc_html_e('instagram Username:', 'jannah-lite'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram_username')); ?>" name="<?php echo esc_attr($this->get_field_name('instagram_username')); ?>" value="<?php echo esc_attr($instance['instagram_username']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('instagram_items')); ?>"><?php esc_html_e('Number of Photo Shown:', 'jannah-lite'); ?></label>
            <input type="number" min="1" max="20" class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram_items')); ?>" name="<?php echo esc_attr($this->get_field_name('instagram_items')); ?>" value="<?php echo esc_attr($instance['instagram_items']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('instagram_items_per_row')); ?>"><?php esc_html_e('Number of Photo Shown:', 'jannah-lite'); ?></label>
            <input type="number" min="1" max="20" class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram_items_per_row')); ?>" name="<?php echo esc_attr($this->get_field_name('instagram_items_per_row')); ?>" value="<?php echo esc_attr($instance['instagram_items_per_row']); ?>" />
        </p>
<?php
    }
}
