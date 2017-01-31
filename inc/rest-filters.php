<?php
/**
 * Rest-filters.php
 *
 * Hooks related to the WP REST API.
 *
 * @package lunder-institute
 */

/** Let all post types into REST post search. */
add_filter( 'rest_post_query', function( $prepared_args, $request ) {
	$params = $request->get_params();

	if ( isset( $params['search'] ) ) {
		$prepared_args['post_type'] = 'any';
		$prepared_args['posts_per_page'] = 5;
	}

	return $prepared_args;
}, 10, 2 );


/** Make media-kit posts link to the media-kit page. */
add_filter( 'rest_prepare_post', function( $response, $the_post ) {
	if ( has_category( 'media-kit', $the_post ) ) {
		$response->data['link'] = get_bloginfo( 'url' ) . "/media-kit#$the_post->post_name";
	}

	if ( 'collection' === $the_post->post_type ) {
		$response->data['img_url'] = get_post_meta( $the_post->ID, 'image_url', true );
	}

	return $response;
}, 10, 2 );

add_filter( 'rest_collection_query', function( $prepared_args ) {
	$prepared_args['orderby'] = 'title';
	$prepared_args['order'] = 'ASC';

	return $prepared_args;
} );

add_filter( 'rest_prepare_collection', function( $response, $the_post ) {
	$response->data['img_url'] = get_post_meta( $the_post->ID, 'image_url', true );

	return $response;
}, 10, 2 );
