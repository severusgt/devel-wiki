<?php
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: rebuildgrammar.php 64632 2017-11-19 12:22:53Z rjsmelo $

//include ("common.inc");

include("htmlgrammarparser.inc");
$p = new HtmlGrammarParser("htmlgrammar.dat");
$p->Parse();
$p->PrintErrors();
$p->SaveGrammar("htmlgrammar.cmp");
print "Done.";
//PrintArray($p->pg);
