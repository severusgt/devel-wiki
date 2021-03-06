<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: DashGenerator.php 65406 2018-02-01 12:29:14Z jonnybradley $

namespace Tiki\Wiki\SlugManager;

class DashGenerator implements Generator
{
	function getName()
	{
		return 'dash';
	}

	function getLabel()
	{
		return tr('Replace spaces with dashes');
	}

	function generate($pageName, $suffix = null)
	{
		$slug = preg_replace('/\s+/', '-', trim($pageName));

		if ($suffix) {
			$slug .= '-' . $suffix;
		}

		return $slug;
	}

	function degenerate($slug)
	{
		return preg_replace('/\-+/', ' ', trim($slug));
	}
}
