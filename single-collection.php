<?php
/**
 * Template for a single collection page.
 *
 * @package colbycomms/wp-theme-museum
 */

global $post;

get_header();

setup_postdata( $post );

$image_url = get_post_meta( $post->ID, 'image_url', true );

?>
<main id=main class=main--single-collection>
	<?php if ( get_query_var( 'source' ) === 'collection' ) : ?>
	<nav class=collection__back-button>
		<a href="javascript:history.go(-1)">« Back</a>
	</nav>
	<?php endif; ?>
	<article <?php post_class(); ?>>
		<div class=collection__content-container>
			<h1 class=collection__title><?php the_title(); ?></h1>
			<div class=collection__content><?php the_content(); ?></div>
		</div>
		<?php if ( $image_url && strpos( $image_url, 'noimage' ) === false ) : ?>
		<div class=collection__thumbnail-container>
			<img src=<?php echo $image_url; ?> alt=<?php echo esc_attr( get_the_title() ); ?>>
		</div>
		<?php endif; ?>
	</article>
</main>
<?php
get_footer();
