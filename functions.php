<?php

global $lunder_institute;

// Run autoloader and autoload classes.
require_once( 'vendor/autoload.php' );

require( 'class-colby-wp-theme.php' );

$lunder_institute = new Colby_Wp_Theme();

add_action( 'wp_head', function() {
    if ( ! is_singular() ) {
        return;
    }

    $extra_css = get_post_meta( get_the_id(), 'extra_css', true );

    if ( ! $extra_css ) {
        return;
    }

    echo "<style type='text/css'>$extra_css</style>";
}, 10 );

add_shortcode( 'lunder-logo-svg', function() {
    ob_start();
    echo '<div class=liaa-logo-container>'; ?>
    <svg x="0px" y="0px"
	 width="256px" height="147px" viewBox="177.5 324.5 256 147" enable-background="new 177.5 324.5 256 147" xml:space="preserve">
<title>Lunder Institute of American Art</title>
<g>
	<g>
		<g>
			<path fill="currentColor" d="M181.808,385.292v-55.6h12.724v43.996h14.83v11.604H181.808z"/>
			<path fill="currentColor" d="M250.311,373.375c-0.717,2.688-1.837,5.018-3.36,6.989c-1.523,1.972-3.495,3.584-5.869,4.705
				c-2.419,1.165-5.332,1.747-8.737,1.747c-3.405,0-6.272-0.583-8.646-1.747c-2.375-1.165-4.301-2.733-5.78-4.705
				c-1.479-1.971-2.554-4.301-3.226-6.989c-0.672-2.688-0.986-5.556-0.986-8.647v-35.036h12.634v33.916
				c0,1.568,0.09,3.046,0.269,4.391s0.493,2.509,0.985,3.495c0.493,0.985,1.12,1.747,1.882,2.33
				c0.807,0.583,1.792,0.851,3.047,0.851c1.254,0,2.285-0.269,3.046-0.851s1.434-1.344,1.882-2.33
				c0.493-0.986,0.806-2.15,0.985-3.495s0.269-2.823,0.269-4.391v-33.916h12.589v35.036
				C251.386,367.819,251.027,370.687,250.311,373.375z"/>
			<path fill="currentColor" d="M285.884,385.292l-12.903-33.87h-0.224l0.313,33.87h-11.246v-55.6h13.844l12.813,34.319h0.224l-0.224-34.319h10.842v55.6
				H285.884z"/>
			<path fill="currentColor" d="M349.503,357.649c0,4.211-0.448,7.975-1.389,11.379c-0.896,3.405-2.33,6.317-4.212,8.737
				c-1.881,2.419-4.301,4.256-7.168,5.555c-2.912,1.299-6.362,1.971-10.35,1.971h-15.636v-55.6h15.636
				c3.987,0,7.438,0.672,10.35,1.972c2.912,1.299,5.287,3.181,7.168,5.6c1.882,2.419,3.271,5.376,4.212,8.781
				C349.055,349.495,349.503,353.348,349.503,357.649z M336.869,357.649c0-5.601-0.941-9.812-2.867-12.679
				c-1.927-2.868-4.391-4.301-7.438-4.301h-3.047v33.602h3.047c3.047,0,5.511-1.434,7.438-4.301
				C335.883,367.192,336.869,363.07,336.869,357.649z"/>
			<path fill="currentColor" d="M357.254,385.292v-55.6h26.882v11.066h-14.83v10.932h13.665v10.35h-13.665v11.962h15.771v11.29H357.254z"/>
			<path fill="currentColor" d="M417.244,385.292l-7.438-22.132h-3.674v22.132h-12.096v-55.6h17.786c5.376,0,9.543,1.389,12.545,4.211
				c2.957,2.823,4.479,6.989,4.479,12.545c0,2.061-0.224,3.897-0.717,5.511c-0.447,1.613-1.075,3.001-1.837,4.167
				s-1.612,2.105-2.554,2.822c-0.94,0.717-1.837,1.255-2.732,1.568l9.498,24.82h-13.262V385.292z M416.482,347.121
				c0-1.434-0.179-2.554-0.582-3.45s-0.896-1.613-1.523-2.106c-0.627-0.538-1.344-0.896-2.061-1.075
				c-0.762-0.179-1.523-0.269-2.24-0.269h-3.943v14.068h3.674c1.793,0,3.36-0.583,4.66-1.703
				C415.811,351.466,416.482,349.629,416.482,347.121z"/>
		</g>
		<g>
			<path fill="currentColor" d="M182.838,398.867h5.824v32.796h-5.824V398.867z"/>
			<path fill="currentColor" d="M199.012,398.867h7.75l15.233,24.552h0.09v-24.552h5.824v32.796h-7.393l-15.591-25.358h-0.089v25.313h-5.824V398.867
				L199.012,398.867z"/>
			<path fill="currentColor" d="M254.119,405.722c-0.627-0.806-1.479-1.479-2.599-2.016c-1.12-0.538-2.24-0.807-3.405-0.807
				c-0.672,0-1.344,0.09-2.061,0.269c-0.672,0.18-1.299,0.448-1.837,0.807s-1.031,0.807-1.389,1.389
				c-0.358,0.583-0.538,1.255-0.538,2.062c0,0.762,0.134,1.389,0.448,1.882c0.313,0.537,0.717,0.985,1.254,1.344
				s1.209,0.672,1.971,0.985c0.762,0.27,1.613,0.538,2.554,0.852c1.031,0.358,2.15,0.717,3.271,1.165s2.151,0.985,3.091,1.702
				c0.941,0.717,1.703,1.613,2.33,2.688c0.583,1.075,0.896,2.419,0.896,4.032c0,1.747-0.313,3.315-0.986,4.614
				c-0.672,1.3-1.523,2.42-2.599,3.271c-1.075,0.852-2.33,1.523-3.808,1.927c-1.434,0.448-2.957,0.627-4.57,0.627
				c-2.15,0-4.211-0.403-6.272-1.165c-2.016-0.806-3.718-1.971-5.018-3.494l4.167-3.897c0.807,1.12,1.882,1.971,3.226,2.643
				c1.344,0.628,2.644,0.986,3.943,0.986c0.672,0,1.389-0.09,2.105-0.27c0.717-0.179,1.344-0.447,1.927-0.851
				s1.03-0.896,1.389-1.523c0.358-0.583,0.538-1.344,0.538-2.24c0-0.852-0.179-1.568-0.582-2.15
				c-0.403-0.583-0.941-1.075-1.613-1.479c-0.672-0.403-1.479-0.762-2.419-1.075c-0.941-0.313-1.882-0.627-2.912-0.985
				c-0.986-0.314-1.972-0.673-2.957-1.12c-0.986-0.448-1.882-0.986-2.644-1.703c-0.806-0.717-1.434-1.567-1.926-2.599
				c-0.493-1.03-0.762-2.329-0.762-3.853c0-1.658,0.358-3.092,1.03-4.301c0.717-1.21,1.613-2.195,2.733-3.002
				s2.419-1.389,3.853-1.747c1.434-0.403,2.912-0.583,4.391-0.583c1.658,0,3.36,0.313,5.062,0.896
				c1.703,0.582,3.181,1.479,4.48,2.644L254.119,405.722z"/>
			<path fill="currentColor" d="M272.936,403.975H262.9v-5.107h25.94v5.107h-10.036v27.688h-5.825v-27.688H272.936z"/>
			<path fill="currentColor" d="M295.695,398.867h5.824v32.796h-5.824V398.867z"/>
			<path fill="currentColor" d="M318.5,403.975h-10.036v-5.107h25.94v5.107h-10.035v27.688h-5.824v-27.688H318.5z"/>
			<path fill="currentColor" d="M367.2,419.611c0,1.971-0.358,3.763-1.03,5.331c-0.673,1.568-1.613,2.957-2.778,4.032
				c-1.165,1.12-2.554,1.971-4.166,2.554c-1.613,0.582-3.36,0.896-5.242,0.896s-3.629-0.313-5.242-0.896
				c-1.612-0.582-3.002-1.479-4.211-2.554c-1.21-1.12-2.106-2.464-2.778-4.032s-0.985-3.36-0.985-5.331v-20.744h5.824v20.52
				c0,0.941,0.135,1.927,0.358,2.867c0.269,0.941,0.672,1.792,1.21,2.509c0.582,0.762,1.344,1.345,2.285,1.792
				c0.94,0.448,2.105,0.673,3.494,0.673s2.554-0.225,3.494-0.673c0.941-0.447,1.703-1.075,2.285-1.792
				c0.583-0.761,0.985-1.567,1.21-2.509c0.269-0.94,0.358-1.882,0.358-2.867v-20.52h5.824v20.744H367.2z"/>
			<path fill="currentColor" d="M383.688,403.975h-10.036v-5.107h25.94v5.107h-10.035v27.688h-5.824v-27.688H383.688z"/>
			<path fill="currentColor" d="M406.491,398.867h21.729v5.107h-15.86v8.333h15.054v4.929H412.36v9.229h16.712v5.197h-22.536v-32.796H406.491z"/>
		</g>
	</g>
	<g>
		<path fill="currentColor" d="M185.168,461.814h-2.33v-16.576h10.349v2.061h-8.02v5.152h7.527v1.971h-7.527V461.814z"/>
		<path fill="currentColor" d="M214.245,453.481c0,1.299-0.224,2.464-0.672,3.539c-0.448,1.075-1.075,1.972-1.837,2.778
			c-0.762,0.762-1.703,1.389-2.778,1.792c-1.075,0.448-2.24,0.627-3.495,0.627s-2.419-0.224-3.495-0.627
			c-1.075-0.448-2.016-1.03-2.777-1.792c-0.762-0.762-1.389-1.703-1.837-2.778c-0.448-1.075-0.672-2.24-0.672-3.539
			c0-1.3,0.224-2.464,0.672-3.539c0.448-1.075,1.03-1.972,1.837-2.733c0.761-0.762,1.702-1.344,2.777-1.792
			c1.076-0.403,2.24-0.627,3.495-0.627s2.419,0.224,3.495,0.627s2.016,1.03,2.778,1.792s1.389,1.658,1.837,2.733
			C214.021,451.018,214.245,452.182,214.245,453.481z M211.736,453.481c0-0.896-0.134-1.747-0.448-2.554
			c-0.314-0.807-0.717-1.523-1.255-2.105c-0.538-0.628-1.209-1.075-1.971-1.434s-1.658-0.538-2.599-0.538
			c-0.94,0-1.837,0.18-2.598,0.538c-0.762,0.358-1.434,0.851-1.972,1.434c-0.538,0.627-0.94,1.299-1.254,2.105
			c-0.313,0.807-0.448,1.657-0.448,2.554c0,0.94,0.134,1.792,0.448,2.599c0.314,0.807,0.717,1.523,1.254,2.105
			s1.21,1.075,1.972,1.434c0.761,0.358,1.613,0.538,2.598,0.538c0.941,0,1.837-0.18,2.599-0.538s1.434-0.807,1.971-1.434
			c0.538-0.582,0.986-1.299,1.255-2.105C211.557,455.273,211.736,454.422,211.736,453.481z"/>
		<path fill="currentColor" d="M220.741,461.814h-2.33v-16.576h5.331c0.807,0,1.568,0.089,2.285,0.224c0.717,0.179,1.344,0.448,1.882,0.807
			s0.985,0.851,1.299,1.434c0.313,0.582,0.448,1.299,0.448,2.15c0,1.21-0.358,2.195-1.12,2.957s-1.702,1.209-2.912,1.434l4.66,7.616
			h-2.823l-4.211-7.393h-2.464v7.348H220.741z M220.741,452.496h2.688c0.538,0,1.075-0.045,1.523-0.135
			c0.448-0.09,0.896-0.224,1.209-0.448c0.358-0.224,0.627-0.492,0.852-0.807c0.224-0.358,0.313-0.761,0.313-1.254
			s-0.09-0.896-0.313-1.255c-0.224-0.313-0.493-0.627-0.807-0.807c-0.358-0.224-0.717-0.357-1.165-0.447
			c-0.448-0.09-0.94-0.135-1.434-0.135h-2.822v5.287H220.741z"/>
		<path fill="currentColor" d="M242.112,461.814h-2.599l7.213-16.576h2.105l7.124,16.576h-2.644l-1.703-4.077h-7.885L242.112,461.814z M244.576,455.677
			h6.228l-3.091-7.796L244.576,455.677z"/>
		<path fill="currentColor" d="M268.097,457.962h0.045l4.883-12.769h3.629v16.576h-2.33v-13.889h-0.045l-5.511,13.889h-1.478l-5.466-13.889h-0.044
			v13.889h-2.24v-16.576h3.629L268.097,457.962z"/>
		<path fill="currentColor" d="M284.629,459.754h8.691v2.061h-10.977v-16.577h10.663v2.062h-8.333v4.973h7.84v1.972h-7.84v5.511H284.629z"/>
		<path fill="currentColor" d="M300.355,461.814h-2.33v-16.576h5.331c0.807,0,1.568,0.089,2.285,0.224c0.717,0.179,1.344,0.448,1.882,0.807
			c0.537,0.358,0.985,0.851,1.299,1.434c0.313,0.582,0.448,1.299,0.448,2.15c0,1.21-0.358,2.195-1.12,2.957
			s-1.702,1.209-2.912,1.434l4.659,7.616h-2.822l-4.211-7.393H300.4v7.348H300.355z M300.355,452.496h2.688
			c0.538,0,1.075-0.045,1.523-0.135c0.448-0.09,0.896-0.224,1.209-0.448c0.359-0.224,0.627-0.492,0.851-0.807
			c0.225-0.358,0.313-0.761,0.313-1.254s-0.089-0.896-0.313-1.255c-0.224-0.313-0.492-0.627-0.806-0.807
			c-0.358-0.224-0.717-0.357-1.165-0.447c-0.448-0.09-0.941-0.135-1.434-0.135H300.4v5.287H300.355z"/>
		<path fill="currentColor" d="M316.395,461.814h-2.33v-16.576h2.33V461.814z"/>
		<path fill="currentColor" d="M335.794,459.216c-0.673,0.896-1.523,1.613-2.554,2.15c-1.031,0.538-2.285,0.852-3.764,0.852
			c-1.255,0-2.42-0.224-3.495-0.627c-1.075-0.448-1.971-1.03-2.777-1.792c-0.762-0.762-1.389-1.703-1.837-2.778
			s-0.672-2.24-0.672-3.539c0-1.3,0.224-2.464,0.672-3.539s1.075-1.972,1.837-2.733c0.807-0.762,1.702-1.344,2.822-1.792
			c1.075-0.403,2.24-0.627,3.495-0.627c0.582,0,1.12,0.045,1.702,0.179c0.582,0.09,1.12,0.269,1.658,0.493
			c0.537,0.224,1.03,0.493,1.434,0.807c0.447,0.313,0.806,0.672,1.12,1.12l-1.837,1.389c-0.403-0.583-0.986-1.03-1.703-1.389
			c-0.762-0.358-1.523-0.538-2.419-0.538c-0.985,0-1.837,0.18-2.599,0.538s-1.434,0.851-1.972,1.434
			c-0.537,0.627-0.985,1.299-1.254,2.105c-0.313,0.807-0.448,1.657-0.448,2.554c0,0.94,0.135,1.792,0.448,2.644
			c0.269,0.807,0.717,1.523,1.254,2.105c0.538,0.582,1.21,1.075,1.972,1.434s1.657,0.538,2.599,0.538c0.94,0,1.792-0.18,2.554-0.583
			c0.762-0.358,1.389-0.94,1.882-1.657L335.794,459.216z"/>
		<path fill="currentColor" d="M340.229,461.814h-2.598l7.213-16.576h2.105l7.124,16.576h-2.644l-1.702-4.077h-7.886L340.229,461.814z M342.693,455.677
			h6.228l-3.092-7.796L342.693,455.677z"/>
		<path fill="currentColor" d="M369.351,458.499h0.045v-13.262h2.329v16.577h-2.912l-8.781-13.53h-0.044v13.53h-2.33v-16.576h3.002L369.351,458.499z"/>
		<path fill="currentColor" d="M385.166,461.814h-2.599l7.213-16.576h2.105l7.124,16.576h-2.644l-1.702-4.077h-7.886L385.166,461.814z M387.63,455.677
			h6.228l-3.092-7.796L387.63,455.677z"/>
		<path fill="currentColor" d="M404.924,461.814h-2.33v-16.576h5.332c0.806,0,1.567,0.089,2.284,0.224c0.717,0.179,1.345,0.448,1.882,0.807
			c0.538,0.358,0.985,0.851,1.3,1.434c0.313,0.582,0.447,1.299,0.447,2.15c0,1.21-0.358,2.195-1.12,2.957
			c-0.761,0.762-1.702,1.209-2.912,1.434l4.66,7.616h-2.823l-4.211-7.393h-2.464v7.348H404.924z M404.924,452.496h2.688
			c0.538,0,1.075-0.045,1.523-0.135s0.896-0.224,1.21-0.448c0.358-0.224,0.627-0.492,0.852-0.807
			c0.224-0.358,0.313-0.761,0.313-1.254s-0.09-0.896-0.313-1.255c-0.225-0.313-0.493-0.627-0.807-0.807
			c-0.358-0.224-0.717-0.357-1.165-0.447s-0.94-0.135-1.434-0.135h-2.822v5.287H404.924z"/>
		<path fill="currentColor" d="M424.188,461.814h-2.33v-14.561h-5.331v-2.061h12.948v2.061h-5.332v14.561H424.188z"/>
	</g>
</g>
</svg>

<?php
    echo '</div>';

    return ob_get_clean();
} );

