<?php
/**
 * The fallback template.
 *
 * @package colbycomms/wp-theme-museum
 */

if ( ! have_posts() ) {
	return include locate_template( '404.php' );
}

get_header(); ?>

<main id=main class=main--index>

<?php echo apply_filters( 'index_before_loop', '' ); ?>

<?php
while ( have_posts() ) :
	the_post();
	?>

	<article <?php post_class(); ?>>
		<header>
			<?php the_title( '<h1>', '</h1>' ); ?>
			<?php is_single() ? the_date( '', '<span class=the-date>', '</span>' ) : null; ?>
		</header>

		<?php the_content(); ?>

	</article>

	<?php echo apply_filters( 'index_maybe_do_sidebar', '' ); ?>

<?php endwhile; ?>

<?php echo apply_filters( 'index_after_loop', '' ); ?>

</main>

<?php
get_footer();
