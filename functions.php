<?php
/**
 * Functions.php
 *
 * Initiate the theme and provide single-purpose hooks..
 *
 * @package lunder-institute
 */

global $lunder_institute;

require_once( 'vendor/autoload.php' );

$lunder_institute = new Colby_College\Wp_Components\Colby_Wp_Theme();

/** Exclude media-kit posts from the news archive. */
add_action( 'pre_get_posts', function( $query ) {
	if ( is_home() && $query->is_main_query() ) {
		$query->set( 'category__not_in', [ get_cat_ID( 'Media Kit' ) ] );
	}
} );

if ( current_user_can( 'edit_others_posts' && isset( $_GET['refresh_embark'] ) ) ) {
	require 'inc/embark-refresher.php';
	new Embark_Refresher();
}

register_post_type( 'collection', [
	'labels' => [
		'name' => 'Collection Items',
		'singular_name' => 'Collection Item',
	],
	'public' => false,
	'exclude_from_search' => false,
	'publicly_queryable' => true,
	'supports' => [ 'title', 'editor', 'excerpt', 'thumbnail' ],
	'show_in_rest' => true,
] );
