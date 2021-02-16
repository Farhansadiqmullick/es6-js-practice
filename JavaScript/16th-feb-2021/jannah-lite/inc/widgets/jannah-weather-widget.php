<?php 
/**
 * Jannah Weather Widget
 *
 * @package    WordPress
 * @subpackage Jannah Lite
 * @since      Jannah Lite 1.0
 */

add_action('widgets_init', 'jannah_weather_widget');
function jannah_weather_widget() {
    register_widget('jannah_weather_widget');
}

class jannah_weather_widget extends WP_Widget{

    public function __construct(){
        parent::__construct('jannah_weather_widget',esc_html__('Jannah Weather','jannah-lite'),array(
            'description' => __('Show weather on your site','jannah-lite'),
        ));
        
    }

    public function form($instance){
        $defaults = array( 'title' => esc_html__('Weather', 'jannah-lite') );
        $instance = wp_parse_args( (array) $instance, $defaults );

        $location      = isset( $instance['location'] )      ? esc_attr( $instance['location'])       : '';
        $custom_name   = isset( $instance['custom_name'] )   ? esc_attr( $instance['custom_name'])    : '';
        $title         = isset( $instance['title'] )         ? esc_attr( $instance['title'])          : '';
        $forecast_days = isset( $instance['forecast_days'] ) ? esc_attr( $instance['forecast_days'] ) : 5;
        $font_color    = isset( $instance['font_color'] )    ? esc_attr( $instance['font_color'])     : '';
        $bg_color      = isset( $instance['bg_color'] )      ? esc_attr( $instance['bg_color'])       : '';
        $units         = ( isset( $instance['units'] ) AND strtoupper( $instance['units']) == 'C' ) ? 'C' : 'F';

        $id = explode( '-', $this->get_field_id( 'widget_id' ));
        $colors_class = ( $id[4] == '__i__' ) ? 'ajax-added' : '';
          
        $theme_color = get_theme_mod( 'theme_color', '#0088ff' );

        if( ! get_theme_mod( 'api_openweather' ) ){
            echo '<p class="jannah-message-hint">'. esc_html__( 'You need to set the Weather API Key in Customize > Integrations.', 'jannah-lite' ) .'</p>';
        }
        ?>
        <p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title', 'jannah-lite'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

        <p>
			<label for="<?php echo esc_attr( $this->get_field_id('location') ); ?>">
				<strong><?php esc_html_e('Location', 'jannah-lite'); ?></strong> - <a href="<?php echo esc_url( 'http://openweathermap.org/find' ); ?>" target="_blank" rel="nofollow noopener"><?php esc_html_e('Find Your Location', 'jannah-lite'); ?></a><br />
				<small><?php esc_html_e( '(i.e: London,UK or New York City)', 'jannah-lite' ); ?></small>
			</label>
			<input class="widefat" style="margin-top: 4px;" id="<?php echo esc_attr( $this->get_field_id('location') ); ?>" name="<?php echo esc_attr( $this->get_field_name('location') ); ?>" type="text" value="<?php echo esc_attr( $location ); ?>" />
		</p>

        <p>
			<label for="<?php echo esc_attr( $this->get_field_id('custom_name') ); ?>">
				<?php esc_html_e('Custom City Name', 'jannah-lite'); ?><br />
			</label>
			<input class="widefat" style="margin-top: 4px;" id="<?php echo esc_attr( $this->get_field_id('custom_name') ); ?>" name="<?php echo esc_attr( $this->get_field_name('custom_name') ); ?>" type="text" value="<?php echo esc_attr( $custom_name ); ?>" />
		</p>

        <p>
			<label for="<?php echo esc_attr( $this->get_field_id('units') ); ?>"><?php esc_html_e('Units', 'jannah-lite'); ?></label>  &nbsp;
			<input id="<?php  echo esc_attr( $this->get_field_id('units') ); ?>-f" name="<?php echo esc_attr( $this->get_field_name('units') ); ?>" type="radio" value="F" <?php checked( $units, 'F' ); ?> /> <?php esc_html_e('F', 'jannah-lite'); ?> &nbsp; &nbsp;
			<input id="<?php  echo esc_attr( $this->get_field_id('units') ); ?>-c" name="<?php echo esc_attr( $this->get_field_name('units') ); ?>" type="radio" value="C" <?php checked( $units, 'C' ); ?> /> <?php esc_html_e('C', 'jannah-lite'); ?>
		</p>

        <p>
			<label for="<?php echo esc_attr( $this->get_field_id('forecast_days') ); ?>"><?php esc_html_e('Forecast', 'jannah-lite' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('forecast_days') ); ?>" name="<?php echo esc_attr( $this->get_field_name('forecast_days') ); ?>">
				<?php
					for ( $i=5; $i>0; $i-- ) {
						echo '<option value="'. $i .'"'. selected( $forecast_days, $i, false ) .'>'. sprintf( _n( '%d day', '%d days', $i, 'jannah-lite' ), $i ) .'</option>';
					}
				?>
				<option value="hide"<?php selected( $forecast_days, 'hide' ); ?>><?php esc_html_e('Disable', 'jannah-lite'); ?></option>
			</select>
		</p>

        <hr />
		<br />
		<strong><?php esc_html_e('Style', 'jannah-lite'); ?><br /></strong>

        <div class="weather-color jannah-custom-color-picker">
			<label for="<?php echo esc_attr( $this->get_field_id( 'bg_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Background Color', 'jannah-lite' ); ?></label>
			<input data-palette="<?php echo esc_attr( $theme_color ); ?>, #9b59b6, #3498db, #2ecc71, #f1c40f, #34495e, #e74c3c" class="widget-colorpicker" id="<?php echo esc_attr( $this->get_field_id( 'bg_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'bg_color' ) ); ?>" type="text" value="<?php echo esc_attr( $bg_color ) ?>" />
		</div>

		<div class="weather-color jannah-custom-color-picker">
			<label for="<?php echo esc_attr( $this->get_field_id( 'font_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Text Color', 'jannah-lite' ); ?></label>
			<input data-palette="<?php echo esc_attr( $theme_color ); ?>, #9b59b6, #3498db, #2ecc71, #f1c40f, #34495e, #e74c3c" class="widget-colorpicker" id="<?php echo esc_attr( $this->get_field_id( 'font_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'font_color' ) ); ?>" type="text" value="<?php echo esc_attr( $font_color ) ?>" />
		</div>
        <?php
    }

