<?php

class Embark_Refresher {
	public $rec = 1;
	public $page_content = 'Next</a>';
	public $handled_objects = [];

	public function __construct() {
		if ( isset( $_GET['refresh_embark'] ) ) {
			$this->run();
		}
	}

	public function run() {
		while ( strpos( $this->page_content, 'Next</a>' ) !== false ) {
			$this->fetch_page();
			$this->rec += 9;
		}

	}

	public function fetch_page() {
		$response = wp_remote_get( "http://embark.colby.edu//PRT1410?rec={$this->rec}" );
		$this->page_content = $response['body'];

		if ( strpos( $this->page_content, 'Next</a>' ) === false ) {
			return $this->page_content = '';
		}

		// Break page_content into array of items starting with Object number.
		$list_items = explode( 'href="/academics_cs/museum/search/', $this->page_content );
		$list_items = array_slice( $list_items, 1 );

		foreach ( $list_items as $key => $list_item ) {
			$this->handle_item( $list_item );
		}
	}

	public function handle_item( $item ) {
		$object_number = strtolower( substr( $item, 0, strpos( $item, '?' ) ) );

		if ( strpos( $object_number, 'obj' ) === false ) {
			return;
		}

		if ( in_array( $object_number, $this->handled_objects, true ) ) {
			return;
		}

		$this->handled_objects[] = $object_number;

		if ( $this->item_exists( $object_number ) === true ) {
			return;
		}

		$response = wp_remote_get( "http://embark.colby.edu/{$object_number}" );

		if ( $response || $response['body'] ) {
			$this->build_post_from_content( $object_number, $response['body'] );
		}

	}

	public function item_exists( $object_number ) {
		if ( get_page_by_path( $object_number, OBJECT, 'collection' ) ) {
			return true;
		}

		return false;
	}

	public function build_post_from_content( $object_number, $body ) {
		$description = substr( $body, strpos( $body, '<div class="coll_right_half">') );
		$description = substr( $description, 0, strpos( $description, '<p class="coll_notes' ) );

		$description_parts = explode( '<!-- {if([Objects_1]Century!="")}{[Objects_1]Century}<br/>{end if} -->', $description );
		$title = wp_strip_all_tags( str_replace( ['<br/>', ' <br/>', '<br />', ' </br />'], ', ', $description_parts[0] ), true );
		$title = str_replace( ' ,', ',', $title );
		$title = substr( $title, 0, -1 );

		$description = $description_parts[1];
		$description = preg_replace('/\t+/', '', wp_strip_all_tags( $description ) );

		$image_url = substr( $body, strpos( $body, 'img src="') + 9 );
		$image_url = $image_url ? substr( $image_url, 0, strpos( $image_url, '"' ) ) : '';

		$id = wp_insert_post( [
			'post_type' => 'collection',
			'post_title' => $title,
			'post_status' => 'publish',
			'post_content' => $description,
			'post_name' => $object_number,
			'meta_input' => [
				'image_url' => $image_url,
			]

		] );

	}}
