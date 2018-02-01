<?php
/**
 * Template Name: Splash page
 *
 * The template for the site front page.
 *
 * @package colbycomms/wp-theme-museum
 */

global $post;

setup_postdata( $post );

if ( ! function_exists( 'modify_splash_page_post_gallery' ) ) {
	/**
	 * Callback to post_gallery filter on this page.
	 *
	 * @param string $output Initial shortcode output.
	 * @param array  $atts Shortcode atts.
	 * @return string HTML.
	 */
	function modify_splash_page_post_gallery( string $output = '', array $atts = [] ) : string {
		$args = [
			'post__in' => explode( ',', $atts['include'] ?? [] ),
			'orderby' => 'post__in',
			'post_type' => 'attachment',
			'post_status' => 'inherit',
		];

		$gallery_query = new WP_Query( $args );

		if ( empty( $gallery_query->posts ) ) {
			return '';
		}

		$images = '';
		$titles = '';
		$wordcount = 1;
		foreach ( $gallery_query->posts as $key => $gallery_post ) {
			$attachment_image = wp_get_attachment_image(
				$gallery_post->ID,
				'full',
				false,
				0 === $key ? [ 'class' => 'front-page-gallery__active-image' ] : []
			);

			$images .= '<div class=front-page-gallery__image-container>' . ( 0 === $key ? $attachment_image : str_replace(
				[ 'srcset=', 'src=' ],
				[ 'data-original-set=', 'data-original=' ],
				$attachment_image
			) ) . '</div>';

			$title = '';
			$words = explode( ' ', $gallery_post->post_content );
			foreach ( $words as $word_key => $word ) {
				$wordlength = strlen( $word );
				$split_word = str_split( $word );

				if ( count( $words ) - 1 === $word_key ) {
					$split_word = array_merge( $split_word, [ '&nbsp;', '&nbsp;', '&nbsp;', '&nbsp;' ] );
				} else {
					$split_word = array_merge( $split_word, [ '&nbsp;' ] );
				}

				$split_word = implode( '</span><span>', $split_word );

				$title .= "<span class='title-$key word-$wordcount length-$wordlength'><span>$split_word</span></span> ";
				$wordcount++;
			}

			$gallery_active = 0 === $key ? ' front-page-gallery__active-title' : '';

			$titles .= "

            $title
        ";
		}

		return "
        <div class='front-page-gallery pre-load'>
            <div class=front-page-gallery__titles>
                $titles
            </div>
            <div class=front-page-gallery__images>
                $images
            </div>
        </div>
    ";
	}
}

/** Modify the content of the [gallery] shortcode only on this page. */
add_filter( 'post_gallery', 'modify_splash_page_post_gallery', 1, 2 );

/** Separate the gallery from the post content. */
$non_gallery_post_content = $post->post_content;
if ( has_shortcode( $post->post_content, 'gallery' ) ) {
	$gallery = '';
	$non_gallery_post_content = preg_replace_callback(
		'/\[gallery.*\]/',
		function( $matches ) use ( &$gallery ) {
			$gallery = $matches[0];
			return '';
		},
		$post->post_content
	);
}



get_header();

echo do_shortcode( $non_gallery_post_content );
echo isset( $gallery ) ? do_shortcode( $gallery ) : '';

get_footer();
