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

/** Modify the content of the [gallery] shortcode only on this page. */
add_filter( 'post_gallery', function( $output, $atts ) {
	if ( ! is_single() || is_home() || is_front_page() ) {
		return '';
	}
	
	if ( empty( $gallery_posts = get_posts( [
		'post__in' => explode( ',', $atts['include'] ),
		'orderby' => 'post__in',
		'post_type' => 'attachment',
	] ) ) ) {
		return '';
	}

	$images = '';
	$captions = '';
	foreach ( $gallery_posts as $key => $gallery_post ) {
		$attachment_image = wp_get_attachment_image(
			$gallery_post->ID,
			'medium',
			false,
			0 === $key ? [ 'class' => 'front-page-gallery__active-image' ] : []
		);

		$images .= "<div class=post-gallery__image-container>$attachment_image</div>";
		$captions .= "<span class=post-gallery__caption>$gallery_post->post_excerpt</span>";
	}

	return "
        <div class='post-gallery pre-load'>
            <div class=post-gallery__images>
                $images
            </div>
            <div class=post-gallery__captions>
                $captions
            </div>
        </div>
    ";
}, 1, 2 );
