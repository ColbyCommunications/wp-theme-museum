<?php

if ( ! has_post_thumbnail() ) {
	return Colby_College\Wp_Components\Wp_Templates::load( 'page.php' );
}

/** Add banner image caption to article footer. */
add_filter( 'page_has_thumbnail_article_footer', function( $content ) {
    global $post;

    $caption = get_the_post_thumbnail_caption( $post->ID );

    if ( ! $caption ) {
        return '';
    }

    ob_start();
    echo "
    <div class=page-has-thumbnail__footer-caption>
        Banner image: $caption
    </div>
    ";
    return ob_get_clean();
} );

Colby_College\Wp_Components\Wp_Templates::load( 'page-with-header-image.php' );
