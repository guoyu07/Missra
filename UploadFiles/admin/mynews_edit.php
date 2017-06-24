<?php
/**
 * 站内新闻管理
 *
 * @version        $Id: mynews_edit.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('plus_站内新闻发布');
if(empty($dopost)) $dopost = "";

$aid = preg_replace("#[^0-9]#", "", $aid);
if($dopost=="del")
{
    $dsql->ExecuteNoneQuery("DELETE FROM #@__mynews WHERE aid='$aid';");
    ShowMsg("成功删除一条站内新闻！","mynews_main.php");
    exit();
}
else if($dopost=="editsave")
{
    $inquery = "UPDATE #@__mynews SET title='$title',typeid='$typeid',writer='$writer',senddate='".GetMKTime($sdate)."',body='$body' WHERE aid='$aid';";
    $dsql->ExecuteNoneQuery($inquery);
    ShowMsg("成功更改一条站内新闻！","mynews_main.php");
    exit();
}
$myNews = $dsql->GetOne("SELECT #@__mynews.*,#@__arctype.typename FROM #@__mynews LEFT JOIN #@__arctype ON #@__arctype.id=#@__mynews.typeid WHERE #@__mynews.aid='$aid';");
include MiInclude('templets/mynews_edit.htm');