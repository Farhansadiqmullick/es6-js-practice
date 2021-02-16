<?php 
/**
 * Jannah Twitter Widget
 *
 * @package    WordPress
 * @subpackage Jannah Lite
 * @since      Jannah Lite 1.0
 */

add_action('widgets_init', 'jannah_twitter_widget');
function jannah_twitter_widget() {
    register_widget('jannah_twitter_widget');
}

class jannah_twitter_widget extends WP_Widget{

    public function __construct(){
        parent::__construct('jannah_twitter_widget',esc_html__('Jannah Twitter','jannah-lite'),array(
            'description' => __('Latest clean tweet from twitter','jannah-lite'),
        ));
        
    }

    public function widget( $args, $instance ){
        extract( $args );
        $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        echo $before_widget;
        
        if ( ! empty($instance['title']) ){
            echo $before_title.$instance['title'].$after_title;
        }

        if( ! empty( $instance['username'] ) && ! empty( get_theme_mod('consumer_key') ) && ! empty( get_theme_mod('consumer_secret') ) ){
            
            $twitter_username = str_replace( '@', '', jannah_remove_spaces( $instance['username'] ) );
            $consumer_key     = get_theme_mod('consumer_key');
            $consumer_secret  = get_theme_mod('consumer_secret');
            $no_of_tweets     = ! empty( $instance['no_of_tweets'] ) ? $instance['no_of_tweets'] : 2;
            $widget_id        = $args['widget_id'];

            //Stored data
            $token        = get_option( 'jannah_twitter_token');
            $twitter_data = get_transient( 'jannah_list_tweets_'.$widget_id );

            if( empty( $twitter_data ) ) {
                if( empty( $token ) ){

                    //preparing credentials
                    $credentials  = $consumer_key . ':' . $consumer_secret;
                    $data_to_send = jannah_api_credentials( $credentials );

                    // http post arguments
                    $args = array(
                        'method'      => 'POST',
                        'httpversion' => '1.1',
                        'blocking'    => true,
                        'body'        => array( 'grant_type' => 'client_credentials' ),
                        'headers'     => array(
                                'Authorization' => 'Basic ' . $data_to_send,
                                'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8',
                        )
                    );

                    add_filter('https_ssl_verify', '__return_false');

                    $response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);
                    $keys     = json_decode(wp_remote_retrieve_body($response));
                    
                    if( ! empty( $keys ) ){
                        if(property_exists($keys, 'access_token')){
                            update_option( 'jannah_twitter_token', $keys->access_token );
                            $token = $keys->access_token;
                        } else {
                            jannah_notice_message( esc_html__('Problem with credential, Check on Customizer > Integration', 'jannah-lite') );
                            return;
                        }                        
                    }
                }

                //Add token to main query
                $args = array(
                    'httpversion' => '1.1',
                    'blocking'    => true,
                    'headers'     => array(
                        'Authorization' => "Bearer $token",
                ));

                add_filter('https_ssl_verify', '__return_false');

                $api_url = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=$twitter_username&count=$no_of_tweets";
                $api_url = jannah_remove_spaces( $api_url );
                
                $response = wp_remote_get( $api_url, $args );

                if ( is_wp_error( $response ) ) {
                    jannah_notice_message( $response->get_error_message() );
                }
                else{
                    $twitter_data = json_decode(wp_remote_retrieve_body($response));
                    set_transient( 'jannah_list_tweets_'.$widget_id, $twitter_data, HOUR_IN_SECONDS );
                }
            }

            if( is_array( $twitter_data ) && !empty( $twitter_data ) ){
                $i=0;
                ?>
                <ul class="twitter-items">
                    <?php 
                    foreach( $twitter_data as $item ){
                        $tweet     = $item->text;
                        $tweet     = $this->hyperlinks( $tweet );
                        $tweet     = $this->twitter_users( $tweet );
                        $permalink = 'http://twitter.com/'. $twitter_username .'/status/'. $item->id_str;

                        $time = strtotime( $item->created_at );
                        if ((abs( time() - $time) ) < 86400 ){
                            $h_time = sprintf( esc_html__( '%s ago', 'jannah-lite' ), human_time_diff( $time ) );
                        }
                        else{
                            $h_time = date( 'Y/m/d', $time);
                        }
                        ?>
                        <li class="tweet-item">
                            <div class="tweet-icon">
                                <i class="fab fa-twitter"></i>
                            </div>
                            <div class="tweet-body">
                                <p><?php echo ( $tweet ); ?></p>
                                <span class="tweet-meta"><a href="<?php echo esc_url( $permalink ) ?>" title="<?php echo date( 'Y/m/d H:i:s', $time ) ?>" target="_blank" rel="nofollow noopener"><?php echo ( $h_time ) ?></a></span>
                            </div>
                        </li>
                        <?php
                        $i++;
                        if ( $i >= $no_of_tweets ){
                            break;
                        }
                    }
                    ?>
                </ul>
                <?php 
            } else {
                jannah_notice_message(esc_html__('No post found. Maybe you put a wrong username', 'jannah-lite'));
            }
        
        } else {
            jannah_notice_message( esc_html__( 'You need to set username from widget setting and consumer key and consumer secret on Customizer > Integration', 'jannah-lite' ) );
        }

        echo $after_widget;
    }

    public function update( $new_instance, $old_instance ){
        $id        = explode("-", $this->get_field_id("widget_id"));
        $widget_id = $id[1] . "-" . $id[2];

        $instance          = $old_instance;
        $instance['title']           = sanitize_text_field( $new_instance['title'] );
        $instance['no_of_tweets']    = absint( $new_instance['no_of_tweets'] );
        $instance['username']        = $new_instance['username'];
        delete_option( 'jannah_twitter_token' );
		delete_transient( 'jannah_list_tweets_'.$widget_id );
        return $instance;
    }

    public function form( $instance ){
        $defaults = array( 'title' => esc_html__( 'Recent Tweet', 'jannah-lite' ) , 'no_of_tweets' => '2' );
        $instance = wp_parse_args( (array) $instance, $defaults );
        
        $title           = isset( $instance['title'] )           ? $instance['title'] : '';
        $username        = isset( $instance['username'] )        ? $instance['username'] : '';
        $no_of_tweets    = isset( $instance['no_of_tweets'] )    ? $instance['no_of_tweets'] : 2;
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'jannah-lite') ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Username', 'jannah-lite') ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" value="<?php echo esc_attr( $username ); ?>" class="widefat" type="text" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'no_of_tweets' ) ); ?>"><?php esc_html_e( 'Number of Tweets to show:', 'jannah-lite') ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'no_of_tweets' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'no_of_tweets' ) ); ?>" value="<?php echo esc_attr( $no_of_tweets ) ?>" type="number" step="1" min="1" size="3" class="tiny-text" />
        </p>
    <?php
    }

    private function hyperlinks($text){
        $text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" target=\"_blank\" rel=\"nofollow noopener\">$1</a>", $text);
        $text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" target=\"_blank\" rel=\"nofollow noopener\">$1</a>", $text);
        $text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" target=\"_blank\" rel=\"nofollow noopener\">$1</a>", $text);
        $text = preg_replace('/([\.|\,|\:|\?|\?|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" target=\"_blank\" rel=\"nofollow noopener\">#$2</a>$3 ", $text);
        return $text;
    }

    private function twitter_users($text){
        $text = preg_replace('/([\.|\,|\:|\?|\?|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" target=\"_blank\" rel=\"nofollow noopener\">@$2</a>$3 ", $text);
        return $text;
    }
}