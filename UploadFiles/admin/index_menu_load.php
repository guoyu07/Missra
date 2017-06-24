<?php
/**
 * 载入菜单
 *
 * @version        $Id: index_menu_load.php
 * @package        Missra.Administrator
 * @copyright      Copyright (c)  2010, Missra.
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__).'/config.php');
AjaxHead();
if($openitem != 100) {
    require(dirname(__FILE__).'/inc/inc_menu.php');
    require(MIADMIN.'/inc/inc_menu_func.php');
    GetMenus($cuserLogin->getUserRank(),'main');
    exit();
} else {
    $openitem = 0;
    require(dirname(__FILE__).'/inc/inc_menu_module.php');
    require(MIADMIN.'/inc/inc_menu_func.php');
    GetMenus($cuserLogin->getUserRank(),'module');
    exit();
}