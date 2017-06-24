<?php
/**
 * 专题列表
 *
 * @version        $Id: content_s_list.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('spec_List');
$s_tmplets = "templets/content_s_list.htm";
$channelid = -1;
include(dirname(__FILE__)."/content_list.php");