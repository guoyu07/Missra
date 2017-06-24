<?php
/**
 * 管理一个模板
 *
 * @version        $Id: templets_one.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('temp_One');
require_once(MIINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$miNowurl,time()+3600,"/");

$addquery = '';
$keyword = (!isset($keyword) ? '' : $keyword);
$likeid = (!isset($likeid) ? '' : $likeid);
$addq = $likeid!='' ? " AND likeid LIKE '$likeid' " : '';
$sql = "SELECT aid,title,ismake,uptime,filename,likeid FROM `#@__sgpage` WHERE title LIKE '%$keyword%' $addq ORDER BY aid DESC";
$dlist = new DataListCP();
$dlist->SetTemplet(MIADMIN."/templets/templets_one.htm");
$dlist->SetSource($sql);
$dlist->display();

function GetIsMake($im)
{
    return $im==1 ? '需编译' : '不编译';
}