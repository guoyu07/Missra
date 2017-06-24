<?php
/**
 * 获取投票代码
 *
 * @version        $Id: vote_getcode.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(MIINC."/mivote.class.php");
$aid = isset($aid) && is_numeric($aid) ? $aid : 0;
include MiInclude('templets/vote_getcode.htm');