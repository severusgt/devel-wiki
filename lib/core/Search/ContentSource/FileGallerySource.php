<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: FileGallerySource.php 64622 2017-11-18 19:34:07Z rjsmelo $

class Search_ContentSource_FileGallerySource implements Search_ContentSource_Interface
{
	private $db;

	function __construct()
	{
		$this->db = TikiDb::get();
	}

	function getDocuments()
	{
		return $this->db->table('tiki_file_galleries')->fetchColumn('galleryId', []);
	}

	function getDocument($objectId, Search_Type_Factory_Interface $typeFactory)
	{
		$lib = TikiLib::lib('filegal');

		$item = $lib->get_file_gallery_info($objectId);

		if (! $item) {
			return false;
		}

		$data = [
			'title' => $typeFactory->sortable($item['name']),
			'creation_date' => $typeFactory->timestamp($item['created']),
			'modification_date' => $typeFactory->timestamp($item['lastModif']),
			'description' => $typeFactory->plaintext($item['description']),
			'language' => $typeFactory->identifier('unknown'),

			'gallery_id' => $typeFactory->identifier($item['parentId']),

			'view_permission' => $typeFactory->identifier('tiki_p_view_file_gallery'),
		];

		return $data;
	}

	function getProvidedFields()
	{
		return [
			'title',
			'description',
			'language',
			'creation_date',
			'modification_date',

			'gallery_id',

			'searchable',

			'view_permission',
		];
	}

	function getGlobalFields()
	{
		return [
			'title' => true,
			'description' => true,
		];
	}
}
