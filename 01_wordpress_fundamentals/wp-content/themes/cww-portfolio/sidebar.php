<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CWW_Portfolio
 */

global $post;

$defaults 						= cww_portfolio_customizer_defaults();
$post_meta 						= empty(cww_portfolio_get_post_meta('cww_portfolio_sidebar_layout')) ? 'default' : cww_portfolio_get_post_meta('cww_portfolio_sidebar_layout');
$cww_portfolio_sidebar 				= cww_portfolio_get_post_meta('cww_portfolio_sidebar'); //meta sidebar area
$cww_portfolio_post_sidebar_area  	= get_theme_mod( 'cww_portfolio_post_sidebar_area', $defaults['cww_portfolio_post_sidebar_area'] );
$cww_portfolio_inner_single_sidebar = get_theme_mod( 'cww_portfolio_inner_single_sidebar', $defaults['cww_portfolio_inner_single_sidebar']);
$cww_portfolio_blog_sidebar_area 	= get_theme_mod( 'cww_portfolio_blog_sidebar_area', $defaults['cww_portfolio_blog_sidebar_area']);
$cww_portfolio_inner_blog_sidebar 	= get_theme_mod( 'cww_portfolio_inner_blog_sidebar', $defaults['cww_portfolio_inner_blog_sidebar']);
$post_sidebar 					= '';
$sidebar 						= '';

if( is_home() ){
	return;
}

if(!is_search() && is_single()){
	
	if( ($post_meta == 'default') && ($cww_portfolio_inner_single_sidebar == 'sidebar-left' || $cww_portfolio_inner_single_sidebar == 'sidebar-right') ) {

		$post_sidebar 	=  $cww_portfolio_inner_single_sidebar;
		$sidebar 		= $cww_portfolio_post_sidebar_area;

	}else if( $post_meta == 'sidebar-left' || 'sidebar-right' ){

		$post_sidebar 	=  $post_meta;
		$sidebar 		= $cww_portfolio_sidebar;
	}else{
		$post_sidebar 	=  $post_meta;
		$sidebar 		= '';
	}

	
}

if(!is_search() && is_page() && !is_front_page()){

	if( ($post_meta == 'default') && ($cww_portfolio_inner_single_sidebar == 'sidebar-left' || $cww_portfolio_inner_single_sidebar == 'sidebar-right') ) {

		$post_sidebar 	=  $cww_portfolio_inner_single_sidebar;
		$sidebar 		= $cww_portfolio_post_sidebar_area;

	}else if( $post_meta == 'sidebar-left' || 'sidebar-right' ){

		$post_sidebar 	=  $post_meta;
		$sidebar 		= $cww_portfolio_sidebar;
	}else{
		$post_sidebar 	=  $post_meta;
		$sidebar 		= '';
	}

}

if ( is_archive() || is_404() ) {
     $post_sidebar 	= $cww_portfolio_inner_blog_sidebar;
     $sidebar 		= $cww_portfolio_blog_sidebar_area;
}

if( is_search() ){
	$post_sidebar 	= $cww_portfolio_inner_blog_sidebar;
	$sidebar 		= $cww_portfolio_blog_sidebar_area;	
}



if( is_home() ){
	$post_sidebar 	= $cww_portfolio_inner_blog_sidebar;
	$sidebar 		= $cww_portfolio_blog_sidebar_area;
}


          

if ( ($post_sidebar ==  'sidebar-none')  ) {
	return;
}



if( ($post_sidebar == 'sidebar-left' || $post_sidebar == 'sidebar-right')  && is_active_sidebar($sidebar)){
	?>
		<aside class="widget-area secondary <?php echo esc_attr($post_sidebar);?>" role="complementary">
			<?php dynamic_sidebar( $sidebar ); ?>
		</aside><!-- #secondary -->
	<?php
}