add_action( 'wp_head', function() {
    global $is_gecko;

    echo '
<script src="https://use.typekit.net/gty7fbd.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
    ';

    if ( $is_gecko ) {
    ?>
<style>
.front-page-gallery__images img {
    left: 0;
}
</style>
    <?php
    }
} );

add_action( 'wp_enqueue_scripts', function() {
    global $is_gecko, $is_safari, $lunder_institute;

    if ( $is_gecko ) {
        wp_enqueue_style(
            "{$lunder_institute->text_domain}-firefox",
            "{$lunder_institute->assets_url}firefox.css",
            [ $lunder_institute->text_domain ],
            $lunder_institute->version
        );
    }

    if ( $is_safari ) {
        wp_enqueue_style(
            "{$lunder_institute->text_domain}-safari",
            "{$lunder_institute->assets_url}safari.css",
            [ $lunder_institute->text_domain ],
            $lunder_institute->version
        );
    }
}, 11 );

add_action( 'init', function() {
    add_shortcode( 'media-kit', function( $atts ) {
        $kit_posts = get_posts( [
            'category_name' => 'media-kit',
            'posts_per_page' => 50,
            'orderby' => 'name',
            'order' => 'ASC'
            ] );

        ob_start();
        foreach ( $kit_posts as $kit_post ) {
            $original_post_thumbnail = get_the_post_thumbnail( $kit_post->ID, 'large' );
            $post_thumbnail = str_replace(
                ['srcset=', 'src='],
                ['data-original-set=', 'data-original='],
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

            echo "
            <a href=# data-image='$modal' class=media-kit-post>
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
    } );
} );


function embarkSearchResults( $search_term ) { ?>
	<?php

	$embarkURL = 'http://embark.colby.edu/';
	if ( trim( $search_term ) ) {
		$embarkURL .= '4DACTION/HANDLECGI/CTN3?display=por';
	}
	if ( isset( $_GET['x'] ) && isset( $_GET['obj'] ) && is_numeric($_GET['x'] ) ) {
		$args = array();
		if ( substr_count( $_GET['obj'], '?') >= 1 )  {
			$parameters = explode( '?', $_GET['obj'] );
			foreach ( $parameters as $arrayitem ) {
				if ( false !== strpos( $arrayitem, "Obj" ) ) {
					$_GET['obj'] = $arrayitem;
				}
				if ( false !== stripos( $arrayitem, "sid" ) ) {
					$_GET['sid'] = str_ireplace( 'sid=', '', $arrayitem);
				}
			}
		}
		$embarkURL = "http://embark.colby.edu/{$_GET['obj']}";
		if ( false != stripos( $_GET['obj'], '?' ) ) {
			$embarkURL .= '&';
		} else {
			$embarkURL .= '?';
		}
		$embarkURL .= "x={$_GET['x']}";
		if ( isset( $_GET['sid'] ) && is_numeric( $_GET['sid'] ) ) {
			$embarkURL .= "&sid={$_GET['sid']}";
		}
		if ( isset( $_GET['port'] ) && is_numeric( $_GET['port'] ) ) {
			$embarkURL .= "&port={$_GET['port']}";
		}
		$embarkURL = str_replace( '//P', '/P', $embarkURL);
		$embarkURL = str_replace( '//O', '/O', $embarkURL);
		$response = wp_remote_get( $embarkURL );
		if ( isset( $_GET['debug'] ) ) {
			pp( $embarkURL );
			pp( $response, 1 );
		}
	} else {
		if ( isset( $_GET['obj'] ) ) {
			$embarkURL = "http://embark.colby.edu/{$_GET['obj']}";
			if ( isset( $_GET['sid'] ) && is_numeric( $_GET['sid'] ) ) {
				$embarkURL .= "&sid={$_GET['sid']}";
			}

			$response = wp_remote_get( $embarkURL );
		} else {
			// Submit search query via POST.
			$args = [
				'body' => [
					'searchType' => 'all',
					'WholeWord' => '0',
					'RefineSearch' => 'WithinCurrent',
					'theKW' => $search_term,
				]
			];
			$response = wp_remote_post( $args );
		}
	}
	try {
		$replacements = [
			'/academics_cs/museum/images/' => '/wp-content/themes/colbymuseum/images/',
	  		'BACK TO SINGLE OBJECT VIEW' => '< Back to Single Object View',
   	  		'SINGLE OBJECT' => 'Single Object',
   	  		'THUMBNAILS' => 'Thumbnails',
   	  		'LIST VIEW' => 'List View',
   	  		'BACK TO TOP' => 'Back to Top &uarr;',
   	  		'ENLARGE/ZOOM IMAGE' => 'Enlarge/Zoom Image',
   	  		'BACKGROUND:' => 'Background:',
   	  		'ENLARGE/ZOOM IMAGE' => 'Enlarge/Zoom Image',
      		'LIGHT' => 'Light',
      		'MEDIUM' => 'Medium',
      		'DARK' => 'Dark',
      		'</a> &bull; <a' => '</a> | <a'
		];
		$response_body = str_replace( array_keys( $replacements ), array_values( $replacements ), $response['body'] );
		$response_body = str_replace( '/academics_cs/museum/search/', "?obj=", $response_body );
      	echo str_replace( 'its-embark.colby.edu', 'embark.colby.edu', $response_body );
		// If no results, automatically select the 'Museum website search results' tab.
    } catch ( Exception $ex ) {
		echo 'Unable to connect to EmbARK search server.';
    }
}

add_action( 'init', function() {
    add_shortcode( 'embark-search', function ( $atts ) {
        $cq = isset( $_GET['cq'] ) ? sanitize_text_field( $_GET['cq'] ) : '';

        if ( ! $cq ) {
            $_GET['obj'] = isset( $_GET['obj'] ) ? $_GET['obj'] : 'Prt1410';
        }

        ob_start(); ?>
        <div class=collection-container>
            <?php /* <form class=collection__search-form>
                <input
                    name=cq
                    type=text
                    placeholder="Search the collection"
                    value="<?php echo isset( $_GET['cq'] ) ? $_GET['cq'] : ''; ?>"
                    />
            </form>
            <?php if ( $cq ) : ?>
            <a class=collection__reset-link href=<?php bloginfo( 'url' ); ?>/collection>
                Reset
            </a>
            <?php endif; */ ?>

            <?php embarkSearchResults( $cq ?: 'lunder'  ); ?>
        </div>

        <?php
        $html = ob_get_clean();

        if ( $cq ) {
            $html = str_replace( '&sid=', "&cq=$cq&sid=", $html );
        }

        return preg_replace("/<script.*?\/script>/s", "", $html) ?: $html;
    } );
} );
