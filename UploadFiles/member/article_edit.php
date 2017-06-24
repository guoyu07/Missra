<?php
/**
 * 编辑文章
 * 
 * @version        $Id: article_edit.php
 * @package        Mi.Member
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
require_once(MIINC."/mitag.class.php");
require_once(MIINC."/customfields.func.php");
require_once(MIMEMBER."/inc/inc_catalog_options.php");
require_once(MIMEMBER."/inc/inc_archives_functions.php");
$channelid = isset($channelid) && is_numeric($channelid) ? $channelid : 1;
$aid = isset($aid) && is_numeric($aid) ? $aid : 0;
$mtypesid = isset($mtypesid) && is_numeric($mtypesid) ? $mtypesid : 0;
$menutype = 'content';

/*-------------
function _ShowForm(){  }
--------------*/
if(empty($dopost))
{
    //读取归档信息
    $arcQuery = "SELECT arc.*,ch.addtable,ch.fieldset,arc.mtype as mtypeid,ch.arcsta
       FROM `#@__archives` arc LEFT JOIN `#@__channeltype` ch ON ch.id=arc.channel
       WHERE arc.id='$aid' And arc.mid='".$cfg_ml->M_ID."'; ";
    $row = $dsql->GetOne($arcQuery);
    if(!is_array($row))
    {
        ShowMsg("读取文章信息出错!","-1");
        exit();
    }
    else if($row['arcrank']>=0)
    {
        $dtime = time();
        $maxtime = $cfg_mb_editday * 24 *3600;
        if($dtime - $row['senddate'] > $maxtime)
        {
            ShowMsg("这篇文档已经锁定，你不能再修改它！","-1");
            exit();
        }
    }
    $addRow = $dsql->GetOne("SELECT * FROM `{$row['addtable']}` WHERE aid='$aid'; ");
    include(MIMEMBER."/templets/article_edit.htm");
    exit();
}

/*------------------------------
function _SaveArticle(){  }
------------------------------*/
else if($dopost=='save')
{
    include(MIMEMBER.'/inc/archives_check_edit.php');

    //分析处理附加表数据
    $inadd_f = '';
    if(!empty($mi_addonfields))
    {
        $addonfields = explode(';',$mi_addonfields);
        if(is_array($addonfields))
        {
            foreach($addonfields as $v)
            {
                if($v=='')
                {
                    continue;
                }
                $vs = explode(',',$v);
                if(!isset(${$vs[0]}))
                {
                    ${$vs[0]} = '';
                }
                ${$vs[0]} = GetFieldValueA(${$vs[0]},$vs[1],$aid);
                $inadd_f .= ','.$vs[0]." ='".${$vs[0]}."' ";
            }
        }
        
        if (empty($mi_fieldshash) || $mi_fieldshash != md5($mi_addonfields.$cfg_cookie_encode))
        {
            showMsg('数据校验不对，程序返回', '-1');
            exit();
        }
        
        // 这里对前台提交的附加数据进行一次校验
        $fontiterm = PrintAutoFieldsAdd($cInfos['fieldset'],'autofield', FALSE);
        if ($fontiterm != $inadd_f)
        {
            ShowMsg("提交表单同系统配置不相符,请重新提交！", "-1");
            exit();
        }
    }
    
    $body = AnalyseHtmlBody($body,$description);
    $body = HtmlReplace($body,-1);

    //处理图片文档的自定义属性
    if($litpic!='') $flag = 'p';

    //更新数据库的SQL语句
    $upQuery = "UPDATE `#@__archives` SET
             ismake='$ismake',
             arcrank='$arcrank',
             typeid='$typeid',
             title='$title',
             litpic='$litpic',
             description='$description',
             mtype = '$mtypesid',
             keywords='$keywords',            
             flag='$flag'
      WHERE id='$aid' AND mid='$mid'; ";
    if(!$dsql->ExecuteNoneQuery($upQuery))
    {
        ShowMsg("把数据保存到数据库主表时出错，请联系管理员！".$dsql->GetError(),"-1");
        exit();
    }
    if($addtable!='')
    {
        $upQuery = "UPDATE `$addtable` SET typeid='$typeid',body='$body'{$inadd_f},userip='$userip' WHERE aid='$aid' ";
        if(!$dsql->ExecuteNoneQuery($upQuery))
        {
            ShowMsg("更新附加表 `$addtable`  时出错，请联系管理员！","javascript:;");
            exit();
        }
    }
    UpIndexKey($aid, $arcrank, $typeid, $sortrank, $tags);
    $artUrl = MakeArt($aid,true);
    if($artUrl=='')
    {
        $artUrl = $cfg_phpurl."/view.php?aid=$aid";
    }

    //返回成功信息
    $msg = "　　请选择你的后续操作：
        <a href='article_add.php?cid=$typeid'>发布新文章</a>
        &nbsp;&nbsp;
        <a href='archives_do.php?channelid=$channelid&aid=".$aid."&dopost=edit'>返回更改</a>
        &nbsp;&nbsp;
        <a href='$artUrl' target='_blank'>查看文章</a>
        &nbsp;&nbsp;
        <a href='content_list.php?channelid=$channelid'>管理文章</a>
        ";
    $wintitle = "成功更改文章！";
    $wecome_info = "文章管理::更改文章";
    $win = new OxWindow();
    $win->AddTitle("成功更改文章：");
    $win->AddMsgItem($msg);
    $winform = $win->GetWindow("hand","&nbsp;",false);
    $win->Display();
}