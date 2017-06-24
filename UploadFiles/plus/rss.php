<?php
/**
 *
 * RSS列表页
 *
 * @version        $Id: rss.php
 * @package        Mi.Site
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(MIINC."/arc.rssview.class.php");

$tid = isset($tid) && is_numeric($tid) ? $tid : 0;
if($tid==0) die(" Request Error! ");

$rv = new RssView($tid);
$rv->Display();