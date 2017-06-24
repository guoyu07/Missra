<?php
/**
 * 菜单项
 *
 * @version        $Id: index_menu.php
 * @package        Missra.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @link           http://www.missra.com
 */
require(dirname(__FILE__).'/config.php');
require(MIADMIN.'/inc/inc_menu.php');
require(MIADMIN.'/inc/inc_menu_func.php');
$openitem = (empty($openitem) ? 1 : $openitem);
include MiInclude('templets/index_menu.htm');
