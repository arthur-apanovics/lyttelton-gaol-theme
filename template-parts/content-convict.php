<?php
use lyttelton_gaol\fields;

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
				$output .= get_formatted_entry('Name',             $meta_values[fields\bio::NAME['id']]);
				$output .= get_formatted_entry('Surname',          $meta_values[fields\bio::SURNAME['id']]);
				$output .= get_formatted_entry('Christian Name',   $meta_values[fields\bio::CHRISTIAN_NAME['id']]);
				$output .= get_formatted_entry('Middle Name',      $meta_values[fields\bio::MIDDLE_NAME['id']]);
				$output .= get_formatted_entry('Alias',            $meta_values[fields\bio::ALIAS['id']]);
				$output .= get_formatted_entry('Born',             $meta_values[fields\bio::BORN['id']]);
				$output .= get_formatted_entry('Country of Birth', $meta_values[fields\bio::COUNTRY_OF_BIRTH['id']]);
				$output .= get_formatted_entry('Native of',        $meta_values[fields\bio::NATIVE_OF['id']]);
				$output .= get_formatted_entry('Occupation',       $meta_values[fields\bio::TRADE['id']]);
				$output .= close_container();
				echo $output;
				?>
            </div>
            <div class="col">
				<?php
				// BIO
				$output = start_container('Physical');
				$output .= get_formatted_entry('Complexion',           $meta_values[fields\bio::COMPLEXION['id']]);
				$output .= get_formatted_entry('Height',               $meta_values[fields\bio::HEIGHT['id']]);
				$output .= get_formatted_entry('Hair',                 $meta_values[fields\bio::HAIR['id']]);
				$output .= get_formatted_entry('Eyes',                 $meta_values[fields\bio::EYES['id']]);
				$output .= get_formatted_entry('Nose',                 $meta_values[fields\bio::NOSE['id']]);
				$output .= get_formatted_entry('Chin',                 $meta_values[fields\bio::CHIN['id']]);
				$output .= get_formatted_entry('Mouth',                $meta_values[fields\bio::MOUTH['id']]);
				$output .= get_formatted_entry('Previous Convictions', $meta_values[fields\bio::PREVIOUS_CONVICTIONS['id']]);
				$output .= get_formatted_entry('Photographed',         $meta_values[fields\bio::PHOTOGRAPHED['id']]);
				$output .= get_formatted_entry('Remarks',              $meta_values[fields\bio::REMARKS['id']]);
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
				$output .= get_formatted_entry('Offence',          $conviction[fields\conviction::OFFENCE['id']], 'list-group-item-danger');
				$output .= get_formatted_entry('Sentence',         $conviction[fields\conviction::SENTENCE['id']], 'list-group-item-warning');
				$output .= get_formatted_entry('Date Tried',       $conviction[fields\conviction::DATE_TRIED['id']]);
				$output .= get_formatted_entry('Discharged',       $conviction[fields\conviction::DISCHARGED['id']]);

				$output .= get_formatted_entry('Source',           $conviction[fields\gazette::SOURCE['id']]);
				$output .= get_formatted_entry('Publication Year', $conviction[fields\gazette::PUBLICATION_YEAR['id']]);
				$output .= get_formatted_entry('Volume',           $conviction[fields\gazette::VOLUME['id']]);
				$output .= get_formatted_entry('Page',             $conviction[fields\gazette::PAGE['id']]);
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
