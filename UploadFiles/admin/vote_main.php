<?php
/**
 * 投票管理
 *
 * @version        $Id: vote_main.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(MIINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$miNowurl,time()+3600,"/");
$sql = "SELECT aid,votename,starttime,endtime,totalcount,isenable FROM #@__vote ORDER BY aid DESC";
$dlist = new DataListCP();
$issel = isset($issel) ? $issel : 0;
$aid = isset($aid) ? $aid : 0;
if($issel == 1)
{
    $dlist->SetParameter('issel',$issel);
    $dlist->SetTemplet(MIADMIN."/templets/vote_select.htm");
} else {
    $dlist->SetTemplet(MIADMIN."/templets/vote_main.htm");
}
$dlist->SetSource($sql);
$dlist->display();