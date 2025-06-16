<?php
	
include get_template_directory() . '/inc/welcome/welcome.php';

/** Plugins **/
$plugins = array(
	// *** Companion Plugins
	'companion_plugins' => array(),

	// *** Required Plugins
	'required_plugins' => array(
		'cww-companion' => array(
			'slug' => 'cww-companion',
			'name' => 'Demo importer plugin',
			'filename' =>'cww-companion.php',
			'host_type' => 'wordpress', // Use either bundled, remote, wordpress
			'class' => 'CWW_Companion',
			'info' => 'Adds ability to theme with one click demo import feature, which will help to publish your websies within few minutes.',
		),
	
	),

	// *** Recommended Plugins
	'recommended_plugins' => array(
		// Free Plugins
		'free_plugins' => array(

			'cww-companion' => array(
				'slug' 		=> 'cww-companion',
				'filename' 	=> 'cww-companion.php',
				'class' 	=> 'CWW_Companion'
			),

			'contact-form-7' => array(
				'slug' 		=> 'contact-form-7',
				'filename' 	=> 'wp-contact-form-7.php',
				'class' 	=> 'WPCF7'
			),

			'cww-connector-lite' => array(
				'slug' 		=> 'cww-connector-lite',
				'filename' 	=> 'cww-connector-lite.php',
				'class' 	=> 'CWW_Connector_Lite'
			),

			'sticky-floating-forms-lite' => array(
				'slug' 		=> 'sticky-floating-forms-lite',
				'filename' 	=> 'sticky-floating-forms-lite.php',
				'class' 	=> 'Sticky_Floating_Forms_Lite'
			),
			
		),

		// Pro Plugins
		'pro_plugins' => array(
		)
	),
);
$theme = wp_get_theme();
$thname = $theme->Name; 
$strings = array(
	// Welcome Page General Texts
	'welcome_menu_text' 		=> $thname.' Info',
	'theme_short_description' 	=> 'This is a perfect theme to create perfect portfolio website, please follow all the actions displayed below to create your website with an ease.',

	// Plugin Action Texts
	'install_n_activate' 	=> 'Install and Activate',
	'deactivate' 			=> 'Deactivate',
	'activate' 				=> 'Activate',

	// Recommended Plugins Section
	'pro_plugin_title' 			=> 'Pro Plugins',
	'pro_plugin_description' 	=> 'Take Advantage of some of our Premium Plugins.',
	'free_plugin_title' 		=> 'Free Plugins',
	'free_plugin_description' 	=> 'These Free Plugins might be handy for you.',

	// Demo Actions
	'activate_btn' 		=> 'Activate',
	'installed_btn' 	=> 'Activated',
	'demo_installing' 	=> 'Installing Demo',
	'demo_installed' 	=> 'Demo Installed',
	'demo_confirm' 		=> 'Are you sure to import demo content ?',
	'doc_link'			=> 'https://codeworkweb.com/docs/cww-portfolio/',

	//free vs pro
	'free_vs_pro' => array(

        'features' => array(
        	'12+ Elementor Addons' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
        	'Typography' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
        	'Preloaders' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
            'Dark Mode' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
            'Remove Footer Copyright' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
            'Sticky Header'=> array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
            'Ecommerce Ready'=> array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
            'Drag & Drop Customizer Home Sections'=> array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
            'Beautiful Progress Bars'=> array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
            'Scroll To Top'=> array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
            'Responsive Layout' => array('Yes', 'Yes', 'dashicons-yes', 'dashicons-yes'),
            'Translations Ready' => array('Yes', 'Yes', 'dashicons-yes', 'dashicons-yes'),
            'SEO' => array('Optimized', 'Optimized'),
            'Support' => array('Yes', 'High Priority Dedicated Support')
        ),
    ),


);

/**
 * Initiating Welcome Page
*/
$my_theme_wc_page = new CWW_Welcome( $plugins, $strings );
