<?php
// $Id: block.repeat.php 64630 2017-11-19 12:11:11Z rjsmelo $

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 *
 * File: block.repeat.php
 * Type: block
 * Name: repeat
 * Purpose: repeat a template block a given number of times
 * Parameters: count [required] - number of times to repeat
 * assign [optional] - variable to collect output
 * Author: Scott Matthewman <scott@matthewman.net>
 */

//this script may only be included - so its better to die if called directly.
if (strpos($_SERVER["SCRIPT_NAME"], basename(__FILE__)) !== false) {
	header("location: index.php");
	exit;
}


function smarty_block_repeat($params, $content, $smarty, &$repeat)
{
	if ($repeat || ! empty($content)) {
		$intCount = intval($params['count']);
		if ($intCount < 0) {
			trigger_error("block: negative 'count' parameter");
			return;
		}

		$strRepeat = str_repeat($content, $intCount);
		if (! empty($params['assign'])) {
			$smarty->assign($params['assign'], $strRepeat);
		} else {
			return $strRepeat;
		}
	}
}
