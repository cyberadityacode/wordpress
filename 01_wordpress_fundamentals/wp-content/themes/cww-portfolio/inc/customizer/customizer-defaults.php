<?php
/**
* Default settings for theme customizer
*
*
*/
if( ! function_exists('cww_portfolio_customizer_defaults')):
	function cww_portfolio_customizer_defaults(){

		$defaults = array();

		$defaults['cww_home_banner']                		= 0;
		$defaults['cww_header_cta_enable'] 					= 0;
		$defaults['cww_header_cta_text'] 					= 'Contact Now';
		$defaults['cww_header_cta_url'] 					= '#';
		$defaults['cww_header_cta_new_tab'] 				= 0;
		$defaults['cww_header_cta_bg'] 						= '#6138bd';
		$defaults['cww_header_bg'] 							= '#fff';
		$defaults['cww_menu_link_color'] 					= '#11204d';
		$defaults['cww_menu_link_color_hover'] 				= '';
		$defaults['cww_icon_fb']							= '';
		$defaults['cww_icon_insta'] 						= '';
		$defaults['cww_icon_twitter'] 						= '';
		$defaults['cww_icon_lnkedin'] 						= '';
		$defaults['cww_theme_color'] 						= '#ff3d4f';

		$defaults['cww_banner_image'] 						= '';
		$defaults['cww_banner_text_sm'] 					= "Hi There, I'm";
		$defaults['cww_banner_text_lg'] 					= 'John Doe';
		$defaults['cww_banner_text_sm2'] 					= 'based in Los Angeles, USA';
		$defaults['cww_banner_btn_text'] 					= 'View My Works';
		$defaults['cww_banner_btn_url'] 					= '#';
		$defaults['cww_banner_btn_text_sec'] 				= 'Contact Me';
		$defaults['cww_banner_btn_url_sec'] 				= '#';
		$defaults['cww_banner_bg'] 							= 'rgba(249, 86, 79, 0.13)';
		$defaults['cww_banner_animated_color'] 				= '#ff3d4f';

		$defaults['cww_about_title'] 						= 'About Me';
		$defaults['cww_about_sub_title'] 					= '';
		$defaults['cww_about_image'] 						= '';
		$defaults['cww_about_counter_value_first'] 			= 155;
		$defaults['cww_about_counter_text_first'] 			= 'Completed projects';
		$defaults['cww_about_counter_value_sec'] 			= 120;
		$defaults['cww_about_counter_text_sec'] 			= 'Positive reviews';


		$defaults['cww_service_title'] 						= 'What We Offer';
		$defaults['cww_service_sub_title'] 					= '';
		$defaults['cww_portfolio_title'] 					= 'Our Portfolio';
		$defaults['cww_portfolio_sub_title'] 				= '';
		$defaults['cww_portfolio_post'] 					= 0;

		$defaults['cww_service_enable'] 					= 1;
		$defaults['cww_portfolio_enable'] 					= 1;
		$defaults['cww_blog_enable'] 						= 1;
		$defaults['cww_contact_enable'] 					= 1;
		$defaults['cww_cta_enable'] 						= 1;
		$defaults['cww_about_enable'] 						= 1;

		$defaults['cww_portfolio_inner_single_sidebar']     	= 'sidebar-none';
    	$defaults['cww_portfolio_inner_blog_sidebar']        	= 'sidebar-none';
    	$defaults['cww_portfolio_post_sidebar_area']          	= 'sidebar-1';
    	$defaults['cww_portfolio_post_sidebar_sticky_enable'] 	= true;
    	$defaults['cww_portfolio_blog_sidebar_sticky_enable'] 	= true;
    
		$defaults['cww_portfolio_blog_sidebar_area'] 			= 'sidebar-1';
		

		return $defaults;
	}
endif;

$cww_portfolio_customizer_defaults = cww_portfolio_customizer_defaults();