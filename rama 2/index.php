 */

get_header(); ?>


// this code is being used to make a slider
// below is the code for an interactive slider. The code is referenced from cope.pen.io author:Mariam Massadeh
<div class="slider">
	<input type="radio" name="slide_switch" id="id1"/>
	<label for="id1">
		<img src="http://localhost:8888/wordpress/wp-content/uploads/2016/08/rama.jpg" width="100"/>
	</label>
	<img src="http://localhost:8888/wordpress/wp-content/uploads/2016/08/rama.jpg"/>
	
	<!--Lets show the second image by default on page load-->
	<input type="radio" name="slide_switch" id="id2" checked="checked"/>
	<label for="id2">
		<img src="http://localhost:8888/wordpress/wp-content/uploads/2016/08/rama2.jpg" width="100"/>
	</label>
	<img src="http://localhost:8888/wordpress/wp-content/uploads/2016/08/rama2.jpg"/>
</div>

<!-- We will use PrefixFree - a script that takes care of CSS3 vendor prefixes
You can download it from http://leaverou.github.com/prefixfree/ -->
<script src="http://thecodeplayer.com/uploads/js/prefixfree.js" type="text/javascript"></script>



	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();

