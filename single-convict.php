<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Shoreditch
 */

function no_sidebar_body_class($classes) {
	$classes[] = 'no-sidebar';
	return $classes;
}
add_filter('body_class', 'no_sidebar_body_class');


get_header();
?>

    <div class="site-content-wrapper">

        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', 'convict' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}

				endwhile; // End of the loop.
				?>

            </main><!-- #main -->
        </div><!-- #primary -->

		<?php //get_sidebar(); ?>

    </div><!-- .site-content-wrapper -->

<?php
get_sidebar( 'footer' );
get_footer();
