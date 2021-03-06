<?php
/**
 * 增加附件
 * 
 * @version        $Id: uploads_add.php
 * @package        Mi.Member
 * @copyright      Copyright (c) Missra, Inc.
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__).'/config.php');
CheckRank(0,0,FALSE);
require_once(MIMEMBER.'/inc/inc_archives_functions.php');
if(empty($dopost)) $dopost = '';
if(empty($mediatype)) $mediatype = 1;
$menutype = 'content';
if($dopost=='')
{
    include(MIMEMBER."/templets/uploads_add.htm");
}
else if($dopost=='save')
{
    $cfg_ml->CheckUserSpace();
    if($mediatype==1)
    {
        $utype = 'image';
    }
    else if($mediatype==2)
    {
        $utype = 'flash';
    }
    else if($mediatype==3)
    {
        $utype = 'media';
    }
    else
    {
        $utype = 'addon';
    }
    $title = HtmlReplace($title,2);
    $filename = MemberUploads('addonfile','',$cfg_ml->M_ID,$utype,'',-1,-1,true);
    SaveUploadInfo($title,$filename,$mediatype);
    $bkurl = "uploads_select.php?f=".$f."&mediatype=".$mediatype."&keyword=".urlencode($keyword)."&filename=".$filename;
    if($filename=='')
    {
        ShowMsg("上传文件失败！","-1");
    }
    else
    {
        ShowMsg("成功上传一个文件！",$bkurl);
    }
}