<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: Substring.php 64622 2017-11-18 19:34:07Z rjsmelo $

class Math_Formula_Function_Substring extends Math_Formula_Function
{
	function evaluate($element)
	{
		$args = [];

		foreach ($element as $child) {
			$args[] = $this->evaluateChild($child);
		}

		if (count($args) < 2) {
			$this->error('Not enough arguments');
		}

		return call_user_func_array('substr', $args);
	}
}
