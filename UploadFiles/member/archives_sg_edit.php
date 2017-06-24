<?php
/**
 * 单表模型编辑器
 * 
 * @version        $Id: archives_sg_add.php
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
    $arcQuery = "SELECT ch.*,arc.* FROM `#@__arctiny` arc
    LEFT JOIN `#@__channeltype` ch ON ch.id=arc.channel WHERE arc.id='$aid' ";
    $cInfos = $dsql->GetOne($arcQuery);
    if(!is_array($cInfos))
    {
        ShowMsg("读取文档信息出错!","-1");
        exit();
    }
    $addRow = $dsql->GetOne("SELECT * FROM `{$cInfos['addtable']}` WHERE aid='$aid'; ");
    if($addRow['mid']!=$cfg_ml->M_ID)
    {
        ShowMsg("对不起，你没权限操作此文档！","-1");
        exit();
    }
    $addRow['id'] = $addRow['aid'];
    include(MIMEMBER."/templets/archives_sg_edit.htm");
    exit();
}

/*------------------------------
function _SaveArticle(){  }
------------------------------*/
else if($dopost=='save')
{

    require_once(MIINC."/image.func.php");
    require_once(MIINC."/oxwindow.class.php");
    $flag = '';
    $typeid = isset($typeid) && is_numeric($typeid) ? $typeid : 0;
    $userip = GetIP();
    
    $svali = GetCkVdValue();
    if(preg_match("/3/",$safe_gdopen)){
        if(strtolower($vdcode)!=$svali || $svali=='')
        {
            ResetVdValue();
            ShowMsg('验证码错误！', '-1');
            exit();
        }
    }

    if($typeid==0)
    {
        ShowMsg('请指定文档隶属的栏目！','-1');
        exit();
    }
    $query = "SELECT tp.ispart,tp.channeltype,tp.issend,ch.issend AS cissend,ch.sendrank,ch.arcsta,ch.addtable,ch.fieldset,ch.usertype
         FROM `#@__arctype` tp LEFT JOIN `#@__channeltype` ch ON ch.id=tp.channeltype WHERE tp.id='$typeid' ";
    $cInfos = $dsql->GetOne($query);
    $addtable = $cInfos['addtable'];

    //检测栏目是否有投稿权限
    if($cInfos['issend']!=1 || $cInfos['ispart']!=0|| $cInfos['channeltype']!=$channelid || $cInfos['cissend']!=1)
    {
        ShowMsg("你所选择的栏目不支持投稿！","-1");
        exit();
    }

    //文档的默认状态
    if($cInfos['arcsta']==0)
    {
        $arcrank = 0;
    }
    else if($cInfos['arcsta']==1)
    {
        $arcrank = 0;
    }
    else
    {
        $arcrank = -1;
    }

    //对保存的内容进行处理
    $title = cn_substrR(HtmlReplace($title, 1), $cfg_title_maxlen);
    $mid = $cfg_ml->M_ID;

    //处理上传的缩略图
    $litpic = MemberUploads('litpic', $oldlitpic, $mid, 'image', '', $cfg_ddimg_width, $cfg_ddimg_height, FALSE);
    if($litpic!='') SaveUploadInfo($title, $litpic, 1);
    else $litpic =$oldlitpic;

    //分析处理附加表数据
    $inadd_f = $inadd_m = '';
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

                //自动摘要和远程图片本地化
                if($vs[1]=='htmltext'||$vs[1]=='textdata')
                {
                    ${$vs[0]} = AnalyseHtmlBody(${$vs[0]},$description,$vs[1]);
                }

                ${$vs[0]} = GetFieldValueA(${$vs[0]},$vs[1],$aid);

                $inadd_f .= ',`'.$vs[0]."` ='".${$vs[0]}."' ";
                $inadd_m .= ','.$vs[0];
            }
        }
        if (empty($idhash) || $idhash != md5($aid.$cfg_cookie_encode))
        {
            showMsg('数据校验不对，程序返回', '-1');
            exit();
        }
        
        // 这里对前台提交的附加数据进行一次校验
        $fontiterm = PrintAutoFieldsAdd($cInfos['fieldset'],'autofield', FALSE);
        if ($fontiterm != $inadd_m)
        {
            ShowMsg("提交表单同系统配置不相符,请重新提交！", "-1");
            exit();
        }
    }

    if($addtable!='')
    {
        $upQuery = "UPDATE `$addtable` SET `title`='$title',`typeid`='$typeid',`arcrank`='$arcrank',litpic='$litpic',userip='$userip'{$inadd_f} WHERE aid='$aid' ";
        if(!$dsql->ExecuteNoneQuery($upQuery))
        {
            ShowMsg("更新附加表 `$addtable`  时出错，请联系管理员！","javascript:;");
            exit();
        }
    }
    
    UpIndexKey($aid,0,$typeid,$sortrank,'');
    $artUrl = MakeArt($aid,true);
    
    if($artUrl=='') $artUrl = $cfg_phpurl."/view.php?aid=$aid";

    //返回成功信息
    $msg = "　　请选择你的后续操作：
        <a href='archives_sg_add.php?cid=$typeid'>发布新内容</a>
        &nbsp;&nbsp;
        <a href='archives_do.php?channelid=$channelid&aid=".$aid."&dopost=edit'>返回更改</a>
        &nbsp;&nbsp;
        <a href='$artUrl' target='_blank'>查看内容</a>
        &nbsp;&nbsp;
        <a href='content_sg_list.php?channelid=$channelid'>管理内容</a>
        ";
    $wintitle = "成功更改内容！";
    $wecome_info = "内容管理::更改内容";
    $win = new OxWindow();
    $win->AddTitle("成功更改内容：");
    $win->AddMsgItem($msg);
    $winform = $win->GetWindow("hand","&nbsp;",false);
    $win->Display();
}