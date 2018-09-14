<?php
// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: Templaterender.php 67018 2018-07-24 09:16:37Z jonnybradley $

class Search_Formatter_ValueFormatter_Templaterender extends Search_Formatter_ValueFormatter_Abstract
{

	function __construct($arguments)
	{
	}

	function render($name, $value, array $entry)
	{
		$output = "{OUTPUT()}$value{OUTPUT}";

		$matches = WikiParser_PluginMatcher::match($output);

		$builder = new Search_Formatter_Builder();
		$builder->apply($matches);

		$formatter = $builder->getFormatter();
		$rendered = $formatter->format([$entry]);

		return $rendered;
	}

	function canCache()
	{
		return false;
	}
}
