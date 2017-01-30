<?php
/**
 * Header.php
 *
 * The header navigation, logos, and search.
 *
 * @package lunder-institute
 */

/** Add typekit to page head. */
add_action( 'wp_head', function() {
	echo '
<script src="https://use.typekit.net/gty7fbd.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
	';
} );

add_filter( 'three_column_header_left_column', function( $content ) {
	ob_start(); ?>

	<div class=lunder-logo-container>
		<a href=<?php bloginfo( 'url' ); ?>>
			<?php include 'lunder-institute.svg'; ?>
		</a>
	</div>

	<?php
	return ob_get_clean();
} );

add_filter( 'three_column_header_middle_column', function( $content ) {
	ob_start();

	wp_nav_menu( [
		'menu' => 'Site Menu',
		'menu_class' => 'site-menu',
		'container' => 'nav',
		'container_class' => 'site-menu-container',
		'depth' => 2,
	] );

	$lists = explode( '</ul>', ob_get_clean() );

	$lists[ count( $lists ) - 2 ] .= '<li><div id=header-search></div></li>';
	$lists = implode( '</ul>', $lists );

	return $lists;
} );

add_filter( 'three_column_header_right_column', function( $content ) {
	ob_start(); ?>

	<span class=colby-museum-logo-container>
		<a href=//colby.edu/museum/>
			<?php Colby_College\Wp_Components\Wp_Parts::load_svg( 'colby-museum-logo' ); ?>
		</a>
	</span>

	<span class=colby-logo-container>
		<a href=//colby.edu>
			<?php Colby_College\Wp_Components\Wp_Parts::load_svg( 'colby-logo' ); ?>
		</a>
	</span>

	<?php
	return ob_get_clean();
} );


Colby_College\Wp_Components\Wp_Parts::load( 'head.php' );
Colby_College\Wp_Components\Wp_Parts::load( 'three-column-header.php' );
