<?php
/**
 * 栏目菜单
 *
 * @version        $Id: catalog_menu.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(MIINC."/typeunit.class.menu.php");
$userChannel = $cuserLogin->getUserChannel();
if(empty($opendir)) $opendir=-1;
if($userChannel>0) $opendir=$userChannel;

include MiInclude('templets/catalog_menu.htm');

// if($cuserLogin->adminStyle=='missra') {
//     include MiInclude('templets/catalog_menu.htm');
//     exit();
// } else {
//     include MiInclude('templets/catalog_menu2.htm');
//     exit();
// }