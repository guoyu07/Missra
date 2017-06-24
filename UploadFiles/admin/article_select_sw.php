<?php
/**
 * @version        $Id: article_select_sw.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require(dirname(__FILE__)."/config.php");
header("Pragma:no-cache");
header("Cache-Control:no-cache");
header("Expires:0");

//来源列表
if($t=='source')
{
    $m_file = MIDATA."/admin/source.txt";
    $allsources = file($m_file);
    echo "<div class='coolbg'>[<a href=\"javascript:OpenMyWin('article_source_edit.php');ClearDivCt('mysource');\">设置</a>]&nbsp;";
    echo "[<a href='#' onclick='javascript:HideObj(\"mysource\");ChangeFullDiv(\"hide\");'>关闭</a>]</div>\r\n<div class='wsselect'>\r\n";
    foreach($allsources as $v)
    {
        $v = trim($v);
        if($v!="")
        {
            echo "<a href='#' onclick='javascript:PutSource(\"$v\")'>$v</a> | \r\n";
        }
    }
    echo "</div><div class='coolbg'>&nbsp;</div>";
}
else
{
    //作者列表
    $m_file = MIDATA."/admin/writer.txt";
    echo "<div class='coolbg'>[<a href=\"javascript:OpenMyWin('article_writer_edit.php');ClearDivCt('mywriter');\">设置</a>]&nbsp;";
    echo "[<a href='#' onclick='javascript:HideObj(\"mywriter\");ChangeFullDiv(\"hide\");'>关闭</a>]</div>\r\n<div class='wsselect'>\r\n";
    if(filesize($m_file)>0)
    {
        $fp = fopen($m_file,'r');
        $str = fread($fp,filesize($m_file));
        fclose($fp);
        $strs = explode(',',$str);
        foreach($strs as $str)
        {
            $str = trim($str);
            if($str!="")
            {
                echo "<a href='#' onclick='javascript:PutWriter(\"$str\")'>$str</a> | ";
            }
        }
    }
    echo "</div><div class='coolbg'>&nbsp;</div>\r\n";
}