<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: Table.php 65360 2018-01-29 11:11:01Z jonnybradley $

class Search_MySql_Table extends TikiDb_Table
{
	private $definition = false;
	private $indexes = [];
	private $exists = null;

	private $schemaBuffer;
	private $dataBuffer;

	function __construct($db, $table)
	{
		parent::__construct($db, $table);

		$table = $this->escapeIdentifier($this->tableName);
		$this->schemaBuffer = new Search_MySql_QueryBuffer($db, 2000, "ALTER TABLE $table ");
		$this->dataBuffer = new Search_MySql_QueryBuffer($db, 100, '-- '); // Null Object, replaced later
	}

	function __destruct()
	{
		try {
			$this->flush();
		} catch (Search_MySql_Exception $e) {
			# ignore this to cleanly destruct the object
		}
	}

	function drop()
	{
		$table = $this->escapeIdentifier($this->tableName);
		$this->db->query("DROP TABLE IF EXISTS $table");
		$this->definition = false;
		$this->exists = false;

		$this->emptyBuffer();
	}

	function exists()
	{
		if (is_null($this->exists)) {
			$tables = $this->db->listTables();
			$this->exists = in_array($this->tableName, $tables);
		}

		return $this->exists;
	}

	function insert(array $values, $ignore = false)
	{
		$keySet = implode(', ', array_map([$this, 'escapeIdentifier'], array_keys($values)));

		$valueSet = '(' . implode(', ', array_map([$this->db, 'qstr'], $values)) . ')';

		$this->addToBuffer($keySet, $valueSet);

		return 0;
	}

	function ensureHasField($fieldName, $type)
	{
		$this->loadDefinition();

		if (! isset($this->definition[$fieldName])) {
			$this->addField($fieldName, $type);
			$this->definition[$fieldName] = $type;
		}
	}

	function hasIndex($fieldName, $type)
	{
		$this->loadDefinition();

		$indexName = $fieldName . '_' . $type;
		return isset($this->indexes[$indexName]);
	}

	function ensureHasIndex($fieldName, $type)
	{
		global $prefs;

		$this->loadDefinition();

		if (! isset($this->definition[$fieldName]) && $prefs['search_error_missing_field'] === 'y') {
			if (preg_match('/^tracker_field_/', $fieldName)) {
				$msg = tr('Field %0 does not exist in the current index. Please check field permanent name and if you have any items in that tracker.', $fieldName);
			} else {
				$msg = tr('Field %0 does not exist in the current index. If this is a tracker field, the proper syntax is tracker_field_%0.', $fieldName, $fieldName);
			}
			throw new Search_MySql_QueryException($msg);
		}

		$indexName = $fieldName . '_' . $type;

		// Static MySQL limit on 64 indexes per table
		if (! isset($this->indexes[$indexName]) && count($this->indexes) < 64) {
			if ($type == 'fulltext') {
				$this->addFullText($fieldName);
			} elseif ($type == 'index') {
				$this->addIndex($fieldName);
			}

			$this->indexes[$indexName] = true;
		}
	}

	private function loadDefinition()
	{
		if (! empty($this->definition)) {
			return;
		}

		if (! $this->exists()) {
			$this->createTable();
			$this->loadDefinition();
		}

		$table = $this->escapeIdentifier($this->tableName);
		$result = $this->db->fetchAll("DESC $table");
		$this->definition = [];
		foreach ($result as $row) {
			$this->definition[$row['Field']] = $row['Type'];
		}

		$result = $this->db->fetchAll("SHOW INDEXES FROM $table");
		$this->indexes = [];
		foreach ($result as $row) {
			$this->indexes[$row['Key_name']] = true;
		}
	}

	private function createTable()
	{
		$table = $this->escapeIdentifier($this->tableName);
		$this->db->query(
			"CREATE TABLE IF NOT EXISTS $table (
				`id` INT NOT NULL AUTO_INCREMENT,
				`object_type` VARCHAR(15) NOT NULL,
				`object_id` VARCHAR(300) NOT NULL,
				PRIMARY KEY(`id`),
				INDEX (`object_type`, `object_id`(160))
			) ENGINE=MyISAM"
		);
		$this->exists = true;

		$this->emptyBuffer();
	}

	private function addField($fieldName, $type)
	{
		$table = $this->escapeIdentifier($this->tableName);
		$fieldName = $this->escapeIdentifier($fieldName);
		$this->schemaBuffer->push("ADD COLUMN $fieldName $type");
	}

	private function addIndex($fieldName)
	{
		$currentType = $this->definition[$fieldName];
		$alterType = null;

		$indexName = $fieldName . '_index';
		$table = $this->escapeIdentifier($this->tableName);
		$escapedIndex = $this->escapeIdentifier($indexName);
		$escapedField = $this->escapeIdentifier($fieldName);

		if ($currentType == 'TEXT' || $currentType == 'text') {
			$this->schemaBuffer->push("MODIFY COLUMN $escapedField VARCHAR(300)");
			$this->definition[$fieldName] = 'VARCHAR(300)';
		}

		$this->schemaBuffer->push("ADD INDEX $escapedIndex ($escapedField)");
	}

	private function addFullText($fieldName)
	{
		$indexName = $fieldName . '_fulltext';
		$table = $this->escapeIdentifier($this->tableName);
		$escapedIndex = $this->escapeIdentifier($indexName);
		$escapedField = $this->escapeIdentifier($fieldName);
		$this->schemaBuffer->push("ADD FULLTEXT INDEX $escapedIndex ($escapedField)");
	}

	private function emptyBuffer()
	{
		$this->schemaBuffer->clear();
		$this->dataBuffer->clear();
	}

	private function addToBuffer($keySet, $valueSet)
	{
		$this->schemaBuffer->flush();

		$this->dataBuffer->setPrefix("INSERT INTO {$this->escapeIdentifier($this->tableName)} ($keySet) VALUES ");
		$this->dataBuffer->push($valueSet);
	}

	function flush()
	{
		$this->schemaBuffer->flush();
		$this->dataBuffer->flush();
	}
}
