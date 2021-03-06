<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: wikiplugin_sub.php 66915 2018-07-08 14:41:44Z chibaguy $

function wikiplugin_sub_info()
{
	return [
		'name' => tra('Subscript'),
		'documentation' => 'PluginSub',
		'description' => tra('Create subscript text.'),
		'prefs' => [ 'wikiplugin_sub' ],
		'body' => tra('text'),
		'iconname' => 'subscript',
		'introduced' => 1,
		'tags' => [ 'basic' ],
		'params' => [
		],
	];
}

function wikiplugin_sub($data, $params)
{
	return "<sub>$data</sub>";
}
