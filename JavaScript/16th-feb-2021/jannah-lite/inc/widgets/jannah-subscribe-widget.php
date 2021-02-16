<?php 
/**
 * Jannah Subscribe Widget
 *
 * @package    WordPress
 * @subpackage Jannah Lite
 * @since      Jannah Lite 1.0
 */

add_action('widgets_init', 'jannah_subscribe_widget');
function jannah_subscribe_widget() {
    register_widget('jannah_subscribe_widget');
}

class jannah_subscribe_widget extends WP_Widget{

    public function __construct(){
        parent::__construct('jannah_subscribe_widget',esc_html__('Jannah Subscribe','jannah-lite'),array(
            'description' => __('Mailchimp subscription form','jannah-lite'),
        ));
        
    }

    public function widget($args,$instance){
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $text = isset( $instance['text'] ) ? $instance['text'] : '<p>Hello form</p>';
        $text = apply_filters( 'wpml_translate_single_string', $text, 'jannah-lite', 'widget_content_'.$this->id );
        
        echo $args['before_widget'];

        if ( ! empty($instance['title']) ){
            echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
        }
        ?>

        <div class="widget-inner-wrap">
        <?php
            if( ! empty( $instance['show_icon'] ) ) { ?>
                <i class="fas fa-envelope newsletter-icon"></i>
                <?php
            }

            if( ! empty( $text ) ){ ?>
                <div class="subscribe-widget-content">
                    <?php echo do_shortcode( $text ) ?>
                </div>
                <?php
            }

            ?>
            <div id="mc_embed_signup-<?php echo esc_attr( $args['widget_id'] ) ?>">
                <form action="<?php echo esc_attr( $instance['mailchimp'] ) ?>" method="post" id="mc-embedded-subscribe-form-<?php echo esc_attr( $args['widget_id'] ) ?>" name="mc-embedded-subscribe-form" class="subscribe-form validate" target="_blank" novalidate>
                    <div class="mc-field-group">
                        <label class="screen-reader-text" for="mce-EMAIL-<?php echo esc_attr( $args['widget_id'] ) ?>"><?php esc_html_e( 'Enter your Email address', 'jannah-lite' ); ?></label>
                        <input type="email" value="" id="mce-EMAIL-<?php echo esc_attr( $args['widget_id'] ) ?>" placeholder="<?php esc_attr_e( 'Enter your Email address', 'jannah-lite' ); ?>" name="EMAIL" class="subscribe-input required email">
                    </div>
                    <input type="submit" value="<?php esc_attr_e( 'Subscribe', 'jannah-lite' ) ; ?>" name="subscribe" class="button subscribe-submit">
                </form>
            </div>
            <?php 
        ?>
        </div>

        <?php 
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ){
        $instance               = $old_instance;
        $instance['title']      = sanitize_text_field( $new_instance['title'] );
        $instance['text']       = $new_instance['text'];
        $instance['show_icon']  = ! empty( $new_instance['show_icon'] ) ? 'true' : false;
        $instance['mailchimp']  = $new_instance['mailchimp'];

        // WPML
        do_action( 'wpml_register_single_string', 'jannah-lite', 'widget_content_'.$this->id, $new_instance['text'] );

        return $instance;
    }

    public function form( $instance ){
        $defaults = array(
            'title' => esc_html__( 'Newsletter', 'jannah-lite'),
            'text'  => '<h4>With Product You Purchase</h4><h3>Subscribe to our mailing list to get the new updates!</h3><p>Lorem ipsum dolor sit amet, consectetur.</p>'
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        $title      = isset( $instance['title'] )      ? $instance['title']      : '';
        $mailchimp  = isset( $instance['mailchimp'] )  ? $instance['mailchimp']  : '';
        $text       = isset( $instance['text'] )       ? $instance['text']       : '';
        $show_icon  = isset( $instance['show_icon'] )  ? $instance['show_icon']  : '';


        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'jannah-lite') ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text above the Email input field', 'jannah-lite') ?></label>
            <textarea rows="3" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" class="widefat" ><?php echo esc_textarea( $text ) ?></textarea>
            <small><?php esc_html_e( 'Supports: Text, HTML and Shortcodes.', 'jannah-lite') ?></small>
        </p>

        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'show_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_icon' ) ); ?>" value="true" <?php checked( $show_icon, 'true' ); ?> type="checkbox" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_icon' ) ); ?>"><?php esc_html_e( 'Show the icon?', 'jannah-lite') ?></label>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'mailchimp' ) ); ?>"><?php esc_html_e( 'MailChimp Form Action URL', 'jannah-lite') ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'mailchimp' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'mailchimp' ) ); ?>" value="<?php echo esc_attr( $mailchimp ); ?>" class="widefat" type="text" />
        </p>

    <?php
    }
}