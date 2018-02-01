<?php
/**
 * Template Name: Blanco Homepage
 *
 * Homepage template originally created for the Blanco residency.
 *
 * @package colbycomms/wp-theme-museum
 */

global $post;

setup_postdata( $post );

get_header(); ?>

<main id="main"
	class="main main--blanco main--page-has-thumbnail"
	style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>')"
	>
	<article class="blanco">
		<div class="blanco__inner primary">
			<?php the_content(); ?>
		</div>
	</article>
</main>

<?php
get_footer();
