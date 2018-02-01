<?php
/**
 * Home.php
 *
 * The recent posts archive list.
 *
 * @package colbycomms/wp-theme-museum
 */

get_header();

$page_id = get_option( 'page_for_posts' );

?>

<main id="main" class="main--index main--page-has-thumbnail">
<?php echo apply_filters( 'pre_main_article', '' ); ?>
<div class='page-has-thumbnail'>
	<header class='page-has-thumbnail__header'>
		<h1 class=page-has-thumbnail__title><?php echo get_the_title( $page_id ); ?></h1>
		<div class=page-has-thumbnail__thumbnail-container>
			<?php echo get_the_post_thumbnail( $page_id, 'full' ); ?>
		</div>
	</header>
</div>
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>

	<article <?php post_class(); ?>>
		<header class="post-header">
			<h1 class="post-header__title">
				<a href=<?php the_permalink(); ?>>
					<?php the_title(); ?>
				</a>
			</h1>
			<div class="date-time">
				<?php the_time( 'F j, Y' ); ?>
			</div>
		</header>

		<?php the_content(); ?>

	</article>

<?php
	endwhile;
endif;

?>
	<footer class=main-footer>
		<nav class="next-prev-links">
			<div class="next-prev-links__prev">
				<?php previous_posts_link(); ?>
			</div>

			<div class="next-prev-links__next">
				<?php next_posts_link(); ?>
			</div>

		</nav>
		<?php 
		$caption = get_the_post_thumbnail_caption( $page_id );
		if ( $caption ) :
		?>
			<div class=page-has-thumbnail__footer-caption>
				Banner image: <?php echo wp_kses_post( $caption ); ?>
			</div>

		<?php endif; ?>
	</footer>

</main>

<?php

get_footer();
