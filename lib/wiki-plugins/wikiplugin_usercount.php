<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: wikiplugin_usercount.php 66927 2018-07-09 11:28:05Z chibaguy $

function wikiplugin_usercount_info()
{
	return [
		'name' => tra('User Count'),
		'documentation' => 'PluginUserCount',
		'description' => tra('Display the number of users of the Tiki site or of one or more user groups.'),
		'prefs' => [ 'wikiplugin_usercount' ],
		'body' => tra('Group name. If left blank, the total number of users for the site will be shown.'),
		'iconname' => 'group',
		'introduced' => 1,
		'params' => [
			'groups' => [
				'required' => false,
				'name' => tra('Groups'),
				'description' => tra('List of colon separated groups where a consolidated user count for multiple
					groups is needed. Users in multiple groups are counted only once. If left blank then the behaviour
					is defined by the body parameter settings.'),
				'since' => '14.1',
				'separator' => ':',
				'filter' => 'groupname',
				'default' => '',
			],
		],
	];
}

function wikiplugin_usercount($data, $params)
{
	$userlib = TikiLib::lib('user');

	extract($params, EXTR_SKIP);

	if (isset($params['groups'])) {
		$groups = $params['groups'];
		$numusers = $userlib->count_users_consolidated($groups);
	} else {
		$numusers = $userlib->count_users($data);
	}

	return $numusers;
}
