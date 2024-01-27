<?php
/*
Plugin Name: Met Reserve Auction
Description: Widget shows close bidders are to the reserve price.
Version: 1.0.0
Author: getyourclassic
Author URI: https://getyourclassic.com/
License: GPLv2
Text Domain: gyc-wmra
 */

if (!defined('ABSPATH')) {
    exit;
}


define('GYC_VERSION', '1.0.0');
define('GYC_FILE', __FILE__);
define('GYC_PATH', __DIR__);
define('GYC_URL', plugins_url('', GYC_FILE));
define('GYC_ASSETS', GYC_URL . '/assets');

require_once('inc/frontend/productpage.php');

register_activation_hook(__FILE__, 'gyc_activation');
function gyc_activation(){

}

add_action('plugins_loaded', 'gyc_init_plugin');
function gyc_init_plugin(){
	load_plugin_textdomain('gyc-wmra', false, dirname(plugin_basename(__FILE__)) . '/lang/');
}

add_action('init', 'gyc_run');
function gyc_run(){

}



add_action('admin_enqueue_scripts', 'gyc_admin_scripts');
function gyc_admin_scripts()
{
    wp_enqueue_style('gyc-admin-style', GYC_ASSETS . '/css/gyc_admin_style.css', array(), GYC_VERSION, 'all');
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_media();
    wp_enqueue_script('gyc-admin-script', GYC_ASSETS . '/js/gyc_admin_script.js', array('jquery', 'wp-color-picker' ), GYC_VERSION, true);

}

add_action('wp_enqueue_scripts', 'gyc_frontend_scripts');
function gyc_frontend_scripts()
{

	$en_options = get_option( 'gyc__settings' );
    $en_wd_style = isset($en_options['gauge_widget_style']) ? $en_options['gauge_widget_style'] : '1';

    // wp_enqueue_style('gyc-speedometer', GYC_ASSETS . '/css/speedometer.css', array(), GYC_VERSION, 'all');
    wp_enqueue_style('gyc-speedometer', GYC_ASSETS . '/css/gauge-'.$en_wd_style.'.css', array(), GYC_VERSION, 'all');
    wp_enqueue_style('gyc-style', GYC_ASSETS . '/css/gyc_style.css', array(), GYC_VERSION, 'all');

	
	if($en_wd_style == '3'){
		wp_enqueue_script('gyc-speedometer-support', GYC_ASSETS . '/js/jquery-gauge-support-3-1.11.2.js', array('jquery'), GYC_VERSION, true);
	}
	if($en_wd_style == '4'){
		wp_enqueue_script('gyc-speedometer-support', GYC_ASSETS . '/js/jquery-gauge-support-4-2.0.js', array('jquery'), GYC_VERSION, true);
		wp_enqueue_script('gyc-dx', GYC_ASSETS . '/js/dx-4.js', array('jquery'), GYC_VERSION, true);
	}
    

    // wp_enqueue_script('gyc-speedometer', GYC_ASSETS . '/js/speedometer.js', array('jquery'), GYC_VERSION, true);
    wp_enqueue_script('gyc-speedometer', GYC_ASSETS . '/js/gauge-'.$en_wd_style.'.js', array('jquery'), GYC_VERSION, true);

    wp_enqueue_script('gyc-script', GYC_ASSETS . '/js/gyc_script.js', array('jquery'), GYC_VERSION, true);

    wp_localize_script( 'gyc-script', 'gyc_ajax_object', array( 
        'ajax_url' => admin_url( 'admin-ajax.php' ), 
        
        ) );

}



add_action('admin_menu', 'gyc_admin_menu');
function gyc_admin_menu(){
    $parent_slug = 'woocommerce';
    $capability = 'manage_options';
    add_submenu_page($parent_slug, __('Met Reserve Price', 'gyc-wmra'), esc_html('Met Reserve Price', 'gyc-wmra'), $capability, 'met-reserve-price', 'plugin_seetings');
    
}

function plugin_seetings()
{
    require_once('inc/admin/adminpage.php');
}

/***  */
add_action( 'admin_init', 'gyc__settings_init' );
function gyc__settings_init(  ) { 

	register_setting( 'gyc_plugin_opt', 'gyc__settings' );

	add_settings_section(
		'gyc__gyc_plugin_opt_section', 
		__( 'Reserved price auction met display Settings', 'gyc-wmra' ), 
		'gyc__settings_section_callback', 
		'gyc_plugin_opt'
	);

	add_settings_field( 
		'show_on_product_page', 
		__( 'Show on single product page without inserting shortcode', 'gyc-wmra' ), 
		'show_on_product_page_render', 
		'gyc_plugin_opt', 
		'gyc__gyc_plugin_opt_section' 
	);

	add_settings_field( 
		'gauge_widget_text', 
		__( 'Title name', 'gyc-wmra' ), 
		'gauge_widget_text_render', 
		'gyc_plugin_opt', 
		'gyc__gyc_plugin_opt_section' 
	);
	add_settings_field( 
		'gauge_widget_style', 
		__( 'Gauge widget style', 'gyc-wmra' ), 
		'gauge_widget_style_render', 
		'gyc_plugin_opt', 
		'gyc__gyc_plugin_opt_section' 
	);

}


function show_on_product_page_render(  ) { 

	$options = get_option( 'gyc__settings' );
	?>
	<input type='checkbox' name='gyc__settings[show_on_product_page]' <?php echo isset($options['show_on_product_page']) ? 'checked' : ''; ?>>
	<?php

}


function gauge_widget_text_render(  ) { 

	$options = get_option( 'gyc__settings' );
	?>
	<input type='text' name='gyc__settings[gauge_widget_text]' value='<?php echo isset($options['gauge_widget_text']) ? $options['gauge_widget_text'] : ''; ?>'>
	<?php

}

function gauge_widget_style_render(  ) { 

	$options = get_option( 'gyc__settings' );
	$style = isset($options['gauge_widget_style']) ? $options['gauge_widget_style'] : '';
	// var_dump($options['gauge_widget_style']);
	?>
	<select name="gyc__settings[gauge_widget_style]" id="gauge_type">
		<option value="1" <?php echo $style == "1" ? 'selected' : '';?>>Style 1</option>
		<option value="4" <?php echo $style == "4" ? 'selected' : '';?>>Style 2</option>
	</select>
	<?php

}




function gyc__settings_section_callback(  ) { 

	echo __( 'Shortcode: <b>[gyc_price_gauge]</b>', 'gyc-wmra' );

}


