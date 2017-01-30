<?php
/**
 * Footer.php
 *
 * The sitewide footer.
 *
 * @package lunder-institute
 */

/** Add the Google Analytics script. */
add_action( 'wp_footer', function() {
	if ( strpos( get_bloginfo( 'url' ), 'colby.edu' ) && false === strpos( get_bloginfo( 'url' ), 'author' ) ) : ?>

<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	ga('create', 'UA-26881270-1', 'auto');
	ga('send', 'pageview');
</script>

	<?php endif;
} );

Colby_College\Wp_Components\Wp_Parts::load( 'simple-footer.php' );
