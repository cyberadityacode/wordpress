<?php

if ( class_exists( 'QuadLayers\\WP_Notice_Plugin_Promote\\Load' ) ) {
	add_action('init', function() {
		/**
		 *  Promote constants
		 */
		define( 'QLWAPP_PROMOTE_LOGO_SRC', plugins_url( '/assets/backend/img/logo.jpg', QLWAPP_PLUGIN_FILE ) );
		/**
		 * Notice review
		 */
		define( 'QLWAPP_PROMOTE_REVIEW_URL', 'https://wordpress.org/support/plugin/wp-whatsapp-chat/reviews/?filter=5#new-post' );
		/**
		 * Notice premium sell
		 */
		define( 'QLWAPP_PROMOTE_PREMIUM_SELL_SLUG', 'wp-whatsapp-chat-pro' );
		define( 'QLWAPP_PROMOTE_PREMIUM_SELL_NAME', 'Social Chat PRO' );
		define( 'QLWAPP_PROMOTE_PREMIUM_SELL_URL', QLWAPP_PREMIUM_SELL_URL );
		define( 'QLWAPP_PROMOTE_PREMIUM_INSTALL_URL', 'https://quadlayers.com/products/whatsapp-chat/?utm_source=qlwapp_admin' );
		/**
		 * Notice cross sell 1
		 */
		define( 'QLWAPP_PROMOTE_CROSS_INSTALL_1_SLUG', 'ai-copilot' );
		define( 'QLWAPP_PROMOTE_CROSS_INSTALL_1_NAME', 'AI Copilot' );
		define( 'QLWAPP_PROMOTE_CROSS_INSTALL_1_DESCRIPTION', esc_html__( 'Boost your productivity in WordPress content creation with AI-driven tools, automated content generation, and enhanced editor utilities.', 'wp-whatsapp-chat' ) );
		define( 'QLWAPP_PROMOTE_CROSS_INSTALL_1_URL', 'https://quadlayers.com/products/ai-copilot/?utm_source=qlwapp_admin' );
		define( 'QLWAPP_PROMOTE_CROSS_INSTALL_1_LOGO_SRC', plugins_url( '/assets/backend/img/ai-copilot.png', QLWAPP_PLUGIN_FILE ) );
		/**
		 * Notice cross sell 2
		 */
		define( 'QLWAPP_PROMOTE_CROSS_INSTALL_2_SLUG', 'insta-gallery' );
		define( 'QLWAPP_PROMOTE_CROSS_INSTALL_2_NAME', 'Instagram Feed Gallery' );
		define( 'QLWAPP_PROMOTE_CROSS_INSTALL_2_DESCRIPTION', esc_html__( 'Instagram Feed Gallery is a user-friendly WordPress plugin. It simplifies integration, speeds up site updates, and aligns with the rapidly evolving social media landscape.', 'wp-whatsapp-chat' ) );
		define( 'QLWAPP_PROMOTE_CROSS_INSTALL_2_URL', 'https://quadlayers.com/products/instagram-feed-gallery/?utm_source=qlwapp_admin' );
		define( 'QLWAPP_PROMOTE_CROSS_INSTALL_2_LOGO_SRC', plugins_url( '/assets/backend/img/insta-gallery.jpg', QLWAPP_PLUGIN_FILE ) );


		new \QuadLayers\WP_Notice_Plugin_Promote\Load(
			QLWAPP_PLUGIN_FILE,
			array(
				array(
					'type'               => 'ranking',
					'notice_delay'       => 0,
					'notice_logo'        => QLWAPP_PROMOTE_LOGO_SRC,
					'notice_description' => sprintf(
									esc_html__( 'Hello! %2$s We\'ve spent countless hours developing this free plugin for you and would really appreciate it if you could drop us a quick rating. Your feedback is extremely valuable to us. %3$s It helps us to get better. Thanks for using %1$s.', 'wp-whatsapp-chat' ),
									'<b>'.QLWAPP_PLUGIN_NAME.'</b>',
									'<span style="font-size: 16px;">🙂</span>',
									'<br>'
					),
					'notice_link'        => QLWAPP_PROMOTE_REVIEW_URL,
					'notice_more_link'   => QLWAPP_SUPPORT_URL,
					'notice_more_label'  => esc_html__(
						'Report a bug',
						'wp-whatsapp-chat'
					),
				),
				array(
					'plugin_slug'        => QLWAPP_PROMOTE_PREMIUM_SELL_SLUG,
					'plugin_install_link'   => QLWAPP_PROMOTE_PREMIUM_INSTALL_URL,
					'plugin_install_label'  => esc_html__(
						'Purchase Now',
						'wp-whatsapp-chat'
					),
					'notice_delay'       => WEEK_IN_SECONDS,
					'notice_logo'        => QLWAPP_PROMOTE_LOGO_SRC,
					'notice_title'       => esc_html__(
						'Hello! We have a special gift!',
						'wp-whatsapp-chat'
					),
					'notice_description' => sprintf(
						esc_html__(
							'Today we have a special gift for you. Use the coupon code %1$s within the next 48 hours to receive a %2$s discount on the premium version of the %3$s plugin.',
							'wp-whatsapp-chat'
						),
						'ADMINPANEL20%',
						'20%',
						QLWAPP_PROMOTE_PREMIUM_SELL_NAME
					),
					'notice_more_link'   => QLWAPP_PROMOTE_PREMIUM_SELL_URL,
				),
				array(
					'plugin_slug'        => QLWAPP_PROMOTE_CROSS_INSTALL_1_SLUG,
					'notice_delay'       => MONTH_IN_SECONDS * 3,
					'notice_logo'        => QLWAPP_PROMOTE_CROSS_INSTALL_1_LOGO_SRC,
					'notice_title'       => sprintf(
						esc_html__(
							'Hello! We want to invite you to try our %s plugin!',
							'wp-whatsapp-chat'
						),
						QLWAPP_PROMOTE_CROSS_INSTALL_1_NAME
					),
					'notice_description' => QLWAPP_PROMOTE_CROSS_INSTALL_1_DESCRIPTION,
					'notice_more_link'   => QLWAPP_PROMOTE_CROSS_INSTALL_1_URL
				),
				array(
					'plugin_slug'        => QLWAPP_PROMOTE_CROSS_INSTALL_2_SLUG,
					'notice_delay'       => MONTH_IN_SECONDS * 6,
					'notice_logo'        => QLWAPP_PROMOTE_CROSS_INSTALL_2_LOGO_SRC,
					'notice_title'       => sprintf(
						esc_html__(
							'Hello! We want to invite you to try our %s plugin!',
							'wp-whatsapp-chat'
						),
						QLWAPP_PROMOTE_CROSS_INSTALL_2_NAME
					),
					'notice_description' => QLWAPP_PROMOTE_CROSS_INSTALL_2_DESCRIPTION,
					'notice_more_link'   => QLWAPP_PROMOTE_CROSS_INSTALL_2_URL
				),
			)
		);
	});
}
