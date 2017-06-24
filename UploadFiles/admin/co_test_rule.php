<?php
/**
 * 采集规则测试
 *
 * @version        $Id: co_test_rule.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(MIINC."/micollection.class.php");
$nid = intval($nid);
$co = new MiCollection();
$co->LoadNote($nid);
include MiInclude('templets/co_test_rule.htm');
exit();