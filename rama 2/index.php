<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rama
 */
 
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php 
	wp_head(); 
/*  (Put your reference here) !!!! 
slider source code: https://codepen.io/dudleystorey/pen/ehKpi
*/
?>
 
</head>
<body>
<!-- put description here about where the images are from and how there is a class which links to the css -->
<div id="photoslideshow">
<figure>
<img src="http://phoenix.sheridanc.on.ca/~ccit3669/wp-content/themes/images/rama1.jpg" alt="">
<img src="http://phoenix.sheridanc.on.ca/~ccit3669/wp-content/themes/images/rama2.jpg" alt="">
</figure>
</div>
</body>
<body <?php body_class();

//The code below defines the masthead of the site which is where users can place a banner and the site-navigation/main-navigation
where the top-menu bar is defined, made clickable to posts/pages and given ids so that it can be styled in css

 ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'rama' ); ?></a>
	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<?php
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
		</div><!-- .site-branding -->
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'rama' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
	<div id="content" class="site-content">
