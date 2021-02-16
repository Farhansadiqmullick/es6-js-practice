<?php

function jannah_customize_register( $jannah_customize ) {

	//Register panels
	$jannah_customize->add_panel( 'jannah_settings_panel', array(
        'priority'       => 30,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => esc_html__('Jannah Lite Settings', 'jannah-lite'),
        'description'    => esc_html__('Jannah Lite Settings', 'jannah-lite'),
	) );

	//Register sections
	$jannah_customize->add_section( 'jannah_top_bar' , array(
		'title'      => esc_html__( 'Top Bar', 'jannah-lite' ),
		'priority'   => 100,
        'panel'     => 'jannah_settings_panel'
	) );

	$jannah_customize->add_section( 'jannah_single_post' , array(
		'title'      => esc_html__( 'Single Post', 'jannah-lite' ),
		'priority'   => 100,
        'panel'     => 'jannah_settings_panel'
	) );

	$jannah_customize->add_section( 'jannah_widgets' , array(
		'title'      => esc_html__( 'Widget Area', 'jannah-lite' ),
		'priority'   => 100,
        'panel'     => 'jannah_settings_panel'
	) );

	$jannah_customize->add_section( 'jannah_text' , array(
		'title'      => esc_html__( 'Text Area', 'jannah-lite' ),
		'priority'   => 100,
        'panel'     => 'jannah_settings_panel'
	) );

	
	$jannah_customize->add_section( 'jannah_socials' , array(
		'title'      => esc_html__( 'Social Profiles', 'jannah-lite' ),
		'priority'   => 100,
        'panel'     => 'jannah_settings_panel'
	) );

	$jannah_customize->add_section( 'jannah_integrations' , array(
		'title'      => esc_html__( 'Integrations', 'jannah-lite' ),
		'priority'   => 100,
        'panel'     => 'jannah_settings_panel'
	) );

	$jannah_customize->add_section( 'jannah_copyright' , array(
		'title'      => esc_html__( 'Copyright Area', 'jannah-lite' ),
		'priority'   => 100,
        'panel'     => 'jannah_settings_panel'
	) );

    //Register settings
    $jannah_customize->add_setting( 'topbar_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'topbar_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Show Topbar','jannah-lite'),
				'section' => 'jannah_top_bar'
			)
		)
	);
	
	$jannah_customize->add_setting( 'topbar_date_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'topbar_date_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Show Date','jannah-lite'),
				'section' => 'jannah_top_bar'
			)
		)
	);
	
    
    $jannah_customize->add_setting( 'topbar_newsticker_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'topbar_newsticker_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Show News Ticker','jannah-lite'),
				'section' => 'jannah_top_bar'
			)
		)
	);

	$jannah_customize->add_setting( 'topbar_newsticker_tag' , array(
		'default' => 'any',
		'sanitize_callback' => 'jannah_sanitize_select'
	) );

	$jannah_customize->add_control(
		new WP_Customize_Control(
		   $jannah_customize,
		   'topbar_newsticker_tag',
		    array(
				'label'      => esc_html__( 'Ticker from tag', 'jannah-lite' ),
				'section'    => 'jannah_top_bar',
				'settings'   => 'topbar_newsticker_tag',
				'type'    => 'select',
				'choices' => jannah_tag_list('any')
		    )
		)
	);

	$jannah_customize->add_setting( 'topbar_newsticker_cat' , array(
		'default' => 'any',
		'sanitize_callback' => 'jannah_sanitize_select'
	) );

	$jannah_customize->add_control(
		new WP_Customize_Control(
		   $jannah_customize,
		   'topbar_newsticker_cat',
		    array(
				'label'      => esc_html__( 'Ticker from Category', 'jannah-lite' ),
				'section'    => 'jannah_top_bar',
				'settings'   => 'topbar_newsticker_cat',
				'type'    => 'select',
				'choices' => jannah_cat_list('any')
		    )
		)
	);
	$jannah_customize->add_setting( 'topbar_countdown_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'topbar_countdown_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Show Countdown','jannah-lite'),
				'section' => 'jannah_top_bar'
			)
		)
    );
    



	$jannah_customize->add_setting( 'topbar_social_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'topbar_social_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Show social share','jannah-lite'),
				'section' => 'jannah_top_bar'
			)
		)
	);

	$jannah_customize->add_setting( 'breadcrumb_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'breadcrumb_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Show Breadcrumb','jannah-lite'),
				'section' => 'jannah_single_post'
			)
		)
	);

	$jannah_customize->add_setting( 'post_cats_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'post_cats_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Show Category','jannah-lite'),
				'section' => 'jannah_single_post'
			)
		)
	);

	$jannah_customize->add_setting( 'postmeta_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'postmeta_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Show Post Meta','jannah-lite'),
				'section' => 'jannah_single_post'
			)
		)
	);

	$jannah_customize->add_setting( 'postthumbnail_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'postthumbnail_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Show Post Thumbnail','jannah-lite'),
				'section' => 'jannah_single_post'
			)
		)
	);

	$jannah_customize->add_setting( 'post_tags_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'post_tags_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Show Tags','jannah-lite'),
				'section' => 'jannah_single_post'
			)
		)
	);

	$jannah_customize->add_setting( 'post_share_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'post_share_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Social Share','jannah-lite'),
				'section' => 'jannah_single_post'
			)
		)
	);

	$jannah_customize->add_setting( 'post_authorbox_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'post_authorbox_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Show Author Box','jannah-lite'),
				'section' => 'jannah_single_post'
			)
		)
	);

	foreach(jannah_social_arr() as $key=>$value){
		$jannah_customize->add_setting( $key , array(
			'transport'   => 'refresh',
			'sanitize_callback' => 'wp_filter_nohtml_kses'
		) );
		$jannah_customize->add_control(
			new WP_Customize_Control(
				$jannah_customize,
				$key,
				array(
					'label'          => $value,
					'section'        => 'jannah_socials',
					'settings'       => $key,
					'type'           => 'text',
	
				)
			)
		);
	}

	$jannah_customize->add_setting( 'api_openweather' , array(
		'transport'   => 'refresh',
		'sanitize_callback' => 'wp_filter_nohtml_kses'
	) );

	$jannah_customize->add_control(
		new WP_Customize_Control(
			$jannah_customize,
			'api_openweather',
			array(
				'label'          => esc_html('OpenWeather API Key', 'jannah-lite'),
				'section'        => 'jannah_integrations',
				'settings'       => 'api_openweather',
				'type'           => 'text',
			)
		)
	);

	$jannah_customize->add_setting( 'consumer_key' , array(
		'transport'   => 'refresh',
		'sanitize_callback' => 'wp_filter_nohtml_kses'
	) );

	$jannah_customize->add_control(
		new WP_Customize_Control(
			$jannah_customize,
			'consumer_key',
			array(
				'label'          => esc_html('Twitter Consumer Key', 'jannah-lite'),
				'section'        => 'jannah_integrations',
				'settings'       => 'consumer_key',
				'type'           => 'text',
			)
		)
	);

	$jannah_customize->add_setting( 'consumer_secret' , array(
		'transport'   => 'refresh',
		'sanitize_callback' => 'wp_filter_nohtml_kses'
	) );

	$jannah_customize->add_control(
		new WP_Customize_Control(
			$jannah_customize,
			'consumer_secret',
			array(
				'label'          => esc_html('Twitter Consumer Secret', 'jannah-lite'),
				'section'        => 'jannah_integrations',
				'settings'       => 'consumer_secret',
				'type'           => 'text',
			)
		)
	);

	$jannah_customize->add_setting( 'footer_top_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'footer_top_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Show Top Widgets','jannah-lite'),
				'section' => 'jannah_widgets'
			)
		)
	);

	$jannah_customize->add_setting( 'footer_bottom_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'footer_bottom_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Show Bottom Widgets','jannah-lite'),
				'section' => 'jannah_widgets'
			)
		)
	);

	$jannah_customize->add_setting( 'copyright_text' , array(
		'default'     => '&copy; Copyright 2020, All Rights Reserved',
		'transport'   => 'refresh',
		'sanitize_callback' => 'wp_kses_post'
	) );

	$jannah_customize->add_control(
		new WP_Customize_Control(
			$jannah_customize,
			'copyright_text',
			array(
				'label'          => esc_html__( 'Copyright Text', 'jannah-lite' ),
				'section'        => 'jannah_copyright',
				'settings'       => 'copyright_text',
				'type'           => 'textarea',

			)
		)
	);

	$jannah_customize->add_setting( 'footer_social_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'footer_social_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Show Social Icons','jannah-lite'),
				'section' => 'jannah_copyright'
			)
		)
	);

	$jannah_customize->add_setting( 'footer_menu_switch' , array(
		'default' => '1',
		'sanitize_callback' => 'jannah_sanitize_integer'
	) );	
    
    $jannah_customize->add_control(
		new Jannah_Customize_Switch_Control(
			$jannah_customize,
			'footer_menu_switch',
			array(
				'type' => 'switch',
				'label' => esc_html__('Show Menu','jannah-lite'),
				'section' => 'jannah_copyright'
			)
		)
	);
}
add_action('customize_register', 'jannah_customize_register');
