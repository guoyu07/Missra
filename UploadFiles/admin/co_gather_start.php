<?php
/**
 * 采集指定节点
 *
 * @version        $Id: co_gather_start.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(MIINC."/micollection.class.php");
if(!empty($nid))
{
    $ntitle = '采集指定节点：';
    $nid = intval($nid);
    $co = new MiCollection();
    $co->LoadNote($nid);
    $row = $dsql->GetOne("SELECT COUNT(aid) AS dd FROM `#@__co_htmls` WHERE nid='$nid'; ");
    if($row['dd']==0)
    {
        $unum = "没有记录或从来没有采集过这个节点！";
    }
    else
    {
        $unum = "共有 {$row['dd']} 个历史种子网址！<a href='javascript:SubmitNew();'>[<u>更新种子网址，并采集</u>]</a>";
    }
} else {
    $nid = "";
    $row['dd'] = "";
    $ntitle = '监控式采集：';
    $unum = "没指定采集节点，将使用检测新内容采集模式！";
}
include MiInclude('templets/co_gather_start.htm');