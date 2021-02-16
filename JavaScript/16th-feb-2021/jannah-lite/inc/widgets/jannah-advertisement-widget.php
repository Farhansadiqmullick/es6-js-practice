<?php 
/**
 * Jannah Ad Widget
 *
 * @package    WordPress
 * @subpackage Jannah Lite
 * @since      Jannah Lite 1.0
 */

add_action('widgets_init', 'jannah_ad_widget');
function jannah_ad_widget() {
    register_widget('jannah_ad_widget');
}

class jannah_ad_widget extends WP_Widget{
    const VERSION = '4.2.2';

    public function __construct(){
        parent::__construct('jannah_ad_widget',esc_html__('Jannah Ad','jannah-lite'),array(
            'description' => esc_html__('Show advertise','jannah-lite'),
        ));
        
        add_action( 'sidebar_admin_setup', array( $this, 'admin_setup' ) );
        add_action( 'admin_head-widgets.php', array( $this, 'admin_head' ) );
        
    }
    public function admin_setup() {
        wp_enqueue_media();
        wp_enqueue_script( 'tribe-image-widget', get_template_directory_uri().'/inc/js/image-widget.js', array( 'jquery', 'media-upload', 'media-views' ), self::VERSION );
        wp_localize_script( 'tribe-image-widget', 'TribeImageWidget', array(
            'frame_title' => esc_html__( 'Select an Image', 'jannah-lite' ),
            'button_title' => esc_html__( 'Insert Into Widget', 'jannah-lite' ),
        ) );
    }
    private static function get_defaults() {

        $defaults = array(
            'title' => '',
            'image' => 0,
            'imageurl' => '',
            'attachment_id' => 0,
            'ad_link'   => '',
            'ad_code'   => '',
            'new_window' => false,
            'nofollow'  => false,
        );
        return $defaults;
    }



