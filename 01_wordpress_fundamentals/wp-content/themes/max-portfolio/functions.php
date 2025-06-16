<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
if ( !function_exists( 'max_portfolio_locale_css' ) ):
    function max_portfolio_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'max_portfolio_locale_css' );


if ( !function_exists( 'max_portfolio_add_scripts' ) ):
    function max_portfolio_add_scripts() {
        wp_enqueue_style( 'max-portfolio-parent', trailingslashit( get_template_directory_uri() ) . 'style.css' ) ;
        
    }
endif;
add_action( 'wp_enqueue_scripts', 'max_portfolio_add_scripts', 10 );


/**
 * Implement the Custom Header feature.
 */
require get_stylesheet_directory() . '/customizer-settings.php';


add_action( 'init', 'max_portfolio_init');
function max_portfolio_init(){
     remove_action('cww_portfolio_logo','cww_portfolio_logo', 10 );

     add_action('cww_portfolio_logo','max_portfolio_logo', 10 );
}

/**
 * Override parent default setting values
 */

function max_portfolio_parent_defaults(){

    $defaults = array();
    $defaults['max_portfolio_email_input_field']        = esc_html__('info@example.com','max-portfolio');;
		
		return $defaults;

}

/*
* Header logo and email area
*/

add_action( 'max_portfolio_logo' , 'max_portfolio_logo', 10 );
if( ! function_exists('max_portfolio_logo')):
	function max_portfolio_logo(){
		?>
		<div class="max-left-header cww-flex">
			<div class="site-branding">
				<?php
				the_custom_logo();
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
				$cww_portfolio_description = get_bloginfo( 'description', 'display' );
				if ( $cww_portfolio_description || is_customize_preview() ) :
					?>
					<p class="site-description"><?php echo esc_html($cww_portfolio_description); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endif; ?>
			</div><!-- .site-branding -->

			<?php 
			$defaults = max_portfolio_parent_defaults();
			$max_portfolio_email_input_field 		= get_theme_mod('max_portfolio_email_input_field', $defaults['max_portfolio_email_input_field'] );
			?>
			<div class="site-email">
				<a href="<?php echo esc_attr('mailto:' . $max_portfolio_email_input_field);?>">
				<?php echo esc_attr($max_portfolio_email_input_field);?>
				</a>
			</div>
		</div>
		<?php 
	}
endif;
