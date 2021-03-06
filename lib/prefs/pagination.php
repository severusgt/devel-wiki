<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: pagination.php 66655 2018-06-13 16:49:37Z chibaguy $

function prefs_pagination_list()
{
	return [
		'pagination_firstlast' => [
			'name' => tra("Display 'First' and 'Last' links"),
			'description' => tra('Display \'first\' and \'last\' links on pages'),
			'type' => 'flag',
			'default' => 'y',
		],
		'pagination_fastmove_links' => [
			'name' => tra('Display "fast-forward" links'),
			'description' => tra('Display "fast-forward" links (to advance 10 percent of the total number of pages) '),
			'type' => 'flag',
			'default' => 'y',
		],
		'pagination_hide_if_one_page' => [
			'name' => tra('Hide pagination when there is only one page'),
			'description' => tra('Don\'t display pagination on single pages.'),
			'type' => 'flag',
			'default' => 'y',
		],
		'pagination_icons' => [
			'name' => tra('Use Icons'),
			'description' => tra(''),
			'type' => 'flag',
			'default' => 'y',
		],
	];
}
