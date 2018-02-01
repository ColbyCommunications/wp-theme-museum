<?php
/**
 * Page.php
 *
 * Template for a single post of the "page" post type.
 *
 * @package colbycomms/wp-theme-museum
 */

if ( ! has_post_thumbnail() ) {
	include 'page-no-post-thumbnail.php';
	return;
}

global $post;

setup_postdata( $post );

if ( ! function_exists( 'draw_page_thumbnail_header_text' ) ) :
	/**
	 * Renders header text for this page.
	 *
	 * @return string HTML.
	 */
	function draw_page_thumbnail_header_text() : string {
		ob_start();

		$header_text = get_post_meta( get_the_id(), 'header_text', true );
		if ( ! empty( $header_text ) ) :
	?>

		<h2 class=page-has-thumbnail__header-text>
			<?php echo $header_text; ?>
		</h2>
		<?php

		endif;

		return ob_get_clean();
	}
endif;

get_header();
?>

<main id=main class=main--page-has-thumbnail>
	<article <?php post_class( 'page-has-thumbnail' ); ?>>
		<header class='page-has-thumbnail__header'>
			<h1 class=page-has-thumbnail__title><?php the_title(); ?></h1>
			<?php echo apply_filters( 'page_has_thumbnail_header_text', draw_page_thumbnail_header_text() ); ?>
			<div class=page-has-thumbnail__thumbnail-container>
				<?php the_post_thumbnail( 'full' ); ?>
			</div>
		</header>

		<?php
		the_content();

		$caption = get_the_post_thumbnail_caption( $post->ID );
		if ( $caption ) :
		?>
		<footer class=page-has-thumbnail__footer>
			<div class=page-has-thumbnail__footer-caption>
				Banner image: <?php echo wp_kses_post( $caption ); ?>
				<?php
				$front_page_captions = get_post_meta( $post->ID, 'after_banner_caption', true );

				if ( ! empty( $front_page_captions ) ) :

					echo apply_filters( 'the_content', $front_page_captions );
				endif;
				?>
			</div>
		</footer>

		<?php endif; ?>
	</article>

</main>

<?php
get_footer();
