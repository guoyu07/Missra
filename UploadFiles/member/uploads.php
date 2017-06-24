<?php
/**
 * 上传
 * 
 * @version        $Id: uploads.php
 * @package        Mi.Member
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
require_once(MIINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$miNowurl,time()+3600,"/");
$menutype = 'content';
$keyword = empty($keyword) ? '' : FilterSearch($keyword);
$addsql = " where mid='".$cfg_ml->M_ID."' AND title LIKE '%$keyword%' ";
if(empty($mediatype)) $mediatype = 0;

$mediatype = intval($mediatype);
if($mediatype>0) $addsql .= " AND mediatype='$mediatype' ";

$sql = "SELECT * FROM `#@__uploads` $addsql ORDER BY aid DESC";
$dlist = new DataListCP();
$dlist->pageSize = 5;
$dlist->SetParameter("mediatype",$mediatype);
$dlist->SetParameter("keyword",$keyword);
$dlist->SetTemplate(MIMEMBER."/templets/uploads.htm");
$dlist->SetSource($sql);
$dlist->Display();

function MediaType($tid,$nurl)
{
    if($tid==1)
    {
        return "图片";
    }
    else if($tid==2)
    {
        return "FLASH";
    }
    else if($tid==3)
    {
        return "视频/音频";
    }
    else
    {
        return "附件/其它";
    }
}

function GetFileSize($fs)
{
    $fs = $fs/1024;
    return sprintf("%10.1f",$fs)." K";
}

function GetImageView($furl,$mtype)
{
    if($mtype==1)
    {
        return "<img class='litPic' width='80' height='80' src='$furl'  border='0' /><br />";
    }
}