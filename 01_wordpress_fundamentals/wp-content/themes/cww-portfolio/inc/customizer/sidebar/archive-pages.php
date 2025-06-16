<?php
$defaults 												= cww_portfolio_customizer_defaults();
$cww_portfolio_get_widget_areas 	= cww_portfolio_get_widget_areas();

/*Add New Panel for Sidebar Setups */
$wp_customize->add_panel( 'cww_portfolio_sidebar_panel', array (
	'priority' => '40',
	'capability' => 'edit_theme_options',
	'theme_supports' => '',
	'title' => __( 'Sidebar Settings', 'cww-portfolio' ),
	'description' => __( 'Setup sidebar options of the page.', 'cww-portfolio' )
) );

/* Blog / Archive Section */
$wp_customize->add_section( 'cww_portfolio_inner_blog_section', array(
	'title' => __('Blog / Archive Settings', 'cww-portfolio' ),
	'capability' => 'edit_theme_options',
	'panel' => 'cww_portfolio_sidebar_panel',
	'priority' => 20,
) );



$wp_customize->add_setting( 'cww_portfolio_inner_blog_sidebar', array( 
	'default' 			=> $defaults['cww_portfolio_inner_blog_sidebar'],
	'sanitize_callback' => 'sanitize_text_field' 
) );

$wp_customize->add_control( new Image_Radio_Buttons( $wp_customize, 'cww_portfolio_inner_blog_sidebar', array(
	'label'    => __( 'Blog / Archive Sidebar Style','cww-portfolio'),
	'section' => 'cww_portfolio_inner_blog_section',
	'type'    => 'select',
	'choices' => array(
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
	)
) ) );


$wp_customize->add_setting( 'cww_portfolio_blog_sidebar_area', array( 
    'default' 			=> $defaults['cww_portfolio_blog_sidebar_area'],
    'sanitize_callback' => 'sanitize_text_field' 
) );

$wp_customize->add_control( 'cww_portfolio_blog_sidebar_area', array(
    'label'         => esc_html__( 'Sidebar Area','cww-portfolio'),
	'description' 	=> esc_html__( 'Choose area for sidebar to display.','cww-portfolio'),
    'section'       => 'cww_portfolio_inner_blog_section',
    'type'          => 'select',
    'choices'       => $cww_portfolio_get_widget_areas
) );


$wp_customize->add_setting( 'cww_portfolio_blog_sidebar_sticky_enable', array( 
    'default' 			=> $defaults['cww_portfolio_blog_sidebar_sticky_enable'],
    'sanitize_callback' => 'sanitize_text_field' 
) );

$wp_customize->add_control( 'cww_portfolio_blog_sidebar_sticky_enable', array(
    'label'         => esc_html__( 'Sticky Sidebar','cww-portfolio'),
	'description' 	=> esc_html__( 'Make sidebar sticky as you scroll down?','cww-portfolio'),
    'section'       => 'cww_portfolio_inner_blog_section',
    'type'          => 'checkbox',
) );