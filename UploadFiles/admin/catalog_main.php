<?php
/**
 * 栏目管理
 *
 * @version        $Id: catalog_main.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(MIINC."/typeunit.class.admin.php");
$userChannel = $cuserLogin->getUserChannel();
include MiInclude('templets/catalog_main.htm');