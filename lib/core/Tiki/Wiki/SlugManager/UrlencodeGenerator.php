<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: UrlencodeGenerator.php 65406 2018-02-01 12:29:14Z jonnybradley $

namespace Tiki\Wiki\SlugManager;

class UrlencodeGenerator implements Generator
{
	function getName()
	{
		return 'urlencode';
	}

	function getLabel()
	{
		return tr('URL Encode (Tiki Classic)');
	}

	function generate($pageName, $suffix = null)
	{
		return urlencode($pageName) . $suffix;
	}

	function degenerate($slug)
	{
		return urldecode($slug);
	}
}
