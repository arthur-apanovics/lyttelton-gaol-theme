<?php

function lyttelton_gaol_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'bootstrap_css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' );
	//wp_enqueue_style( 'child-style',get_stylesheet_directory_uri() . '/style.css', array( $parent_style ), wp_get_theme()->get('Version'));
}
add_action( 'wp_enqueue_scripts', 'lyttelton_gaol_enqueue_styles' );

function lyttelton_gaol_enqueue_js() {
	wp_enqueue_script( 'bootstrap_js_bundle', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js', ['jQuery']);
}
add_action( 'wp_enqueue_scripts', 'lyttelton_gaol_enqueue_js');

function search_filter($query) {
	if ($query->is_search && !is_admin() ) {
		if(isset($_GET['post_type'])) {
			$type = $_GET['post_type'];
			if($type == 'book') {
				$query->set('post_type',array('book'));
			}
		}
	}
	return $query;
}
add_filter('pre_get_posts','search_filter');

function get_all_meta_values( $key = '', $distinct = false, $type = 'convict', $status = 'publish' ) {
	global $wpdb;

	if( empty( $key ) )
		return;

	$distinct_select = !$distinct ? : 'DISTINCT';
	$query = "SELECT {$distinct_select} pm.meta_value FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = '%s' 
        AND p.post_status = '%s' 
        AND p.post_type = '%s'";

	$r = $wpdb->get_col( $wpdb->prepare( $query, $key, $status, $type ) );
	sort($r, SORT_STRING);

	//	return array_filter($r);
	return $r;
}

function gaol_post_thumbnail() {
	?>
		<div class="post-thumbnail float-right">
			<?php the_post_thumbnail(); ?>
		</div>
	<?php
}