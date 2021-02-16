<?php
//add new custom control type switch
if(class_exists( 'WP_Customize_control')):
	class Jannah_Customize_Switch_Control extends WP_Customize_Control {
		public $type = 'switch';
		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<div class="switch_options">
					<span class="switch_enable"><?php esc_html_e('Yes','jannah-lite'); ?></span>
					<span class="switch_disable"><?php esc_html_e('No','jannah-lite'); ?></span>  
					<input type="hidden" id="switch_yes_no" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>" />
				</div>
			</label>
			<?php
		}
	}
	endif;

	//load js to control function of switch
	function jannah_inc_custom_admin_style($hook) {
		if ( 'customize.php' == $hook || 'widgets.php' == $hook ) {
			wp_enqueue_style( 'jannah-control-admin-css', get_template_directory_uri() . '/inc/css/customizer.css',array());
			wp_enqueue_script( 'jannah-control-admin-js', get_template_directory_uri() . '/inc/js/customizer.js', array( 'jquery' ), false, true );
		}else{
			return;
		}
	}
	add_action( 'admin_enqueue_scripts', 'jannah_inc_custom_admin_style' );