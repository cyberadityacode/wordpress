<?php

namespace QuadLayers\QLWAPP\Services;

class Entity_Visibility {

	protected static $instance;

	public function is_show_view( $display ) {

		global $wp_query;

		$show = true;

		if ( is_customize_preview() ) {
			return true;
		}
		// Custom known WordPress entities.
		if ( is_front_page() || is_home() || is_search() || is_404() ) {

			if ( ( isset( $display['target']['ids'] ) ) ? count( $display['target']['ids'] ) : 0 ) {
				$show = ! (bool) $display['target']['include'];
				if ( is_front_page() && in_array( 'home', $display['target']['ids'] ) ) {
					$show = ! $show;
				} elseif ( is_home() && in_array( 'blog', $display['target']['ids'] ) ) {
					$show = ! $show;
				} elseif ( is_search() && in_array( 'search', $display['target']['ids'] ) ) {
					$show = ! $show;
				} elseif ( is_404() && in_array( 'error', $display['target']['ids'] ) ) {
					$show = ! $show;
				} elseif ( in_array( 'all', $display['target']['ids'] ) ) {
					$show = ! $show;
				}
			}

			return $show;
		}
		// WooCommerce fix for shop page.
		if ( function_exists( 'is_shop' ) && is_shop() ) {
			if ( isset( $display['entries']['page']['ids'] ) && count( $display['entries']['page']['ids'] ) ) {
				$show = ! $display['entries']['page']['include'];
				if ( in_array( 'all', $display['entries']['page']['ids'] ) ) {
					return ! $show;
				}
				if ( in_array( get_option( 'woocommerce_shop_page_id' ), $display['entries']['page']['ids'] ) ) {
					$show = ! $show;
				}
			}
			return $show;
		}

		return $show;
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
