<?php

namespace QuadLayers\QLWAPP;

class WooCommerce {

	protected static $instance;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
