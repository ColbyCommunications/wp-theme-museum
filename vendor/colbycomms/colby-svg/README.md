# colby-svg

A library of SVGs used across projects, with a PHP class for loading and echoing
them, plus a shortcode for use in WordPress themes.

## Install

Install the package into your PHP project or WordPress theme:

```
composer require colbycomms/colby-svg
```

## Usage

Ensure `vendor/autoload.php` is included in your project. This makes the
`ColbyComms\SVG\SVG` class available via autoloading.

### ColbyComms\SVG\SVG::get( string $name = '' ) : string

Retrieves an SVG as a string (or an empty string if the file is not found).

```php
<?php

use ColbyComms\SVG\SVG;

$colby_logo = SVG::get( 'colby-logo' ); // Gets the contents of colby-logo.svg as a string.
```

### ColbyComms\SVG\SVG::show( string $name = '' )

Echoes an SVG to the output buffer (or echoes an empty string if the file is not
found.).

```php
<?php

use ColbyComms\SVG\SVG;

SVG::show( 'colby-logo' ); // Echoes colby-logo.svg.
```

## Available SVGs.

The current list of available SVGs can be viewed in this repository's
[/svg directory](https://github.com/ColbyCommunications/colby-svg/tree/master/svg).

## Shortcode

A shortcode, `[colby-svg]`, is available in WordPress projects that include this
package. It accepts a single attribute, `name`, corresponding to the SVG
filename.

```
[colby-svg name="colby-logo"] <!-- Outputs colby-logo.svg -->
```
