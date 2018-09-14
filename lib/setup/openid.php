<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: openid.php 64633 2017-11-19 12:25:47Z rjsmelo $

if (basename($_SERVER['SCRIPT_NAME']) === basename(__FILE__)) {
	die('This script may only be included.');
}

// OpenID support
if (isset($_SESSION['openid_userlist']) && isset($_SESSION['openid_url'])) {
	$smarty->assign('openid_url', $_SESSION['openid_url']);
	$smarty->assign('openid_userlist', $_SESSION['openid_userlist']);
} else {
	$smarty->assign('openid_url', '');
	$smarty->assign('openid_userlist', []);
}
