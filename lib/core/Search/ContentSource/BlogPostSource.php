<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: BlogPostSource.php 64622 2017-11-18 19:34:07Z rjsmelo $

class Search_ContentSource_BlogPostSource implements Search_ContentSource_Interface, Tiki_Profile_Writer_ReferenceProvider
{
	private $db;

	function __construct()
	{
		$this->db = TikiDb::get();
	}

	function getReferenceMap()
	{
		return [
			'blog_id' => 'blog',
		];
	}

	function getDocuments()
	{
		return $this->db->table('tiki_blog_posts')->fetchColumn('postId', []);
	}

	function getDocument($objectId, Search_Type_Factory_Interface $typeFactory)
	{
		$bloglib = TikiLib::lib('blog');

		$post = $bloglib->get_post($objectId);

		if (! $post) {
			return false;
		}

		$data = [
			'title' => $typeFactory->sortable($post['title']),
			'language' => $typeFactory->identifier('unknown'),
			'creation_date' => $typeFactory->timestamp($post['created']),
			'modification_date' => $typeFactory->timestamp($post['created']),
			'contributors' => $typeFactory->multivalue([$post['user']]),

			'blog_id' => $typeFactory->identifier($post['blogId']),
			'blog_excerpt' => $typeFactory->wikitext($post['excerpt']),
			'blog_content' => $typeFactory->wikitext($post['data']),

			'parent_object_type' => $typeFactory->identifier('blog'),
			'parent_object_id' => $typeFactory->identifier($post['blogId']),
			'view_permission' => $typeFactory->identifier('tiki_p_read_blog'),
			'parent_view_permission' => $typeFactory->identifier('tiki_p_read_blog'),
		];

		return $data;
	}

	function getProvidedFields()
	{
		return [
			'title',
			'language',
			'creation_date',
			'modification_date',
			'contributors',

			'blog_id',
			'blog_excerpt',
			'blog_content',

			'view_permission',
			'parent_view_permission',
			'parent_object_id',
			'parent_object_type',
		];
	}

	function getGlobalFields()
	{
		return [
			'title' => true,

			'blog_excerpt' => false,
			'blog_content' => false,
		];
	}
}
