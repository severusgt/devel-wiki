<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: Equals.php 64622 2017-11-18 19:34:07Z rjsmelo $

class Math_Formula_Function_Equals extends Math_Formula_Function
{
	function evaluate($element)
	{
		// Multiple components will all need to be equal.

		$out = [];

		$reference = $this->evaluateChild($element[0]);

		foreach ($element as $child) {
			$component = $this->evaluateChild($child);
			if ($component != $reference) {
				return false;
			}
		}

		return true;
	}
}
