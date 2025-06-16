<?php

namespace QuadLayers\QLWAPP\Controllers;

class Components {

	protected static $instance;

	private function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );
	}

	public function register_scripts() {
		$components = include QLWAPP_PLUGIN_DIR . 'build/components/js/index.asset.php';

		/**
		 * Register components assets
		 */
		wp_register_script(
			'qlwapp-components',
			plugins_url( '/build/components/js/index.js', QLWAPP_PLUGIN_FILE ),
			$components['dependencies'],
			$components['version'],
			true
		);

		wp_register_style(
			'qlwapp-components',
			plugins_url( '/build/components/css/style.css', QLWAPP_PLUGIN_FILE ),
			array(
				'wp-components',
				'media-views',
			),
			QLWAPP_PLUGIN_VERSION
		);
	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
