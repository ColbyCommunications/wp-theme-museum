<?php

use PHPUnit\Framework\TestCase;
use ColbyComms\SVG\SVG;

/**
 * @covers SVG
 */
class SVGTest extends TestCase {
	public function test_filename_is_sanitized() {
		$this->assertEquals( SVG::sanitize( 'facebook' ), 'facebook' );
		$this->assertEquals( SVG::sanitize( 'twitter.svg' ), 'twitter' );
		$this->assertEquals( SVG::sanitize( ' hamburger.svg ' ), 'hamburger' );
		$this->assertEquals( SVG::sanitize( ' facebook' ), 'facebook' );
	}

	public function test_gets_path_from_filename() {
		$this->assertEquals(
			SVG::get_filename( 'facebook' ),
			dirname( __DIR__ ) . '/svg/facebook.svg'
		);
	}

	public function test_nonexistent_filepath_is_empty_string() {
		$this->assertEquals(
			SVG::get_filename( 'nonexistent-file' ),
			''
		);
	}

	public function test_svg_contents_are_retrieved() {
		$this->assertEquals(
			SVG::get( 'hamburger' ),
			'<svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 418.26 291.34" class="menu-icon-svg">
	<title>Menu</title>
	<rect fill="currentColor" width="418.26" height="26.75"/>
	<rect fill="currentColor" y="132.29" width="418.26" height="26.75"/>
	<rect fill="currentColor" y="264.59" width="418.26" height="26.75"/>
</svg>
'
		);
	}

	public function test_svg_contents_are_echoed() {
		ob_start();

		SVG::show( 'hamburger' );

		$this->assertEquals(
			ob_get_clean(),
			'<svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 418.26 291.34" class="menu-icon-svg">
	<title>Menu</title>
	<rect fill="currentColor" width="418.26" height="26.75"/>
	<rect fill="currentColor" y="132.29" width="418.26" height="26.75"/>
	<rect fill="currentColor" y="264.59" width="418.26" height="26.75"/>
</svg>
'
		);
	}
}
