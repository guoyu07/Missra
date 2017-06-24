<?php
/**
 * 标签测试
 *
 * @version        $Id: tag_test.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('temp_Other');
require_once(MIINC."/typelink.class.php");
include MiInclude('templets/tag_test.htm');