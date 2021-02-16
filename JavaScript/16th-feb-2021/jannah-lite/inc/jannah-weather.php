<?php
/**
 * Weather Class
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( ! class_exists( 'JANNAH_WEATHER' ) ) {

	class JANNAH_WEATHER {

		public $atts;
		public $api_key;
		public $location;
		public $locale;
		public $city_slug;
		public $units;
		public $transient_name;
		public $today_high;
		public $today_low;
		public $units_display;
		public $days_to_show;

		/**
		 *
		 */
		function __construct( $atts ) {

			if( ! get_theme_mod( 'api_openweather' ) ){
				return jannah_notice_message( esc_html__( 'You need to set the Weather API Key in Customize > Integrations.', 'jannah-lite' ) );
			}

			if( empty( $atts['location'] ) ){
				return jannah_notice_message( esc_html__( 'You need to set the Location.', 'jannah-lite' ) );
			}

			$this->atts           = $atts;
			$this->api_key        = get_theme_mod( 'api_openweather' );
			$this->location       = $this->atts['location'];
			$this->locale         = $this->get_locale();
			$this->city_slug      = is_numeric( $this->location ) ? $this->location : sanitize_title( $this->location );
			$this->units          = ( isset( $atts['units'] ) AND strtoupper( $atts['units'] ) == 'C' ) ? 'metric' : 'imperial';
			$this->units_display  = $this->units == 'metric' ? '&#x2103;' : '&#x2109;';
			$this->transient_name = 'jannah_weather_' . $this->city_slug . '_' . strtolower( $this->units ) . '_' . $this->locale;
			$this->days_to_show   = isset( $this->atts['forecast_days'] ) ? $this->atts['forecast_days'] : 5;
			$this->avoid_cache    = isset( $this->atts['avoid_cache'] ) ? true : false;

			// Get the Weather
			$this->show();
		}


		/**
		 * Show the Weather
		 */
		private function show(){

			$weather_data = $this->get_weather();

			if( ! is_array( $weather_data ) ){
				return;
			}

			$output      = '';
			$today       = $weather_data['now'];
			$city_name   = !empty( $this->atts['custom_name'] ) ? $this->atts['custom_name'] : $today->name;
			$speed_text  = ( $this->units == 'metric')           ? esc_html__( 'km/h', 'jannah-lite' ) : esc_html__( 'mph', 'jannah-lite' );
			$weather_id  = ! empty( $today->weather[0]->id )     ? $today->weather[0]->id : 800;
			$description = $this->get_description( $weather_id );

			// Today's Icon
			$icon_slug = ! empty( $this->atts['debug'] ) ? $this->atts['debug'] : $today->weather[0]->icon;
			$the_icon  = $this->weather_icon( $icon_slug );

			// Today's weather data
			$today_temp       = isset( $today->main->temp )     ? round( $today->main->temp ) : false;
			$this->today_high = isset( $today->main->temp_max ) ? round( $today->main->temp_max ) : false;
			$this->today_low 	= isset( $today->main->temp_min ) ? round( $today->main->temp_min ) : false;

			// Get Forecast Data
			$forecast_out = $this->forecast( $weather_data );

			// Display the weather | NORMAL LAYOUT
			if( empty( $this->atts['compact'] ) ){ 
				?>

				<div id="jannah-weather-<?php echo $this->city_slug ?>" class="weather-wrap">

					<div class="weather-icon-and-city">
						<?php echo $the_icon; ?>
						<div class="weather-name the-subtitle"><?php echo $city_name; ?></div>
						<div class="weather-desc"><?php echo $description ?></div>
					</div>

					<div class="weather-todays-stats">

						<div class="weather-current-temp"><?php echo $today_temp ?><sup><?php echo $this->units_display; ?></sup></div>

						<div class="weather-more-todays-stats">

						<?php if( ! empty( $this->today_high ) && ! empty( $this->today_low ) ){ ?>
							<div class="weather_highlow">
                                <i class="fas fa-thermometer-half"></i> <?php echo $this->today_high; ?>&ordm; - <?php echo $this->today_low; ?>&ordm;
							</div>
						<?php } ?>

							<div class="weather_humidty">
                                <i class="fas fa-tint"></i>
								<span class="screen-reader-text"><?php esc_html__( 'humidity:', 'jannah-lite' ) ?></span> <?php echo $today->main->humidity; ?>%
							</div>

							<div class="weather_wind">
                                <i class="fas fa-wind"></i>
								<span class="screen-reader-text"><?php esc_html__( 'wind:', 'jannah-lite' ) ?></span> <?php echo $today->wind->speed .' '. $speed_text ?></div>
						</div>
					</div>

					<?php if( $this->days_to_show != 'hide' ){ ?>
						<div class="weather-forecast small-weather-icons weather_days_<?php echo $this->days_to_show ?>">
							<?php echo $forecast_out ?>
						</div>
					<?php } ?>

				</div>

				<?php
			}

			// Display the weather | Comapct LAYOUT
			else{ ?>

				<div class="jannah-weather-widget" title="<?php echo $description ?>">
					<div class="weather-wrap">

						<div class="weather-forecast-day small-weather-icons">
							<?php echo $the_icon; ?>
						</div>

						<div class="city-data">
							<span><?php echo $city_name; ?></span>
							<span class="weather-current-temp">
								<?php echo $today_temp ?>
								<sup><?php echo $this->units_display; ?></sup>
							</span>
						</div>

					</div>
				</div>
				<?php
			}

		}


		/**
		 * Get the Forecast Weather data
		 */
		private function forecast( $weather_data ){

			if( empty( $weather_data['forecast'] )|| empty( $weather_data['forecast']->list ) ) return;

			$forecast_days = array();
			$forecast_out  = '';
			$today_date    = date( 'Ymd', current_time( 'timestamp', 0 ) );

			// The Api Returns
			foreach( (array) $weather_data['forecast']->list as $forecast ){

				$day_of_week = date( 'Ymd', $forecast->dt );

				// Days after today only ----------
				if( $today_date > $day_of_week ) continue;

				// If it is today lets get the max and min
				if( $today_date == $day_of_week ){

					if( ! empty( $forecast->main->temp_max ) && $forecast->main->temp_max > $this->today_high ){
						$this->today_high = round( $forecast->main->temp_max );
					}

					if( ! empty( $forecast->main->temp_min ) && $forecast->main->temp_min < $this->today_low ){
						$this->today_low = round( $forecast->main->temp_min );
					}
				}

				// Rest Days
				if( empty( $forecast_days[ $day_of_week ] ) ){

					$forecast_days[ $day_of_week ] = array(
						'utc'  => $forecast->dt,
						'icon' => $forecast->weather[0]->icon,
						'temp' => ! empty( $forecast->main->temp_max ) ? round( $forecast->main->temp_max ) : '',
					);
				}
				else{

					// Get the max temp in the day
					if( $forecast->main->temp_max > $forecast_days[ $day_of_week ]['temp'] ){
						$forecast_days[ $day_of_week ]['temp'] = round( $forecast->main->temp_max );
						$forecast_days[ $day_of_week ]['icon'] = $forecast->weather[0]->icon;
					}
				}
			}

			// Show the Forecast data
			$days = 1;
			foreach( $forecast_days as $forecast_day ){

				$forecast_icon = $this->weather_icon( $forecast_day['icon'] );
				$the_day  = date_i18n( 'D', $forecast_day['utc'] );
				$day_temp = $forecast_day['temp'];

				$forecast_out .= "
					<div class=\"weather-forecast-day\">
						{$forecast_icon}
						<div class=\"weather-forecast-day-temp\">{$day_temp}<sup>{$this->units_display}</sup></div>
						<div class=\"weather-forecast-day-abbr\">{$the_day}</div>
					</div>
				";

				if( $days == $this->days_to_show ){
					break;
				}

				$days++;
			}

			return $forecast_out;
		}


		/**
		 * Get Locale
		 */
		private function get_locale(){

			$available_locales = array( 'en', 'ru', 'it', 'es', 'uk', 'de', 'pt', 'ro', 'pl', 'fi', 'nl', 'fr', 'bg', 'sv', 'zh_tw', 'zh_cn', 'tr', 'hr', 'ca', 'bn' );

			// Set the language
			$locale = in_array( get_locale(), $available_locales ) ? get_locale() : 'en';

			// Check for locale by first two digits
			if( in_array( substr( get_locale(), 0, 2 ), $available_locales ) ) {
				$locale = substr( get_locale(), 0, 2 );
			}

			return $locale;
		}


		/**
		 * Get Weather Description
		 */
		private function get_description( $id ){

			if( $id < 300 )
				return esc_html__( 'Thunderstorm', 'jannah-lite' );

			elseif( $id < 400 )
				return esc_html__( 'Drizzle', 'jannah-lite' );

			elseif( $id == 500 )
				return esc_html__( 'Light Rain', 'jannah-lite' );

			elseif( $id == 502 || $id == 503 || $id == 504 )
				return esc_html__( 'Heavy Rain', 'jannah-lite' );

			elseif( $id < 600 )
				return esc_html__( 'Rain', 'jannah-lite' );

			elseif( $id < 700 )
				return esc_html__( 'Snow', 'jannah-lite' );

			elseif( $id < 800 )
				return esc_html__( 'Mist', 'jannah-lite' );

			elseif( $id == 800 )
				return esc_html__( 'Clear Sky', 'jannah-lite' );

			elseif( $id > 800 )
				return esc_html__( 'Scattered Clouds', 'jannah-lite' );

		}


		/**
		 * Get the Weather data array
		 */
		private function get_weather(){

			if( ! $weather_data = get_transient( $this->transient_name ) ){

				$weather_data = array(
					'now'      => $this->remote_get('weather'),
					'forecast' => $this->remote_get('forecast'),
				);

				foreach ( $weather_data as $key => $value ){
					if( is_array( $value ) && ! empty( $value['error'] ) ){
						return jannah_notice_message( $value['error'] );
						break;
					}
				}

				if( $weather_data['now'] && $weather_data['forecast'] && ! $this->avoid_cache ){
					set_transient( $this->transient_name, $weather_data, 1 * HOUR_IN_SECONDS );
				}
			}

			return $weather_data;
		}


		/**
		 * API connection with the API
		 */
		private function remote_get( $type = 'weather' ){

			$query = is_numeric( $this->location ) ? array( 'id' => $this->location ) : array( 'q' => strtolower( $this->location ) );
			$query['lang']  = $this->locale;
			$query['units'] = $this->units;
			$query['appid'] = $this->api_key;

			$api_url = add_query_arg( $query, 'http://api.openweathermap.org/data/2.5/'.$type );

			$api_connect = wp_remote_get( $api_url, array( 'timeout' => 10 ) );

			// return if there is an error
			if( is_wp_error( $api_connect ) ){
				return array( 'error' => $api_connect->get_error_message() );
			}

			$the_data = json_decode( $api_connect['body'] );

			// return if there is an error
			if( isset( $the_data->cod ) && $the_data->cod != 200 ){
				return array( 'error' => $the_data->message );
			}

			return $the_data;
		}


		/**
		 * Get the Weather Icon
		 */
		function weather_icon( $icon ){

			// Sunny
			if( $icon == '01d' ){
				$weather_icon = '
					<div class="weather-icon">
                        <i class="fas fa-sun"></i>
					</div>
				';
			}
			// Moon
			elseif( $icon == '01n' ){
				$weather_icon = '
					<div class="weather-icon">
                        <i class="fas fa-moon"></i>
					</div>
				';
			}
			// Cloudy Sunny
			elseif( $icon == '02d' || $icon == '03d' || $icon == '04d' ){
				$weather_icon = '
					<div class="weather-icon">
                        <i class="fas fa-cloud-sun"></i>
					</div>
				';
			}
			// Cloudy Night
			elseif( $icon == '02n' || $icon == '03n'  || $icon == '04n' ){
				$weather_icon = '
					<div class="weather-icon">
                        <i class="fas fa-cloud-moon"></i>
					</div>
				';
			}
			// Showers
			elseif( $icon == '09d' ||  $icon == '09n'){
				$weather_icon = '
					<div class="weather-icon">
                        <i class="fas fa-cloud-showers-heavy"></i>
					</div>
				';
			}
			// Rainy Sunny
			elseif( $icon == '10d' ){
				$weather_icon = '
					<div class="weather-icon">
                        <i class="fas fa-cloud-sun-rain"></i>
					</div>
				';
			}
			// Rainy Night
			elseif( $icon == '10n' ){
				$weather_icon = '
					<div class="weather-icon">
                        <i class="fas fa-cloud-moon-rain"></i>
					</div>
				';
			}
			// Thunder
			elseif( $icon == '11d' || $icon == '11n'){
				$weather_icon = '
					<div class="weather-icon">
                        <i class="fas fa-thunderstorm"></i>
					</div>
				';
			}
			// Snowing
			elseif( $icon == '13d' || $icon == '13n' ){
				$weather_icon = '
					<div class="weather-icon">
                        <i class="fas fa-snowflake"></i>
					</div>
				';
			}
			// Mist
			elseif( $icon == '50d'  || $icon == '50n' ){
				$weather_icon = '
					<div class="weather-icon">
                        <i class="fas fa-fog"></i>
					</div>
				';
			}
			/// Default icon | Cloudy
			else{
				$weather_icon = '
					<div class="weather-icon">
                        <i class="fas fa-clouds"></i>
					</div>
				';
			}

			return apply_filters( 'Jannah/Weather/icon', $weather_icon, $icon );
		}


		/**
		 * Clear the Cached data for specfic City
		 */
		public static function clear_cache( $location = false ){

			if( ! $location ){
				return;
			}

			global $wpdb;
			$location = is_numeric( $location ) ? $location : sanitize_title( $location );
			$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s", '_transient_jannah_weather_'. $location .'%' ));
		}


		/**
		 * Update the Cached Weather data after saving the settings
		 */
		public static function clear_header_cache( $options ){

			$positions = array( 'top-nav', 'main-nav' );

			foreach ( $positions as $pos ){

				if( ! empty( $options[ $pos.'-components_weather' ] ) && ! empty( $options[ $pos.'-components_wz_location' ] ) && get_theme_mod( 'api_openweather' ) ){
					self::clear_cache( $options[ $pos.'-components_wz_location' ] );
				}
			}
		}


		/**
		 * Clear all expired weather cache
		 */
		public static function clear_expired_weather() {

			// Run this twice daily
			if( get_transient( 'jannah_check_weather_daily' ) ){
				return;
			}

			global $wpdb;

			// get current PHP time, offset by a minute to avoid clashes with other tasks
			$threshold = time() - MINUTE_IN_SECONDS;

			// delete expired transients, using the paired timeout record to find them
			$sql = "
				delete from t1, t2
				using {$wpdb->options} t1
				join {$wpdb->options} t2 on t2.option_name = replace(t1.option_name, '_timeout', '')
				where (t1.option_name like '\_transient\_timeout\_jannah_weather_%' or t1.option_name like '\_site\_transient\_timeout\_jannah_weather_%')
				and t1.option_value < '$threshold'
			";
			$wpdb->query($sql);

			// delete orphaned transient expirations
			$sql = "
				delete from {$wpdb->options}
				where (
						 option_name like '\_transient\_timeout\_jannah_weather_%'
					or option_name like '\_site\_transient\_timeout\_jannah_weather_%'
				)
				and option_value < '$threshold'
			";
			$wpdb->query($sql);

			// Run this twice daily
			set_transient( 'jannah_check_weather_daily', true, 12 * HOUR_IN_SECONDS );
		}

	}
}


add_action( 'admin_head', 'JANNAH_WEATHER::clear_expired_weather' );
add_action( 'Jannah/Options/before_update', 'JANNAH_WEATHER::clear_header_cache' );
