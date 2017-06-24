<?php
/**
 * 管理后台首页
 *
 * @version        $Id: index.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra, Inc.
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(MIINC.'/mitag.class.php');
$defaultIcoFile = MIDATA.'/admin/quickmenu.txt';
$myIcoFile = MIDATA.'/admin/quickmenu-'.$cuserLogin->getUserID().'.txt';

if(!file_exists($myIcoFile)) $myIcoFile = $defaultIcoFile;

require(MIADMIN.'/inc/inc_menu_map.php');
include(MIADMIN.'/templets/index.htm');
exit();

