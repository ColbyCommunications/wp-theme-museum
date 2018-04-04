<?php
/**
 * Template Name: Page with Panels (for front page, 4/18)
 *
 * Homepage template originally created for the Blanco residency.
 *
 * @package colbycomms/wp-theme-museum
 */

global $post;

use ColbyComms\MuseumTheme\FrontPageFields;

setup_postdata( $post );

$panels = FrontPageFields::get( FrontPageFields::PANELS_KEY );

get_header(); ?>

<main id="main" class="main main--panels main--page-has-thumbnail">
	<article class="panels">
		<?php foreach ( $panels as $panel ) : ?>
		<section class="panel__container <?php echo esc_attr( $panel->extra_css_key ?: '' ); ?>"
			style="background-image: url('<?php echo wp_get_attachment_url( $panel['image'] ); ?>')"
		>	
			<div class="panel">
				<div class="panel__inner">
					<?php echo apply_filters( 'the_content', $panel['content'] ); ?>
				</div>
			</div>
		</section>
		<?php endforeach; ?>
	</article>
</main>

<?php
get_footer();
