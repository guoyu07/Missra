<?php
/**
 * 自定义标记修改
 *
 * @version        $Id: mytag_edit.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require(dirname(__FILE__)."/config.php");
CheckPurview('temp_Other');
require_once(MIINC."/typelink.class.php");

if(empty($dopost)) $dopost = '';
$aid = intval($aid);
$ENV_GOBACK_URL = empty($_COOKIE['ENV_GOBACK_URL']) ? 'mytag_main.php' : $_COOKIE['ENV_GOBACK_URL'];

if($dopost=='delete')
{
    $dsql->ExecuteNoneQuery("DELETE FROM #@__mytag WHERE aid='$aid'");
    ShowMsg("成功删除一个自定义标记！",$ENV_GOBACK_URL);
    exit();
}
else if($dopost=="saveedit")
{
    $starttime = GetMkTime($starttime);
    $endtime = GetMkTime($endtime);
    $query = "UPDATE `#@__mytag`
     SET
     typeid='$typeid',
     timeset='$timeset',
     starttime='$starttime',
     endtime='$endtime',
     normbody='$normbody',
     expbody='$expbody'
     WHERE aid='$aid' ";
    $dsql->ExecuteNoneQuery($query);
    ShowMsg("成功更改一个自定义标记！",$ENV_GOBACK_URL);
    exit();
}
else if($dopost=="getjs")
{
    require_once(MIINC."/oxwindow.class.php");
    $jscode = "<script src='{$cfg_phpurl}/mytag_js.php?aid=$aid' type='text/javascript'></script>";
    $showhtml = "<xmp style='color:#333333;background-color:#ffffff'>\r\n\r\n$jscode\r\n\r\n</xmp>";
    $showhtml .= "<b>预览：</b><iframe name='testfrm' frameborder='0' src='mytag_edit.php?aid={$aid}&dopost=testjs' id='testfrm' width='100%' height='250'></iframe>";
    $wintitle = "宏标记定义-获取JS";
    $wecome_info = "<a href='mytag_main.php'>宏标记定义</a>:获取JS";
    $win = new OxWindow();
    $win->Init();
    $win->AddTitle('以下为选定宏标记的JS调用代码：');
    $winform = $win->GetWindow('hand', $showhtml);
    $win->Display();
    exit();
}
else if($dopost=="testjs")
{
    echo "<body bgcolor='#ffffff'>";
    echo "<script src='{$cfg_phpurl}/mytag_js.php?aid=$aid&nocache=1' type='text/javascript'></script>";
    exit();
}
$row = $dsql->GetOne("SELECT * FROM `#@__mytag` WHERE aid='$aid'");
include MiInclude('templets/mytag_edit.htm');