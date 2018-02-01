<?php
/**
 * Media-kit.php
 *
 * Provide a shortcode to display posts in the media-kit category.
 *
 * @package colbycomms/wp-theme-museum
 */

/**
 * Assembles HTML for post title jump links.
 *
 * @param array $kit_posts WP Posts.
 * @return string HTML.
 */
function media_kit_get_post_titles( array $kit_posts = [] ) : string {
	return implode(
		'',
		array_map(
			function( $kit_post ) {
				return "
		<a class=media-kit__jump-link href=#$kit_post->post_name>
			" . substr( $kit_post->post_title, 0, strpos( $kit_post->post_title, ',' ) ) . '
		</a>
	';
			},
			$kit_posts
		)
	);
}

/**
 * Renders the output of the [media-kit] shortcode.
 *
 * @param array $atts Shortcode attributes.
 * @return string HTML output.
 */
function media_kit_shortcode_callback( $atts = [] ) : string {
	$kit_query = new WP_Query(
		[
			'category_name' => 'media-kit',
			'posts_per_page' => 50,
			'orderby' => 'name',
			'order' => 'ASC',
		]
	);

	$post_names = [];
	$titles = media_kit_get_post_titles( $kit_query->posts );

	ob_start();

	?>

	<div class=media-kit__jump-links>
	<?php echo wp_kses_post( $titles ); ?>
	</div>

	<?php

	foreach ( $kit_query->posts as $kit_post ) {
		$original_post_thumbnail = get_the_post_thumbnail( $kit_post->ID, 'large' );
		$post_thumbnail = str_replace(
			[ 'srcset=', 'src=' ],
			[ 'data-original-set=', 'data-original=' ],
			$original_post_thumbnail
		);
		$post_content = apply_filters( 'the_content', $kit_post->post_content );

		$modal = "
			<div class=media-kit-post__modal>
				<div class=media-kit-post__modal-thumbnail-container>
					$original_post_thumbnail
				</div>

				<div class=media-kit-post__modal-content-container>
					<h1 class=media-kit-post__modal-title>$kit_post->post_title</h1>
					<div class=media-kit-post__modal-content>$post_content</div>
				</div>
			</div>";

		$modal = esc_attr( $modal );
		$id_attribute = " id=$kit_post->post_name";

		echo "
		<a href=#{$id_attribute} data-image='{$modal}' class=media-kit-post>
			<div class=media-kit-post__thumbnail-container>
				$post_thumbnail
			</div>

			<div class=media-kit-post__content-container>
				<h1 class=media-kit-post__title>$kit_post->post_title</h1>
				<div class=media-kit-post__content>$post_content</div>
			</div>
		</a>
		";
	}

	return ob_get_clean();
}

add_shortcode( 'media-kit', 'media_kit_shortcode_callback' );
