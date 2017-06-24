<?php
/**
 * 文档随机模板
 *
 * @version        $Id: article_template_rand.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__).'/config.php');
require_once(MIINC.'/oxwindow.class.php');
CheckPurview('sys_StringMix');
if(empty($dopost)) $dopost = '';
$templates = empty($templates) ? '' : stripslashes($templates);
$m_file = MIDATA.'/template.rand.php';

//----------------------action
$okmsg = '';
//保存配置
if($dopost=='save')
{
    $fp = fopen($m_file,'w');
    flock($fp,3);
    fwrite($fp,$templates);
    fclose($fp);
    $okmsg = '成功保存配置信息 AT:('.MyDate('H:i:s', time()).')';
}
//对旧文档进行随机模板处理
else if($dopost=='makeold')
{
    set_time_limit(3600);
    if(!file_exists($m_file))
    {
        AjaxHead();
        echo "配置文件不存在！";
        exit();
    }
    require_once($m_file);
    if($cfg_tamplate_rand==0)
    {
        AjaxHead();
        echo "系统没开启允许随机模板的选项！";
        exit();
    }
    $totalTmp = count($cfg_tamplate_arr) - 1;
    if( $totalTmp < 1 )
    {
        AjaxHead();
        echo "随机模板的数量必须为2个或以上！";
        exit();
    }
    for($i=0; $i < 10; $i++)
    {
        $temp = $cfg_tamplate_arr[mt_rand(0, $totalTmp)];
        $dsql->ExecuteNoneQuery(" Update `#@__addonarticle` set templet='$temp' where RIGHT(aid, 1)='$i' ");
    }
    AjaxHead();
    echo "全部随机操作成功！";
    exit();
}
//清除全部的指定模板
else if($dopost=='clearold')
{
    $dsql->ExecuteNoneQuery(" Update `#@__addonarticle` set templet='' ");
    $dsql->ExecuteNoneQuery(" OPTIMIZE TABLE `#@__addonarticle` ");
    AjaxHead();
    echo "全部清除操作成功！";
    exit();
}

//-------------------------read
//读出
if(empty($templates) && filesize($m_file)>0)
{
    $fp = fopen($m_file,'r');
    $templates = fread($fp,filesize($m_file));
    fclose($fp);
}
$wintitle = "随机模板防采集设置";
$wecome_info = "随机模板防采集设置";

$msg = "
<link href='css/base.css' rel='stylesheet' type='text/css' />
<script type='text/javascript' src='js/main.js'></script>
<script type='text/javascript' src='../include/js/miajax.js'></script>
<script type='text/javascript'>
function DoRand(jobname)
{
    ChangeFullDiv('show');
    \$MI('loading').style.display = 'block';
    var myajax = new MiAjax(\$MI('tmpct'));
    myajax.SendGet2('article_template_rand.php?dopost='+jobname);
    \$MI('loading').style.display = 'none';
    ChangeFullDiv('hide');
}
</script>
<div id='loading' style='z-index:3000;top:160;left:300;position:absolute;display:none;'>
    <img src='images/loadinglit.gif' /> 请稍后，正在操作中...
</div>
<table width='98%' align='center'>
<tr>
    <td height='28'>
    如果你想对旧的文章应用随机模板设置，请点击此对旧文章进行处理(必须设置好模板项)！
    &nbsp; <a href='#' onclick='DoRand(\"makeold\")'>[<u>设置全部</u>]</a>
    &nbsp; <a href='#' onclick='DoRand(\"clearold\")'>[<u>取消全部</u>]</a>
    &nbsp; <span id='tmpct' style='color:red;font-weight:bold'>$okmsg</span>
    </td>
</tr>
<tr>
    <td><b>请按说明修改设置：</b></td>
</tr>
<tr>
    <td><textarea name='templates' id='templates' style='width:100%;height:250px'>$templates</textarea></td>
</tr>
</table>";

$win = new OxWindow();
$win->Init('article_template_rand.php','js/blank.js','POST');
$win->AddHidden('dopost','save');
$win->AddTitle("本设置仅适用于系统默认的文章模型，设置后发布文章时会自动按指定的模板随机获取一个，如果不想使用此功能，把它设置为空即可！");
$win->AddMsgItem($msg);
$winform = $win->GetWindow('ok');
$win->Display();