<?php
if(!defined('MIINC'))
{
    exit("Request Error!");
}
/**
 * 会员信息调用标签
 *
 * @version        $Id: memberlist.lib.php
 * @package        Mi.Taglib
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
 
/*>>missra>>
<name>会员信息列表</name>
<type>全局标记</type>
<for>V1.X</for>
<description>会员信息调用标签</description>
<demo>
{missra:memberlist orderby='scores' row='20'}
<a href="../member/index.php?uid={missra:field.userid /}">{missra:field.userid /}</a>
<span>{missra:field.scores /}</span>
{/missra:memberlist}
</demo>
<attributes>
    <iterm>row:调用数目</iterm> 
    <iterm>iscommend:是否为推荐会员</iterm>
    <iterm>orderby:按登陆时间排序 money 按金钱排序 scores 按积分排序</iterm>
</attributes> 
>>missra>>*/
 
//orderby = logintime(login new) or mid(register new)
function lib_memberlist(&$ctag, &$refObj)
{
    global $dsql,$sqlCt;
    $attlist="row|6,iscommend|0,orderby|logintime,signlen|50";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);

    $revalue = '';
    $innerText = trim($ctag->GetInnerText());
    if(empty($innerText)) $innerText = GetSysTemplets('memberlist.htm');

    $wheresql = ' WHERE mb.spacesta>-1 AND mb.matt<10 ';

    if($iscommend > 0) $wheresql .= " AND  mb.matt='$iscommend' ";

    $sql = "SELECT mb.*,ms.spacename,ms.sign FROM `#@__member` mb
        LEFT JOIN `#@__member_space` ms ON ms.mid = mb.mid
        $wheresql order by mb.{$orderby} DESC LIMIT 0,$row ";
    
    $ctp = new MiTagParse();
    $ctp->SetNameSpace('field','[',']');
    $ctp->LoadSource($innerText);

    $dsql->Execute('mb',$sql);
    while($row = $dsql->GetArray('mb'))
    {
        $row['spaceurl'] = $GLOBALS['cfg_basehost'].'/member/index.php?uid='.$row['userid'];
        if(empty($row['face'])){
            $row['face']=($row['sex']=='女')? $GLOBALS['cfg_memberurl'].'/templets/images/dfgirl.png' : $GLOBALS['cfg_memberurl'].'/templets/images/dfboy.png';
        }
        foreach($ctp->CTags as $tagid=>$ctag){
            if(isset($row[$ctag->GetName()])){ $ctp->Assign($tagid,$row[$ctag->GetName()]); }
        }
        $revalue .= $ctp->GetResult();
    }
    
    return $revalue;
}