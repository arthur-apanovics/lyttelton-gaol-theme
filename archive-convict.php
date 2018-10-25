<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shoreditch
 */

use lyttelton_gaol\fields\bio;

wp_enqueue_script( 'convict-table', get_stylesheet_directory_uri() . '/js/con_table.js', array('jquery'));

get_header();

$search_by = get_query_var('search_by');
?>

<div class="site-content-wrapper">

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) : ?>

                <header class="archive-header">
                    <h1 class="page-title">
                        <?php echo !empty($search_by) ? 'Search Results' : 'All convicts'; ?>
                    </h1>
                    <div class="taxonomy-description">
                        Use the toolbar to further refine your search.
                        <br>
                        Expand row to see convictions.
                    </div>
                </header><!-- .page-header -->

			<?php
			$bio_fields = new lyttelton_gaol\fields\bio();
			$con_fields = new lyttelton_gaol\fields\conviction();
			$gaz_fields = new lyttelton_gaol\fields\gazette();
			$all_fields = $bio_fields->getConstants() + $con_fields->getConstants() + $gaz_fields->getConstants();

            $all_meta = [];

            // Start the Loop.
			while ( have_posts() ) : the_post();
                $entry = [];

                foreach (get_post_meta($post->ID) as $key => $value)
                    $entry[$key] = $value[0];

				$entry['convictions'] = unserialize($entry['convictions']);
				$entry['total_convictions'] = count($entry['convictions']);
                $entry['post_data'] = $post;

                $all_meta[] = $entry;

			// End the loop.
			endwhile;

			the_posts_navigation();
			?>

            <table id="table">
                <thead>
                <tr>
                    <?php
                    $ths = '';
                    $ths .= '<th data-formatter="full_name_formatter">Name</th>';
                    $ths .= get_th(bio::NAME, 'data-visible="false"');
                    $ths .= get_th(bio::SURNAME, 'data-visible="false"');
                    $ths .= get_th(bio::CHRISTIAN_NAME, 'data-visible="false"');
                    $ths .= get_th(bio::MIDDLE_NAME, 'data-visible="false"');
                    $ths .= get_th(bio::ALIAS, 'data-visible="false"');
                    $ths .= get_th(bio::BORN, 'data-visible="false"');
                    $ths .= get_th(bio::COUNTRY_OF_BIRTH);
                    $ths .= get_th(bio::NATIVE_OF, 'data-visible="false"');
                    $ths .= get_th(bio::TRADE);
                    $ths .= get_th(bio::REMARKS, 'data-visible="false"');
                    $ths .= '<th data-sortable="true" data-width="80px" data-align="right" data-field="total_convictions">Total</th>';
                    echo $ths;
                    ?>
                </tr>
                </thead>
            </table>

            <script>
                init_convict_table(<?php echo json_encode($all_meta) ?>);
            </script>

			<?php
		// If no content, include the "No posts found" template.
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php get_sidebar(); ?>

    </div><!-- .site-content-wrapper -->

<?php
get_sidebar( 'footer' );
get_footer();
?>

<?php function get_th($field, $attributes = null){
    return '<th data-sortable="true" data-field="' . $field['id'] . '" ' . $attributes . '>' . $field['desc'] . '</th>';
} ?>
