<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: php.php 66676 2018-06-16 16:02:39Z chibaguy $

/**
 * Note this file is redundant in Tiki 11 and 12 (php 5.3 required)
 * extensions are now being checked using the extensions array in the pref definition
 * TODO remove in Tiki 13
 */


function prefs_php_list()
{
	return [
		'php_libxml' => [
			'name' => tra('PHP libxml extension'),
			'description' => tra(
				'This extension requires the libxml PHP extension.
				This means that passing in --enable-libxml is also required, although this is
				implicitly accomplished because libxml is enabled by default.'
			),
			'type' => 'flag',
			'default' => class_exists('DOMDocument') ? 'y' : 'n',
		],
		'php_datetime' => [
			'name' => tra('PHP DateTime'),
			'description' => tra(
				'DateTime class (and related functions) are enabled
				by default since PHP 5.2.0.'
			),
			'type' => 'flag',
			'default' => class_exists('DateTime') ? 'y' : 'n',
		],
	];
}
