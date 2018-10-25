<?php
use lyttelton_gaol\fields\bio, lyttelton_gaol\fields\gazette, lyttelton_gaol\fields\conviction;

/**
 * The template part for displaying single posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shoreditch
 */

function start_container($title = null, $extra_class = null){
    $title_element = empty($title) ? '' : '<h4>' . $title . '</h4>';
	return '<div class="profile-container '. $extra_class .'">'. $title_element .'<ul class="list-group">';
}

function close_container(){
    return '</div></ul>';
}

function get_formatted_entry($list_key , $list_value, $extra_class = null){
	if (empty($list_key))
	    return null;

	if (is_array($list_value))
	    $list_value = $list_value[0];

	return '<li class="list-group-item ' . (!empty($list_value) ? '' : 'text-muted ') . $extra_class . '">
                <div class="key">
                    ' . $list_key . '
                </div>
                <div class="value">
                    ' . $list_value . '
                </div>
            </li>';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="hentry-wrapper">

    <div class="row">
        <div class="col-9">
            <header class="entry-header">
				<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            </header><!-- .entry-header -->
        </div>
        <div class="col-3">
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
				$output .= get_formatted_entry(bio::NAME['desc'],             $meta_values[bio::NAME['id']]);
				$output .= get_formatted_entry(bio::SURNAME['desc'],          $meta_values[bio::SURNAME['id']]);
				$output .= get_formatted_entry(bio::CHRISTIAN_NAME['desc'],   $meta_values[bio::CHRISTIAN_NAME['id']]);
				$output .= get_formatted_entry(bio::MIDDLE_NAME['desc'],      $meta_values[bio::MIDDLE_NAME['id']]);
				$output .= get_formatted_entry(bio::ALIAS['desc'],            $meta_values[bio::ALIAS['id']]);
				$output .= get_formatted_entry(bio::BORN['desc'],             $meta_values[bio::BORN['id']]);
//				$output .= get_formatted_entry(bio::COUNTRY_OF_BIRTH['desc'], $meta_values[bio::COUNTRY_OF_BIRTH['id']]);
//				$output .= get_formatted_entry(bio::NATIVE_OF['desc'],        $meta_values[bio::NATIVE_OF['id']]);

				$where_from = $meta_values[bio::NATIVE_OF['id']] . ', ' . $meta_values[bio::COUNTRY_OF_BIRTH['id']];
				$output .= get_formatted_entry('Where Born',          $where_from);

				$output .= get_formatted_entry(bio::TRADE['desc'],            $meta_values[bio::TRADE['id']]);
				$output .= close_container();
				echo $output;
				?>
            </div>
            <div class="col">
				<?php
				// BIO
				$output = start_container('<span style="border-bottom: 2px #dfdfdf dashed;;" data-toggle="tooltip" data-placement="right" title="At time of first conviction">Physical</span>');
				$output .= get_formatted_entry(bio::COMPLEXION['desc'],           $meta_values[bio::COMPLEXION['id']]);
				$output .= get_formatted_entry(bio::HEIGHT['desc'],               $meta_values[bio::HEIGHT['id']]);
				$output .= get_formatted_entry(bio::HAIR['desc'],                 $meta_values[bio::HAIR['id']]);
				$output .= get_formatted_entry(bio::EYES['desc'],                 $meta_values[bio::EYES['id']]);
				$output .= get_formatted_entry(bio::NOSE['desc'],                 $meta_values[bio::NOSE['id']]);
				$output .= get_formatted_entry(bio::CHIN['desc'],                 $meta_values[bio::CHIN['id']]);
				$output .= get_formatted_entry(bio::MOUTH['desc'],                $meta_values[bio::MOUTH['id']]);
//				$output .= get_formatted_entry(bio::PREVIOUS_CONVICTIONS['desc'], $meta_values[bio::PREVIOUS_CONVICTIONS['id']]);
				$output .= get_formatted_entry(bio::PHOTOGRAPHED['desc'],         $meta_values[bio::PHOTOGRAPHED['id']]);
				$output .= close_container();
				echo $output;
				?>
            </div>
        </div>
        <div class="remarks">
			<?php
			$output = start_container();
			$output .= get_formatted_entry(bio::REMARKS['desc'], $meta_values[bio::REMARKS['id']]);
			$output .= close_container();
			echo $output;
			?>
        </div>
        <!--CONVICTIONS-->
        <div class="convictions">
            <h4>Convictions</h4>
			<?php
			// CONVICTIONS
            $iteration = 1;
			foreach (unserialize($meta_values['convictions']) as $conviction) {
				$output = start_container(null, 'conviction');
				$output .= get_formatted_entry(conviction::OFFENCE['desc'], $conviction[conviction::OFFENCE['id']], 'list-group-item-danger');
				$output .= get_formatted_entry(conviction::SENTENCE['desc'], $conviction[conviction::SENTENCE['id']], 'list-group-item-warning');
				$output .= get_formatted_entry(conviction::DATE_TRIED['desc'], $conviction[conviction::DATE_TRIED['id']]);
				$output .= get_formatted_entry(conviction::WHERE_TRIED['desc'], $conviction[conviction::WHERE_TRIED['id']]);
				$output .= get_formatted_entry(conviction::DISCHARGED['desc'], $conviction[conviction::DISCHARGED['id']]);

				$gazette_button = '<a href="#conviction_' . $iteration . '" data-toggle="collapse" role="button" aria-expanded="false">Expand</a>';
				$output  .= get_formatted_entry('Gazette Details', $gazette_button);
				$output  .= close_container();

				$gazette = '<div class="collapse gazette-container" id="conviction_'.$iteration.'">
                                <div class="card card-body">';
				$gazette .= start_container(null, 'conviction-gazette');
				$gazette .= get_formatted_entry(gazette::SOURCE['desc'], $conviction[gazette::SOURCE['id']]);
				$gazette .= get_formatted_entry(gazette::PUBLICATION_YEAR['desc'], $conviction[gazette::PUBLICATION_YEAR['id']]);
				$gazette .= get_formatted_entry(gazette::VOLUME['desc'], $conviction[gazette::VOLUME['id']]);
				$gazette .= get_formatted_entry(gazette::PAGE['desc'], $conviction[gazette::PAGE['id']]);
				$gazette .= close_container();
				$gazette .=     '</div>
                             </div>';

				$output .= $gazette;
                echo $output;

                $iteration++;
			}
			?>
        </div>

        <?php
        wp_link_pages( array(
	        'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'shoreditch' ) . '</span>',
	        'after'       => '</div>',
	        'link_before' => '<span>',
	        'link_after'  => '</span>',
	        'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'shoreditch' ) . ' </span>%',
	        'separator'   => '<span class="screen-reader-text">, </span>',
        ) );
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
		<?php shoreditch_entry_footer(); ?>
    </footer><!-- .entry-footer -->

	<?php shoreditch_author_bio();	?>
    </div><!-- .hentry-wrapper -->
</article><!-- #post-## -->

<script>
    // init tooltips
    jQuery('[data-toggle="tooltip"]').tooltip();
</script>
