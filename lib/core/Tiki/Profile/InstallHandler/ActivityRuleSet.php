<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: ActivityRuleSet.php 64622 2017-11-18 19:34:07Z rjsmelo $

class Tiki_Profile_InstallHandler_ActivityRuleSet extends Tiki_Profile_InstallHandler
{
	private $rules = [];

	function fetchData()
	{
		$data = $this->obj->getData();

		if (isset($data['rules']) && is_array($data['rules'])) {
			$this->rules = $data['rules'];
		}
	}

	function canInstall()
	{
		$this->fetchData();

		return true;
	}

	function _install()
	{
		$this->fetchData();
		$this->replaceReferences($this->rules);

		$activitylib = TikiLib::lib('activity');
		$activitylib->preserveRules($this->rules);

		return true;
	}

	public static function export($writer)
	{
		$activitylib = TikiLib::lib('activity');
		$rules = $activitylib->getRules();

		$ids = [];
		foreach ($rules as $rule) {
			if (Tiki_Profile_InstallHandler_ActivityStreamRule::export($writer, $rule)) {
				$ids[] = $rule['ruleId'];
			}
		}

		$writer->addObject(
			'activity_rule_set',
			'set',
			[
				'rules' => array_map(function ($id) use ($writer) {
					return $writer->getReference('activity_stream_rule', $id);
				}, $ids),
			]
		);

		return true;
	}
}
