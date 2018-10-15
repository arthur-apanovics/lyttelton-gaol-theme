<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
//convict table
use lyttelton_gaol\fields\bio;

wp_enqueue_script( 'convict-table', get_stylesheet_directory_uri() . '/js/con_table.js', array('jquery'));

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php

			$bio_fields = new lyttelton_gaol\fields\bio();
			$con_fields = new lyttelton_gaol\fields\conviction();
			$gaz_fields = new lyttelton_gaol\fields\gazette();
			$all_fields = $bio_fields->getConstants() + $con_fields->getConstants() + $gaz_fields->getConstants();

            $all_meta = [];
            // Start the Loop.
			while ( have_posts() ) : the_post();

//				get_template_part( 'template-parts/content', 'convict-entry' );

                $entry = [];
                foreach (get_post_meta($post->ID) as $key => $value)
                {
                    $entry[$key] = $value[0];
                }
                $entry['convictions'] = unserialize($entry['convictions']);
                $entry['post_data'] = $post;

                $all_meta[] = $entry;

			// End the loop.
			endwhile;
        ?>

            <table id="table">
                <thead>
                <tr>
                    <?php
                        $ths = '';
                        $ths .= get_th(bio::NAME);
                        $ths .= get_th(bio::SURNAME);
                        $ths .= get_th(bio::COUNTRY_OF_BIRTH);
                        $ths .= get_th(bio::TRADE);
                        echo $ths;
                    ?>
                </tr>
                </thead>
            </table>

            <script>
                window.all_posts = <?php echo json_encode($all_meta) ?>;

                init_convict_table(window.all_posts);

                console.log('Right hea!');
            </script>

			<?php
			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'twentysixteen' ),
				'next_text'          => __( 'Next page', 'twentysixteen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php function get_th($field){
    return '<th data-sortable="true" data-field="' . $field['id'] . '">' . $field['desc'] . '</th>';
} ?>