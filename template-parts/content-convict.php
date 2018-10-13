<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

function start_container($title = null, $extra_class = null){
    $title_element = empty($title) ? '' : '<h4>' . $title . '</h4>';
	return '<div class="profile-container '. $extra_class .'">'. $title_element .'<ul class="list-group">';
}

function close_container(){
    return '</div></ul>';
}

function get_formatted_entry($key , $value, $extra_class = null){
	if (empty($key))
	    return null;

	if (is_array($value))
	    $value = $value[0];

	return '<li class="list-group-item ' . (!empty($value)?'':'text-muted ') . $extra_class .'"><div class="key">'. $key .'</div><div class="value">'. $value .'</div></li>';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
        <div class="col">
            <header class="entry-header">
				<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            </header><!-- .entry-header -->
        </div>
        <div class="col">
			<?php gaol_post_thumbnail(); ?>
        </div>
    </div>

	<div class="entry-content">
		<?php
		the_content();

		$meta_values = [];

		// GET A CLEAN ARRAY
		foreach (get_post_meta($id) as $key => $value){
		    $meta_values[$key] = $value[0];
        }
        ?>

        <div class="row">
            <div class="col">
				<?php
				// INFO
				$output = start_container('Biographical');
				$output .= get_formatted_entry('Name', $meta_values['bio_name']);
				$output .= get_formatted_entry('Surname', $meta_values['bio_surname']);
				$output .= get_formatted_entry('Christian Name', $meta_values['bio_christian_name']);
				$output .= get_formatted_entry('Middle Name', $meta_values['bio_middle_name']);
				$output .= get_formatted_entry('Alias', $meta_values['bio_alias']);
				$output .= get_formatted_entry('Born', $meta_values['bio_born']);
				$output .= get_formatted_entry('Country of Birth', $meta_values['bio_country_of_birth']);
				$output .= get_formatted_entry('Native of', $meta_values['bio_native_of']);
				$output .= get_formatted_entry('Occupation', $meta_values['bio_trade']);
				$output .= close_container();
				echo $output;
				?>
            </div>
            <div class="col">
				<?php
				// BIO
				$output = start_container('Physical');
				$output .= get_formatted_entry('Complexion', $meta_values['bio_complexion']);
				$output .= get_formatted_entry('Height', $meta_values['bio_height']);
				$output .= get_formatted_entry('Hair', $meta_values['bio_hair']);
				$output .= get_formatted_entry('Eyes', $meta_values['bio_eyes']);
				$output .= get_formatted_entry('Nose', $meta_values['bio_nose']);
				$output .= get_formatted_entry('Chin', $meta_values['bio_chin']);
				$output .= get_formatted_entry('Mouth', $meta_values['bio_mouth']);
				$output .= get_formatted_entry('Previous Convictions', $meta_values['bio_previous_convictions']);
				$output .= get_formatted_entry('Photographed', $meta_values['bio_photographed']);
				$output .= get_formatted_entry('Remarks', $meta_values['bio_remarks']);
				$output .= close_container();
				echo $output;
				?>
            </div>
        </div>
        <!--CONVICTIONS-->
        <div class="convictions">
            <h4>Convictions</h4>
			<?php
			// CONVICTIONS
			foreach (unserialize($meta_values['convictions']) as $conviction) {
				$output = start_container(null, 'conviction');
				$output .= get_formatted_entry('Offence', $conviction['offence'], 'list-group-item-danger');
				$output .= get_formatted_entry('Sentence', $conviction['sentence'], 'list-group-item-warning');
				$output .= get_formatted_entry('Date Tried', $conviction['date_tried']);
				$output .= get_formatted_entry('Discharged', $conviction['discharged']);
				$output .= get_formatted_entry('Source', $conviction['gazette_source']);
				$output .= get_formatted_entry('Publication Year', $conviction['gazette_publication_year']);
				$output .= get_formatted_entry('Volume', $conviction['gazette_volume']);
				$output .= get_formatted_entry('Page', $conviction['gazette_page']);
				$output .= close_container();
				echo $output;
			}
			?>
        </div>

        <?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

			if ( '' !== get_the_author_meta( 'description' ) ) {
				get_template_part( 'template-parts/biography' );
			}
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php twentysixteen_entry_meta(); ?>
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
