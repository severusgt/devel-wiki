<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: workspace.php 66927 2018-07-09 11:28:05Z chibaguy $

function prefs_workspace_list()
{
	return [
		'workspace_ui' => [
			'name' => tr('Workspace UI'),
			'description' => tr('Combine site features to create a workspace experience for work groups.'),
			'type' => 'flag',
			'default' => 'n',
			'perspective' => false,
			'dependencies' => [
				'feature_wiki',
				'namespace_enabled',
				'feature_perspective',
				'feature_categories',
			],
		],
		'workspace_root_category' => [
			'name' => tr('Workspace root category'),
			'description' => tr('ID of the root category containing all workspaces.'),
			'type' => 'text',
			'filter' => 'int',
			'default' => 0,
			'perspective' => false,
			'warning' => tr('This value is automatically managed and should not need to be modified manually.'),
			'profile_reference' => 'category',
		],
	];
}
