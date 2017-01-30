<?php
/**
 * Media-kit.php
 *
 * Provide a shortcode to display posts in the media-kit category.
 *
 * @package lunder-institute
 */

add_action( 'init', function() {
	add_shortcode( 'media-kit', function( $atts ) {
		$kit_posts = get_posts( [
			'category_name' => 'media-kit',
			'posts_per_page' => 50,
			'orderby' => 'name',
			'order' => 'ASC',
		] );

		$post_names = [];
		$titles = implode( '', array_map( function( $kit_post ) use ( &$post_names ) {
			$first_word = substr( $kit_post->post_name, 0, strpos( $kit_post->post_name, '-' ) );

			if ( in_array( $first_word, $post_names, true ) ) {
				return;
			} else {
				$post_names[] = $first_word;
			}

			return "
				<a class=media-kit__jump-link href=#$kit_post->post_name>
					" . substr( $kit_post->post_title, 0, strpos( $kit_post->post_title, ',' ) ) . '
                </a>
            ';
		}, $kit_posts ?: [] ) );

		ob_start();

		?>

		<div class=media-kit__jump-links>
			<?php echo wp_kses_post( $titles ); ?>
		</div>

		<?php

		$post_names = [];
		foreach ( $kit_posts as $kit_post ) {
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

			if ( ! in_array( $kit_post->post_name, $post_names, true ) ) {
				$id_attribute = " id=$kit_post->post_name";
			} else {
				$post_names[] = $kit_post->post_name;
				$id_attribute = '';
			}

			echo wp_kses_post( "
			<a href=#{$id_attribute} data-image='{$modal}' class=media-kit-post>
				<div class=media-kit-post__thumbnail-container>
					$post_thumbnail
				</div>

				<div class=media-kit-post__content-container>
					<h1 class=media-kit-post__title>$kit_post->post_title</h1>
					<div class=media-kit-post__content>$post_content</div>
				</div>
			</a>
			" );
		}

		return ob_get_clean();
	} );
} );