    public function widget($args,$instance){
        extract( $args );

        $title  = !empty($instance['title'])? $instance['title']:'';
        $location      = ! empty( $instance['location'] )      ? $instance['location']      : false;
        $custom_name   = ! empty( $instance['custom_name'] )   ? $instance['custom_name']   : false;
        $units         = ! empty( $instance['units'] )         ? $instance['units']         : false;
        $forecast_days = ! empty( $instance['forecast_days'] ) ? $instance['forecast_days'] : false;

        # Colors
        $bg_color   = ! empty( $instance['bg_color'] )   ? $instance['bg_color']   : '';
        $font_color = ! empty( $instance['font_color'] ) ? $instance['font_color'] : '';
    
        echo $args['before_widget'];

        if ( ! empty( $title ) ){
            echo ( $before_title . $title . $after_title );
        }
        
        $atts = array(
            'location'      => $location,
            'units'         => $units,
            'forecast_days' => $forecast_days,
            'custom_name'   => $custom_name,
        );

        new JANNAH_WEATHER( $atts );

        $widget_id = '#'. $args['widget_id'];

        if ( ! empty( $bg_color ) || ! empty( $font_color ) ){

            $out = "<style scoped type=\"text/css\">";

            if ( ! empty( $font_color ) ){
                $out .= "
                    $widget_id .weather-wrap,
                    $widget_id .weather-wrap .widget-title .the-subtitle{
                        color: $font_color;
                    }
                ";
            }

            if ( ! empty( $bg_color ) ){
                $out .= "
                    $widget_id .weather-wrap{
                        background-color: $bg_color;
                    }

                    $widget_id .weather-wrap .icon-basecloud-bg:after{
                        color: $bg_color;
                    }
                ";
            }

            echo ( $out ) ."</style>";
        }

        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['location']      = strip_tags($new_instance['location']);
        $instance['custom_name']   = strip_tags($new_instance['custom_name']);
        $instance['title']         = strip_tags($new_instance['title']);
        $instance['units']         = strip_tags($new_instance['units']);
        $instance['forecast_days'] = strip_tags($new_instance['forecast_days']);
        $instance['font_color']    = strip_tags($new_instance['font_color']);
        $instance['bg_color']      = strip_tags($new_instance['bg_color']);

        # Delete the Cached data
        if( ! empty( $instance['location'] ) ){
            JANNAH_WEATHER::clear_cache( $instance['location'] );
        }

        return $instance;
    }
}