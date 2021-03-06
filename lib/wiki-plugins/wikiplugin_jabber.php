<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: wikiplugin_jabber.php 66915 2018-07-08 14:41:44Z chibaguy $

function wikiplugin_jabber_info()
{
	return [
		'name' => tra('Jabber'),
		'documentation' => 'PluginJabber',
		'description' => tra('Chat using the Jabber instant messaging client.'),
		'prefs' => [ 'wikiplugin_jabber' ],
		'iconname' => 'comments',
		'introduced' => 1,
		'params' => [
			'height' => [
				'required' => false,
				'name' => tra('Height'),
				'description' => tra('Applet height in pixels'),
				'since' => '1',
				'default' => 200,
				'filter' => 'digits',
			],
			'width' => [
				'required' => false,
				'name' => tra('Width'),
				'description' => tra('Applet width in pixels'),
				'since' => '1',
				'default' => 200,
				'filter' => 'digits',
			],
			'xmlhostname' => [
				'required' => false,
				'name' => tra('XML Host Name'),
				'description' => tr('Web site where XML is hosted. Default is %0jabber.org%1', '<code>', '<code>'),
				'since' => '1',
				'default' => 'jabber.org',
				'filter' => 'url',
			],
			'defaultColor' => [
				'required' => false,
				'name' => tra('Default Color'),
				'description' => tr('Set default color. Default is %0255,255,255%1', '<code>', '<code>'),
				'since' => '1',
				'default' => '255,255,255',
				'filter' => 'text',
			],
		],
	];
}

function wikiplugin_jabber($data, $params)
{
	$userlib = TikiLib::lib('user');
	global $user;
	extract($params, EXTR_SKIP);

	if (! isset($height)) {
		$height = 200;
	}
	if (! isset($width)) {
		$width = 200;
	}
	if (! isset($xmlhostname)) {
		$xmlhostname = 'jabber.org';
	}
	if (! isset($defaultColor)) {
		$defaultColor = '255,255,255';
	}

	$result = '<APPLET ARCHIVE="lib/jabber/JabberApplet.jar" CODE="org/jabber/applet/JabberApplet.class" HEIGHT=' . $height . ' WIDTH=' . $width . ' VIEWASTEXT>';
	$result .= '<param name="xmlhostname" value="' . $xmlhostname . '">';
	$result .= '<param name="defaultColor" value="' . $defaultColor . '">';
	if (isset($user)) {
		$result .= '<param name="user" value="' . $user . '">';
	}
	$result .= '</APPLET>';
	return $result;
}
