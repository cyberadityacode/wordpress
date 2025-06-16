<?php

namespace QuadLayers\QLWAPP\Controllers;

use QuadLayers\QLWAPP\Models\Box as Models_Box;
use QuadLayers\QLWAPP\Models\Button as Models_Button;
use QuadLayers\QLWAPP\Models\Display as Models_Display;
use QuadLayers\QLWAPP\Models\Contacts as Models_Contacts;
use QuadLayers\QLWAPP\Models\Scheme as Models_Scheme;
use QuadLayers\QLWAPP\Services\Entity_Visibility;

class Frontend {

	protected static $instance;

	private function __construct() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'register_scripts' ) );
		add_action( 'wp', array( $this, 'display' ) );
		add_action(
			'qlwapp_load',
			function () {
				add_action( 'wp_enqueue_scripts', array( __CLASS__, 'add_assets' ) );
				add_action( 'wp_footer', array( __CLASS__, 'add_app' ) );
				add_shortcode( 'whatsapp', array( __CLASS__, 'do_shortcode' ) );
			},
			10
		);
	}

	public function display() {

		$is_elementor_library = isset( $_GET['post_type'] ) && $_GET['post_type'] === 'elementor_library' && isset( $_GET['render_mode'] ) && $_GET['render_mode'] === 'template-preview';

		if ( $is_elementor_library ) {
			return;
		}

		if ( is_admin() ) {
			return;
		}

		do_action( 'qlwapp_load' );
	}


	public static function register_scripts() {

		$frontend = include QLWAPP_PLUGIN_DIR . 'build/frontend/js/index.asset.php';

		wp_register_script(
			'qlwapp-frontend',
			plugins_url( '/build/frontend/js/index.js', QLWAPP_PLUGIN_FILE ),
			$frontend['dependencies'],
			$frontend['version'],
			true
		);

		wp_register_style(
			'qlwapp-frontend',
			plugins_url( '/build/frontend/css/style.css', QLWAPP_PLUGIN_FILE ),
			null,
			QLWAPP_PLUGIN_VERSION
		);
	}

	public static function add_assets() {
		wp_enqueue_script( 'qlwapp-frontend' );
		wp_enqueue_style( 'qlwapp-frontend' );
	}

	public static function add_app() {
		$button  = Models_Button::instance()->get();
		$display = Models_Display::instance()->get();
		$box     = Models_Box::instance()->get();
		$scheme  = Models_Scheme::instance()->get();

		$is_visible = Entity_Visibility::instance()->is_show_view( $display );

		if ( ! $is_visible ) {
			return;
		}

		// Filter the contacts based on the display settings.
		$contacts = array_values(
			array_filter(
				Models_Contacts::instance()->get_contacts_reorder(),
				function ( $contact ) {
					if ( ! isset( $contact['display'] ) ) {
						return true;
					}
					$is_visible = Entity_Visibility::instance()->is_show_view( $contact['display'] );
					return $is_visible;
				}
			)
		);

		$style  = self::get_scheme_css_properties( $scheme );
		$style .= self::get_button_css_properties( $button );

		$contacts_json = wp_json_encode( $contacts );
		$display_json  = wp_json_encode( $display );
		$button_json   = wp_json_encode( $button );
		$box_json      = wp_json_encode( $box );
		$scheme_json   = wp_json_encode( $scheme );

		?>
		<div 
			class="qlwapp"
			style="<?php echo esc_attr( $style ); ?>"
			data-contacts="<?php echo esc_attr( $contacts_json ); ?>"
			data-display="<?php echo esc_attr( $display_json ); ?>"
			data-button="<?php echo esc_attr( $button_json ); ?>"
			data-box="<?php echo esc_attr( $box_json ); ?>"
			data-scheme="<?php echo esc_attr( $scheme_json ); ?>"
		>
			<?php if ( ! empty( $box['footer'] ) ) : ?>
				<div class="qlwapp-footer">
					<?php echo wpautop( wp_kses_post( $box['footer'] ) ); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	public static function get_button_css_properties( $button ) {
		$style = '';
		foreach ( $button as $key => $value ) {
			if ( '' !== $value ) {
				if ( ! str_contains( $key, 'animation' ) ) {
					continue;
				}
				if ( str_contains( $key, 'animation_delay' ) ) {
					$value = "{$value}s";
				}
				$style .= sprintf( '--%s-button-%s:%s;', QLWAPP_DOMAIN, esc_attr( str_replace( '_', '-', $key ) ), esc_attr( $value ) );
			}
		}
		return $style;
	}

	public static function get_scheme_css_properties( $scheme ) {
		$style = '';
		foreach ( $scheme as $key => $value ) {
			if ( is_numeric( $value ) ) {
				$value = "{$value}px";
			}
			if ( '' !== $value ) {
				$style .= sprintf( '--%s-scheme-%s:%s;', QLWAPP_DOMAIN, esc_attr( str_replace( '_', '-', $key ) ), esc_attr( $value ) );
			}
		}
		return $style;
	}

	public static function do_shortcode( $atts, $content = null ) {
		$button             = Models_Button::instance()->get();
		$button['text']     = $content;
		$button['position'] = '';
		$button['box']      = 'no';
		$button             = htmlentities( wp_json_encode( wp_parse_args( $atts, $button ) ), ENT_QUOTES, 'UTF-8' );
		$scheme             = Models_Scheme::instance()->get();
		$style              = self::get_scheme_css_properties( $scheme );
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		return '<div style="' . $style . '" class="qlwapp qlwapp--shortcode" data-button="' . $button . '"></div>';
	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
