<?php

if ( has_post_thumbnail() ) {
    add_filter( 'page_has_thumbnail_article_footer', function( $content ) {
        global $post;
        ob_start();
        echo '<div class=page-has-thumbnail__footer-caption>Banner image: ';
        the_post_thumbnail_caption( $post->ID );
        echo '</div>';
        return ob_get_clean();
    } );

    return Colby_College\Wp_Components\Wp_Templates::load( 'page-with-header-image.php' );
}

return Colby_College\Wp_Components\Wp_Templates::load( 'page.php' );
