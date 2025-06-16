<?php
/**
 * CWW Portfolio functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CWW_Portfolio
 */

$cww_portfolio_themeObject 		= wp_get_theme();
$cww_portfolio_ver      		= $cww_portfolio_themeObject -> get( 'Version' );
define( 'CWW_PORTFOLIO_VER',$cww_portfolio_ver);



if ( ! function_exists( 'cww_portfolio_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function cww_portfolio_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on CWW Portfolio, use a find and replace
		 * to change 'cww-portfolio' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'cww-portfolio', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Responsive embedded content
		 *
		 * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
		 */
		add_theme_support( 'responsive-embeds' );


		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary Menu', 'cww-portfolio' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'cww_portfolio_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		add_theme_support ('align-wide');

	}
endif;
add_action( 'after_setup_theme', 'cww_portfolio_setup' );



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cww_portfolio_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cww_portfolio_content_width', 640 );
}
add_action( 'after_setup_theme', 'cww_portfolio_content_width', 0 );



/**
 * Register Google Fonts
 */
function cww_portfolio_fonts_url() {

	$fonts_url 		= '';
	$jost 			= esc_html_x( 'on', 'Jost font: on or off', 'cww-portfolio' );
	$poppins 		= esc_html_x( 'on', 'Poppins font: on or off', 'cww-portfolio' );
	$font_families 	= array();

	if ( 'off' !== $jost ) {
		$font_families[] = 'Jost:ital,wght@0,400;0,500;1,600&display=swap';
	}
	if ( 'off' !== $poppins ) {
		$font_families[] = 'Poppins:wght@0,400;0,500;1,600;2,700;3,800&display=swap';
	}

	if ( in_array( 'on', array( $jost, $poppins ) ) ) {
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cww_portfolio_widgets_init() {
	

	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'cww-portfolio' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'cww-portfolio' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title"><span class="title-bg">',
		'after_title'   => '</span></h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar', 'cww-portfolio' ),
		'id'            => 'xews_lite_left_sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'cww-portfolio' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title"><span class="title-bg">',
		'after_title'   => '</span></h4>',
	) );


}
add_action( 'widgets_init', 'cww_portfolio_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function cww_portfolio_scripts() {

	$default 								= cww_portfolio_customizer_defaults();
	$cww_portfolio_post_sidebar_sticky_enable 	= get_theme_mod('cww_portfolio_post_sidebar_sticky_enable', $default['cww_portfolio_post_sidebar_sticky_enable']);
	$cww_portfolio_blog_sidebar_sticky_enable 	= get_theme_mod('cww_portfolio_blog_sidebar_sticky_enable', $default['cww_portfolio_blog_sidebar_sticky_enable']);

	
    wp_enqueue_style( 'font-awesome', get_theme_file_uri('/assets/ext/font-awesome/css/font-awesome.min.css'), array(), CWW_PORTFOLIO_VER );
	wp_enqueue_style( 'cww-portfolio-fonts', cww_portfolio_fonts_url(), array(), null );
	wp_enqueue_style( 'cww-portfolio-style-vars', get_theme_file_uri('/assets/css/cww-vars.css'), array(), CWW_PORTFOLIO_VER );
	wp_register_style( 'cww-portfolio-blog-archive', get_theme_file_uri( '/assets/css/blog-archive.css' ), array(), CWW_PORTFOLIO_VER );
	wp_register_style( 'cww-portfolio-single-blog', get_theme_file_uri( '/assets/css/single-blog.css' ), array(), CWW_PORTFOLIO_VER );
	wp_register_style( 'cww-portfolio-404', get_theme_file_uri( '/assets/css/404.css' ), array(), CWW_PORTFOLIO_VER );
	wp_enqueue_style( 'cww-portfolio-keyboard', get_theme_file_uri( '/assets/css/keyboard.css' ), array(), CWW_PORTFOLIO_VER );


	wp_enqueue_style( 'cww-portfolio-style', get_stylesheet_uri(), array(), CWW_PORTFOLIO_VER );
	wp_style_add_data( 'cww-portfolio-style', 'rtl', 'replace' );
	wp_enqueue_style( 'cww-portfolio-responsive', get_theme_file_uri( '/assets/css/responsive.css' ), array(), CWW_PORTFOLIO_VER );

	wp_enqueue_script( 'cww-portfolio-navigation', get_theme_file_uri('/assets/js/navigation.js'), array(), CWW_PORTFOLIO_VER, true );
	wp_enqueue_script( 'jquery-nav', get_theme_file_uri('/assets/ext/onepagenav/jquery.nav.js'), array('jquery'), CWW_PORTFOLIO_VER, true );
	
	

	// sticky option
	if( $cww_portfolio_post_sidebar_sticky_enable == true || $cww_portfolio_blog_sidebar_sticky_enable == true ){
		wp_enqueue_script( 'theia-sticky-sidebar', get_template_directory_uri() . '/assets/js/theia-sticky-sidebar.js', array('jquery'), CWW_PORTFOLIO_VER, true );
	}

	//localizing customizer option
	wp_register_script( 'cww-portfolio-scripts', get_template_directory_uri() . '/assets/js/cww-portfolio.js', array('jquery'), CWW_PORTFOLIO_VER, true );
	$localize_options =  array(
      'stickySidebar'		=> esc_html($cww_portfolio_post_sidebar_sticky_enable),
			'stickySidebarBlog'	=> esc_html($cww_portfolio_blog_sidebar_sticky_enable),
        
        );

    wp_localize_script( 'cww-portfolio-scripts', 'cwwLocalizeScript', $localize_options  );
    wp_enqueue_script( 'cww-portfolio-scripts' );

}



	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
add_action( 'wp_enqueue_scripts', 'cww_portfolio_scripts' );

/**
* Admin scripts
*/
function cww_portfolio_admin_scripts(){

	wp_enqueue_script( 'cww-portfolio-admin', get_theme_file_uri('/assets/js/cww-admin.js'), array(), CWW_PORTFOLIO_VER, true );

}
add_action('admin_enqueue_scripts','cww_portfolio_admin_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer-sanitize.php';
require get_template_directory() . '/inc/customizer/customizer-defaults.php';
require get_template_directory() . '/inc/customizer/controllers/controller-main.php';


require get_template_directory() . '/inc/customizer/customizer.php';




require get_template_directory() . '/inc/hooks/header-hooks.php';
require get_template_directory() . '/inc/hooks/homepage-hooks.php';
require get_template_directory() . '/inc/hooks/footer-hooks.php';

require get_template_directory() . '/inc/dynamic-styling.php';


if ( is_admin() ) {
require get_template_directory() . '/inc/welcome/welcome-config.php';
}

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
