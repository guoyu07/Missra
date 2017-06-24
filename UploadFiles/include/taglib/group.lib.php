<?php   if(!defined('MIINC')) exit('Request Error!');
/**
 * 圈子调用标签
 *
 * @version        $Id: group.lib.php
 * @package        Mi.Taglib
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
 
/*>>missra>>
<name>圈子标签</name>
<type>全局标记</type>
<for>V1.X</for>
<description>圈子调用标签</description>
<demo>
{missra:group row='6' orderby='threads' titlelen='30'}
 <li>
  <span><img style="visibility: inherit;" title="[field:groupname/]" src="[field:icon/]" /></span>
  <span><a href="[field:url/]" title="[field:groupname/]" target="_blank">[field:groupname/]</a></span>
 </li>
{/missra:group} 
</demo>
<attributes>
    <iterm>row:调用条数</iterm> 
    <iterm>orderby:排列顺序（默认是主题数）</iterm>
    <iterm>titlelen:圈子名称最大长度</iterm>
</attributes> 
>>missra>>*/
 
function lib_group(&$ctag,&$refObj)
{
    global $dsql, $envs, $cfg_dbprefix, $cfg_cmsurl;
    //属性处理
    $attlist="row|6,orderby|threads,titlelen|30";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);

    if( !$dsql->IsTable("{$cfg_dbprefix}groups") ) return '没安装圈子模块';
    
    if(!preg("#\/$#", $cfg_cmsurl)) $cfg_group_url = $cfg_cmsurl.'/group';
    else $cfg_group_url = $cfg_cmsurl.'group';
    
    $innertext = $ctag->GetInnerText();
    if(trim($innertext)=='') $innertext = GetSysTemplets("groups.htm");
    
    $list = '';
    $dsql->SetQuery("SELECT groupimg,groupid,groupname FROM `#@__groups` WHERE ishidden=0 ORDER BY $orderby DESC LIMIT 0,{$row}");
    $dsql->Execute();
    $ctp = new MiTagParse();
    $ctp->SetNameSpace('field', '[', ']');
    while($rs = $dsql->GetArray())
    {
        $ctp->LoadSource($innertext);
        $rs['groupname'] = cn_substr($rs['groupname'], $titlelen);
        $rs['url'] = $cfg_group_url."/group.php?id={$rs['groupid']}";
        $rs['icon']  = $rs['groupimg'];
        foreach($ctp->CTags as $tagid=>$ctag)
        {
            if( !empty($rs[strtolower($ctag->GetName())]) ) {
                $ctp->Assign($tagid,$rs[$ctag->GetName()]);
            }
          }
          $list .= $ctp->GetResult();
    }
    return $list;
}