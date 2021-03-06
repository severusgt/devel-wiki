<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: tikisession-pdo.php 64633 2017-11-19 12:25:47Z rjsmelo $

/* from
		http://www.spiration.co.uk/post/1333/PHP 5 sessions in mysql database with PDO db objects
*/

/**
 *
 */
class Session
{
	public $db;

	public function __destruct()
	{
		session_write_close();
	}

	/**
	 * @param $path
	 * @param $name
	 * @return bool
	 */
	public function open($path, $name)
	{
		return true;
	}

	/**
	 * @return bool
	 */
	public function close()
	{
		return true;
	}

	/**
	 * @param $sesskey
	 * @return mixed
	 */
	public function read($sesskey)
	{
		global $prefs;

		$bindvars = [ $sesskey ];

		if ($prefs['session_lifetime'] > 0) {
			$qry = 'select data from sessions where sesskey = ? and expiry > ?';
			$bindvars[] = $prefs['session_lifetime'];
		} else {
			$qry = 'select data from sessions where sesskey = ?';
		}

		return TikiDb::get()->getOne($qry, $bindvars);
	}

	/**
	 * @param $sesskey
	 * @param $data
	 * @return bool
	 */
	public function write($sesskey, $data)
	{
		global $prefs;

		$expiry = time() + ( $prefs['session_lifetime'] * 60 );

		TikiDb::get()->query('delete from sessions where sesskey = ?', [ $sesskey ]);
		TikiDb::get()->query('insert into sessions (sesskey, data, expiry) values( ?, ?, ? )', [ $sesskey, $data, $expiry ]);

		return true;
	}

	/**
	 * @param $sesskey
	 * @return bool
	 */
	public function destroy($sesskey)
	{
		$qry = 'delete from sessions where sesskey = ?';
		TikiDb::get()->query($qry, [ $sesskey ]);
		return true;
	}

	/**
	 * @param $maxlifetime
	 * @return bool
	 */
	public function gc($maxlifetime)
	{
		global $prefs;

		if ($prefs['session_lifetime'] > 0) {
			$qry = 'delete from sessions where expiry < ?';
			TikiDb::get()->query($qry, [ time() ]);
		}

		return true;
	}
}

$session = new Session;
ini_set('session.save_handler', 'user');
session_set_save_handler(
	[$session, 'open'],
	[$session, 'close'],
	[$session, 'read'],
	[$session, 'write'],
	[$session, 'destroy'],
	[$session, 'gc']
);
