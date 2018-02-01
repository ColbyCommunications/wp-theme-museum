<?php
/**
 * Page (no post thumbnail)
 *
 * @package colbycomms/wp-theme-museum
 */

global $post;

setup_postdata( $post );

if ( ! function_exists( 'draw_page_no_thumbnail_title' ) ) :
	/**
	 * Renders the title for this page.
	 *
	 * @return string HTML.
	 */
	function draw_page_no_thumbnail_title() : string {
		ob_start(); ?>
		<h1 class=page-no-thumbnail__title><?php the_title(); ?></h1>
		<?php
		return ob_get_clean();
	}
endif;

if ( ! function_exists( 'draw_page_no_thumbnail_header_text' ) ) :
	/**
	 * Renders the header text for this page.
	 *
	 * @return string HTML.
	 */
	function draw_page_no_thumbnail_header_text() : string {
		ob_start();

		$header_text = get_post_meta( get_the_id(), 'header_text', true );
		if ( ! empty( $header_text ) ) :
	?>

		<h2 class=page-no-thumbnail__header-text>
			<?php echo $header_text; ?>
		</h2>
		<?php

		endif;

		return ob_get_clean();
	}
endif;

if ( ! function_exists( 'draw_page_no_thumbnail_footer_text' ) ) :
	/**
	 * Renders the footer text for this page.
	 *
	 * @return string HTML.
	 */
	function draw_page_no_thumbnail_footer_text() : string {
		return '';
	}
endif;

get_header();
?>

<main id=main class=main--page-no-thumbnail>

<article <?php post_class( 'page-no-thumbnail' ); ?>>
	<header class='page-no-thumbnail__header'>
		<?php echo apply_filters( 'page_has_thumbnail_title', draw_page_no_thumbnail_title() ); ?>
		<?php echo apply_filters( 'page_has_thumbnail_header_text', draw_page_no_thumbnail_header_text() ); ?>
	</header>

	<?php the_content(); ?>

	<?php echo apply_filters( 'page_has_thumbnail_footer_text', draw_page_no_thumbnail_footer_text() ); ?>
</article>

<?php echo apply_filters( 'page_maybe_do_sidebar', '' ); ?>

</main>

<?php
get_footer();
