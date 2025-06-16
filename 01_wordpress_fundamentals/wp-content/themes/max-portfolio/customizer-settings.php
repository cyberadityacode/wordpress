<?php
add_action( "customize_register", "max_portfolio_customize_register", 35 );
function max_portfolio_customize_register( $wp_customize ) {

 //=============================================================
 // Remove homepage options from theme customizer
 //=============================================================
 $wp_customize->remove_panel("cww_homepage_panel");


$defaults = max_portfolio_parent_defaults();


$wp_customize->get_setting( 'background_color' )->default = '#000';

//Header email input field
$wp_customize->add_setting('max_portfolio_email_input_field', 
		array(
	        'default'           => $defaults['max_portfolio_email_input_field'],
	        'sanitize_callback' => 'sanitize_text_field',
	        'transport'         => 'postMessage'
		)
	);

$wp_customize->add_control( 'max_portfolio_email_input_field', array(
	        'label'         	=> esc_html__( 'Input Email', 'max-portfolio' ),
	        'section'       	=> 'cww_header_section',
	        'active_callback' 	=> 'cww_portfolio_header_cta_cb',
	        'type'      		=> 'text',
	        'priority'		=> 100,
	        
	      ) );

}