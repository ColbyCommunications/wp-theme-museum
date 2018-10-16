<?php
/**
 * Header.php
 *
 * The header navigation, logos, and search.
 *
 * @package colbycomms/wp-theme-museum
 */

use ColbyComms\SVG\SVG;

add_filter(
	'three_column_header_left_column', function( $content ) {
		ob_start(); ?>

	<div class=lunder-logo-container>
		<a href=<?php bloginfo( 'url' ); ?>>
			<?php locate_template( 'assets/lunder-institute-aa.svg', true, false ); ?>
		</a>
	</div>

		<?php
		return ob_get_clean();
	}
);

add_filter(
	'three_column_header_middle_column', function( $content ) {
		ob_start();

		wp_nav_menu(
			[
				'menu' => 'Site Menu',
				'menu_class' => 'site-menu',
				'container' => 'nav',
				'container_class' => 'site-menu-container',
				'depth' => 2,
			]
		);

		$lists = explode( '</ul>', ob_get_clean() );

		$lists[ count( $lists ) - 2 ] .= '<li><div id=header-search></div></li>';
		$lists = implode( '</ul>', $lists );

		return $lists;
	}
);

add_filter(
	'three_column_header_right_column', function( $content ) {
		ob_start();
		?>

	<span class=colby-museum-logo-container>
		<a href=//colby.edu/museum/>
			<?php SVG::show( 'colby-museum-of-art' ); ?>
		</a>
	</span>

	<span class=colby-logo-container>
		<a href=//colby.edu>
			<?php SVG::show( 'colby-logo' ); ?>
		</a>
	</span>

		<?php
		return ob_get_clean();
	}
);
?>
<!DOCTYPE html>
<html lang=en class=no-js>
<title>
	<?php
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	?>
</title>
<meta charset=utf-8>
<meta http-equiv=X-UA-Compatible content="IE=edge">
<meta name=viewport content="width=device-width,initial-scale=1">
<meta name=format-detection content="telephone=no">

<?php wp_head(); ?>
<link rel="shortcut icon" href="http://www.colby.edu/favicon.ico" />

<body <?php body_class(); ?>>

<a class=skip-link href="#main">Skip to main content</a>
<header class=three-column-header>
	<div class=three_column-header__left>
		<?php echo apply_filters( 'three_column_header_left_column', '' ); ?>
	</div>

	<div class=three-column-header__collapsible-columns>
		<div class=three_column-header__middle>
			<?php echo apply_filters( 'three_column_header_middle_column', '' ); ?>
		</div>

		<div class=three_column-header__right>
			<?php echo apply_filters( 'three_column_header_right_column', '' ); ?>
		</div>
	</div>

	<a class=menu-icon-container href=#>
		<svg id=menu-icon viewbox="0 0 20 20">
			<title>Menu</title>
			<path d="M0,6 20,6" stroke="currentColor" stroke-width="2" />
			<path d="M0,16 20,16" stroke="currentColor" stroke-width="2" />
		</svg>
	</a>

</header>
