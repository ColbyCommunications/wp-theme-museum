<?php

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

	return $response;
}, 10, 2 );
