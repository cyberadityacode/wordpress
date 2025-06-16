<?php
/**
 * Important functions for theme customizer
 * 
 */

/** Checkbox Sanitization Callback 
 * 
 * Sanitization callback for 'checkbox' type controls.
 * This callback sanitizes $input as a Boolean value, either
 * TRUE or FALSE.
 */
function cww_portfolio_sanitize_checkbox( $input ) {
	// Boolean check 
	return ( ( isset( $input ) && true == $input ) ? true : false );
}




function cww_portfolio_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function cww_portfolio_sanitize_integer($input){
	return intval( $input );
}

/**
 * Number sanitization callback
 *
 */
function cww_portfolio_sanitize_number( $val ) {
	return is_numeric( $val ) ? $val : 0;
}




function cww_portfolio_sanitize_sidebar( $input ) {
	$valid_keys = array(
		'sidebar-left' => array(
			'image'=> get_template_directory_uri().'/assets/img/sidebar-layouts/left-sidebar.png',
			'name'=> esc_html__('Left Sidebar', 'cww-portfolio')
		),
		'sidebar-right' => array(
			'image'=> get_template_directory_uri().'/assets/img/sidebar-layouts/right-sidebar.png',
			'name'=> esc_html__('Right Sidebar', 'cww-portfolio')
		),
		'sidebar-none' => array(
			'image'=> get_template_directory_uri().'/assets/img/sidebar-layouts/no-sidebar.png',
			'name'=> esc_html__('No Sidebar', 'cww-portfolio')
		),
		
	);

	if ( array_key_exists( $input, $valid_keys ) ) {
		return $input;
	} else {
		return '';
	}
}