<?php
/**
 * 获取missra系统提示信息
 *
 * @version        $Id: getmisysmsg.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__).'/config.php');
require_once(MIINC.'/mihttpdown.class.php');
AjaxHead();
$dhd = new MiHttpDown();
$dhd->OpenUrl('http://www.missra.com/officialinfo.html');
$str = trim($dhd->GetHtml());
$dhd->Close();
if($cfg_soft_lang=='utf-8') $str = gb2utf8($str);
echo $str;
