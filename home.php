<?php
/**
 * Home.php
 *
 * The recent posts archive list.
 *
 * @package colbycomms/wp-theme-museum
 */

get_header();

?>

<main id="main" class="main--index">
<?php echo apply_filters( 'pre_main_article', '' ); ?>

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
	</footer>

</main>

<?php

get_footer();
