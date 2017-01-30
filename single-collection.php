<?php

global $post;

$url = get_bloginfo( 'url' ) . '/collection/?obj='. $post->post_name . '?port=1410';

wp_redirect( $url );
