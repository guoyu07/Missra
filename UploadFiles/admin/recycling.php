<?php
/**
 * 回收站
 *
 * @version        $Id: recycling.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__).'/config.php');
CheckPurview('a_List,a_AccList,a_MyList');
require_once(MIINC.'/datalistcp.class.php');
if(empty($cid))
{
    $cid = '0';
    $whereSql = '';
}
if($cid!=0)
{
    require_once(MIINC.'/channelunit.func.php');
    $whereSql = " AND arc.typeid IN (".GetSonIds($cid).")";
}
$query = "SELECT arc.*,tp.typename FROM `#@__archives` AS arc
LEFT JOIN #@__arctype AS tp ON arc.typeid = tp.id
WHERE arc.arcrank = '-2' $whereSql order by arc.id desc";
$dlist = new DataListCP();
$dlist->SetTemplet(MIADMIN."/templets/recycling.htm");
$dlist->SetSource($query);
$dlist->display();