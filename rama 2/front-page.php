<?php 
/* 
* 
* Template Name: custom home page
*  
*/
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					get_template_part( 'content');
				?>

			<?php endwhile; ?>
// this part is giving me error i am putting the error message here 
//Fatal error: Call to undefined function rc_posts_navigation() in /Applications/MAMP/htdocs/wordpress/wp-content/themes/rama 2/home.php on line 24
//i dont know how to correct it ..
			<?php rc_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'get_template_directory_uri()."/ front-page.php"' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

