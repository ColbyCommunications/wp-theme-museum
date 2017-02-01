<?php
/**
 * Page.php
 *
 * Template for a single post of the "page" post type.
 *
 * @package lunder-institute
 */

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
	?>
	<div class=page-has-thumbnail__footer-caption>
		Banner image: <?php echo wp_kses_post( $caption ); ?>
		<?php if ( ! empty( $front_page_captions = get_post_meta( $post->ID, 'after_banner_caption', true ) ) ) :

			echo $front_page_captions;
		endif; ?>
	</div>

	<?php
	return ob_get_clean();
} );

Colby_College\Wp_Components\Wp_Templates::load( 'page-with-header-image.php' );
