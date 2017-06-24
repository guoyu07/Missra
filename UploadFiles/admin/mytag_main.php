<?php
/**
 * 自定义模型管理
 *
 * @version        $Id: mychannel_main.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__).'/config.php');
CheckPurview('temp_Other');
require_once(MIINC.'/datalistcp.class.php');
setcookie("ENV_GOBACK_URL",$miNowurl,time()+3600,'/');

$sql = "SELECT myt.aid,myt.tagname,tp.typename,myt.timeset,myt.endtime
        FROM `#@__mytag` myt LEFT JOIN `#@__arctype` tp ON tp.id=myt.typeid ORDER BY myt.aid DESC ";
$dlist = new DataListCP();
$dlist->SetTemplet(MIADMIN.'/templets/mytag_main.htm');
$dlist->SetSource($sql);
$dlist->display();

function TestType($tname)
{
    return $tname=='' ? '所有栏目' : $tname;
}

function TimeSetValue($ts)
{
    return $ts==0 ? '不限时间' : '限时标记';
}