    public function form($instance){
        $instance = wp_parse_args( (array) $instance, self::get_defaults() );
        $id_prefix = $this->get_field_id('');
        $title  = isset($instance['title'])? $instance['title']:'';
        $new_window = isset( $instance['new_window'] ) ? esc_attr( $instance['new_window'] ) : '';
        $nofollow   = isset( $instance['nofollow'] ) ?   esc_attr( $instance['nofollow'] )   : '';
        $ad_link = isset( $instance['ad_link'] ) ?   esc_attr( $instance['ad_link'] )   : '';
        $ad_code = isset( $instance['ad_code'] ) ?   esc_textarea( $instance['ad_code'] )   : '';
        ?>
        <p>
            <label for="title"><?php esc_html_e('Title:','jannah-lite'); ?></label>
            <input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>"  name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'ad_link' ) ); ?>"><?php _e( 'Ad URL', 'jannah-lite' ) ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'ad_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_link' ) ); ?>" value="<?php echo esc_attr($ad_link); ?>" class="widefat" placeholder="http://" type="url" />
        </p>
        <p class="uploader">
            <label for="<?php echo esc_attr( $this->get_field_id( 'uploader_button' ) ); ?>"><?php _e( 'Ad Image', 'jannah-lite' ) ?></label>
            <input type="submit" class="button widefat" name="<?php echo $this->get_field_name('uploader_button'); ?>" id="<?php echo $this->get_field_id('uploader_button'); ?>" value="<?php esc_attr_e('Select an Image', 'jannah-lite'); ?>" onclick="rianaWidget.uploader( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>' ); return false;" />
            <div class="tribe_preview" id="<?php echo $this->get_field_id('preview'); ?>">
                <?php echo $this->get_image_html($instance, false); ?>
            </div>
            <input type="hidden" id="<?php echo $this->get_field_id('attachment_id'); ?>" name="<?php echo $this->get_field_name('attachment_id'); ?>" value="<?php echo abs($instance['attachment_id']); ?>" />
            <input type="hidden" id="<?php echo $this->get_field_id('imageurl'); ?>" name="<?php echo $this->get_field_name('imageurl'); ?>" value="<?php echo $instance['imageurl']; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'ad_code' ) ); ?>"><strong><?php _e( '- OR -', 'jannah-lite') ?></strong> <?php esc_html_e( 'Ad Code:', 'jannah-lite' ) ?></label>
            <textarea id="<?php echo esc_attr( $this->get_field_id( 'ad_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_code' ) ); ?>" class="widefat" rows="5"><?php echo $ad_code; ?></textarea>
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'new_window' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'new_window' ) ); ?>" value="true" <?php checked( $new_window, 'true' ); ?> type="checkbox" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'new_window' ) ); ?>"><?php esc_html_e( 'Open links in a new window?', 'jannah-lite') ?></label>
        </p>

        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'nofollow' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'nofollow' ) ); ?>" value="true" <?php checked( $nofollow, 'true' ); ?> type="checkbox" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'nofollow' ) ); ?>"><?php esc_html_e( 'Nofollow?', 'jannah-lite') ?></label>
        </p>
        <?php
    }
    public function widget($args,$instance){

        //$widget='hello';
        $attachment_id = !empty($instance['attachment_id'])?$instance['attachment_id']:'';
        $imageurl = !empty($instance['imageurl'])?$instance['imageurl']:'';
        $title  = !empty($instance['title'])? $instance['title']:'';
        $new_window = ! empty( $instance['new_window'] ) ? ' target="_blank"' : '';
		$nofollow   = ! empty( $instance['nofollow'] )   ? ' rel="nofollow noopener"' : '';
        $ad_link = isset( $instance['ad_link'] ) ?   esc_attr( $instance['ad_link'] )   : '';
        $ad_code = isset( $instance['ad_code'] ) ?   $instance['ad_code']   : '';

        $image = '';
        if(!empty($attachment_id)){
            $url = wp_get_attachment_image_src( $attachment_id, 'img-fluid' );
            $image = $url[0];
        }elseif(!empty($imageurl)){
            $image = $imageurl;
        }
    
        echo $args['before_widget'];

        if(!empty($title)){
            echo $args['before_title'];
            echo $title;
            echo $args['after_title'];
        }
        echo '<div class="ad-wrapper">';
        if(!empty($ad_code)){
            echo $ad_code;
        } else {
            printf('<a class="jannah-ad-code" href="%s"%s%s><img class="img-fluid" src="%s" alt="%s"></a>', $ad_link, $nofollow, $new_window, esc_url($image), esc_attr('Advertisement', 'jannah-lite'));
        }
        echo '</div>';
        echo $args['after_widget'];
    }

    public function admin_head() {
            ?>
        <style type="text/css">
            .uploader input.button {
                width: 100%;
                height: 34px;
                line-height: 33px;
                margin-top: 15px;
            }
            .tribe_preview .aligncenter {
                display: block;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            .tribe_preview {
                overflow: hidden;
                max-height: 300px;
            }
            .tribe_preview img {
                margin: 10px 0;
                height: auto;
                max-width: 100%;
            }
        </style>
        <?php
    }
    private function get_image_html( $instance, $include_link = true ) {
        // Backwards compatible image display.
        if ( $instance['attachment_id'] == 0 && $instance['image'] > 0 ) {
            $instance['attachment_id'] = $instance['image'];
        }
        $output = '';
        if ( !empty( $instance['imageurl'] ) ) {
            // If all we have is an image src url we can still render an image.
            $src = $instance['imageurl'];
            $output = '<img src="'.esc_url($src).'" alt="'.esc_attr__('Image', 'jannah-lite').'" />';
        } elseif( abs( $instance['attachment_id'] ) > 0 ) {
            $output = wp_get_attachment_image($instance['attachment_id'],array(350,350));
        }
        return $output;
    }

    public function update( $new_instance, $old_instance ) {
        //$instance = $old_instance;
        $new_instance = wp_parse_args( (array) $new_instance, self::get_defaults() );
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['new_window'] = ! empty( $new_instance['new_window'] ) ? 'true' : false;
        $instance['nofollow']   = ! empty( $new_instance['nofollow'] )   ? 'true' : false;
        $instance['ad_link']  = $new_instance['ad_link'];
        $instance['ad_code'] = $new_instance['ad_code'];

        // Reverse compatibility with $image, now called $attachement_id
        if ( $new_instance['attachment_id'] > 0 ) {
            $instance['attachment_id'] = abs( $new_instance['attachment_id'] );
        } elseif ( $new_instance['image'] > 0 ) {
            $instance['attachment_id'] = $instance['image'] = abs( $new_instance['image'] );
        }
        $instance['imageurl'] = $new_instance['imageurl'];
        return $instance;
    }
}