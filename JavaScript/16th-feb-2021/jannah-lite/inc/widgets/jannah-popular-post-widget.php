<?php

/**
 * Jannah Popular Post List Widget
 *
 * @package    WordPress
 * @subpackage Jannah Lite
 * @since      Jannah Lite 1.0
 */

add_action('widgets_init', 'jannah_popular_post_widget');
function jannah_popular_post_widget()
{
    register_widget('jannah_popular_post_widget');
}

class jannah_popular_post_widget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct('jannah_popular_post_widget', esc_html__('Jannah Popular Post', 'jannah-lite'), array(
            'description' => __('Most Viewed Posts List', 'jannah-lite'),
        ));
    }

    public function widget($args, $instance)
    {
        $instance['title'] = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $no_of_posts   = !empty($instance['no_of_posts'])   ? $instance['no_of_posts'] : 3;
        $before_posts  = '<ul class="popular-post-list widget-posts-wrapper">';
        $after_posts   = '</ul>';

        $class = 'widget-popular-list-container';

        $query_args = array(
            'number' => $no_of_posts,
        );

        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo ($args['before_title'] . $instance['title'] . $args['after_title']);
        }

        echo '<div class="' . $class . '">';
        echo ($before_posts);

        jannah_widget_popular_posts($query_args);

        echo ($after_posts);
        echo "</div>";

        echo $args['after_widget'];
    }

    public function update($new_instance, $old_instance)
    {
        $instance                    = $old_instance;
        $instance['title']           = sanitize_text_field($new_instance['title']);
        $instance['no_of_posts']     = $new_instance['no_of_posts'];

        return $instance;
    }

    public function form($instance)
    {
        $defaults = array('title' => esc_html__('Popular Posts', 'jannah-lite'), 'no_of_posts' => '3');
        $instance = wp_parse_args((array) $instance, $defaults);

        $title           = !empty($instance['title'])           ? $instance['title']       : '';
        $no_of_posts     = !empty($instance['no_of_posts'])     ? $instance['no_of_posts'] : 3;

?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'jannah-lite') ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" class="widefat" type="text" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('no_of_posts')); ?>"><?php esc_html_e('Number of posts to show', 'jannah-lite') ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('no_of_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('no_of_posts')); ?>" value="<?php echo esc_attr($no_of_posts) ?>" type="number" step="1" min="1" size="3" class="tiny-text" />
        </p>
<?php
    }
}
