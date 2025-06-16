<?php

namespace QuadLayers\QLWAPP\Controllers;

use QuadLayers\QLWAPP\WooCommerce as WooCommerce_Free;
use QuadLayers\QLWAPP\Models\WooCommerce as Models_WooCommerce;
use QuadLayers\QLWAPP\Models\Box as Models_Box;
use QuadLayers\QLWAPP\Models\Display as Models_Display;
use QuadLayers\QLWAPP\Models\Scheme as Models_Scheme;

class WooCommerce {

	protected static $instance;

	private function __construct() {
		remove_action( 'wp', array( WooCommerce_Free::instance(), 'woocommerce_init' ) );
		add_action( 'wp', array( $this, 'woocommerce_init' ) );
	}

	public function woocommerce_init() {
		if ( class_exists( 'WooCommerce' ) ) {
			$woocommerce       = Models_WooCommerce::instance()->get();
			$position          = (string) $woocommerce['position'];
			$position_priority = (int) $woocommerce['position_priority'];

			// Add Product Button.
			if ( is_product() && 'none' !== $position ) {
				add_action( $position, array( $this, 'product_button' ), $position_priority );
			}
		}
	}

	public function product_button( $product ) {

		$button  = Models_WooCommerce::instance()->get();
		$display = Models_Display::instance()->get();
		$box     = Models_Box::instance()->get();
		$scheme  = Models_Scheme::instance()->get();

		$style = Frontend::get_scheme_css_properties( $scheme );

		$display = htmlentities( wp_json_encode( $display ), ENT_QUOTES, 'UTF-8' );
		$button  = htmlentities( wp_json_encode( $button ), ENT_QUOTES, 'UTF-8' );
		$box     = htmlentities( wp_json_encode( $box ), ENT_QUOTES, 'UTF-8' );

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '<div class="qlwapp qlwapp--woocommerce" style="' . $style . '" data-display="' . $display . '" data-button="' . $button . '" data-box="' . $box . '"></div>';
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
