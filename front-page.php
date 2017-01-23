<?php
global $post;

setup_postdata( $post );

add_filter( 'post_gallery', function( $output, $atts ) {
    if ( empty( $gallery_posts = get_posts( [
        'post__in' => explode(',', $atts['include'] ),
        'orderby' => 'post__in',
        'post_type' => 'attachment'
    ] ) ) ) {
        return '';
    }

    $images = '';
    $titles = '';
    $wordcount = 1;
    foreach ( $gallery_posts as $key => $gallery_post ) {
        $images .= str_replace(
            ['srcset=', 'src='],
            ['data-original-set=', 'data-original='],
            wp_get_attachment_image(
                $gallery_post->ID,
                'full',
                false,
                $key === 0 ? ['class' => 'front-page-gallery__active-image'] : []
            )
        );

        $title = '';
        foreach ( explode(' ', $gallery_post->post_content ) as $word ) {
            $title .= "<span class=word-$wordcount>$word</span> ";
            $wordcount++;
        }

        $gallery_active = $key === 0 ? ' front-page-gallery__active-title' : '';

        $titles .= "
            <span class='front-page-gallery__title$gallery_active'>
                $title
            </span>";
    }

    return "
        <div class=front-page-gallery>
            <div class=front-page-gallery__titles>
                $titles
            </div>
            <div class=front-page-gallery__images>
                $images
            </div>
        </div>
    ";
}, 1, 2 );

$non_gallery_post_content = $post->post_content;
if ( has_shortcode( $post->post_content, 'gallery' ) ) {
	// Separate the gallery from the content.
	$gallery = '';
	$non_gallery_post_content = preg_replace_callback(
		'/\[gallery.*\]/',
		function( $matches ) use( &$gallery ) {
			$gallery = $matches[0];
			return '';
		},
		$post->post_content );
}

get_header();
echo $non_gallery_post_content;
echo isset( $gallery ) ? do_shortcode( $gallery ) : '';
get_footer();
