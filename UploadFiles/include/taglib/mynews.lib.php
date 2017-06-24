<?php
/**
 * 站内新闻调用标签
 *
 * @version        $Id:mynews.lib.php
 * @package        Mi.Taglib
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
 
/*>>missra>>
<name>站内新闻</name>
<type>全局标记</type>
<for>V1.x</for>
<description>站内新闻调用标签</description>
<demo>
{missra:mynews row='' titlelen=''/}
</demo>
<attributes>
    <iterm>row:调用站内新闻数</iterm> 
    <iterm>titlelen:新闻标题长度</iterm>
</attributes> 
>>missra>>*/
 
function lib_mynews(&$ctag,&$refObj)
{
    global $dsql,$envs;
    //属性处理
    $attlist="row|1,titlelen|24";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);

    $innertext = trim($ctag->GetInnerText());
    if(empty($row)) $row=1;
    if(empty($titlelen)) $titlelen=30;
    if(empty($innertext)) $innertext = GetSysTemplets('mynews.htm');

    $idsql = '';
    if($envs['typeid'] > 0) $idsql = " WHERE typeid='".GetTopid($this->TypeID)."' ";
    $dsql->SetQuery("SELECT * FROM #@__mynews $idsql ORDER BY senddate DESC LIMIT 0,$row");
    $dsql->Execute();
    $ctp = new MiTagParse();
    $ctp->SetNameSpace('field','[',']');
    $ctp->LoadSource($innertext);
    $revalue = '';
    while($row = $dsql->GetArray())
    {
        foreach($ctp->CTags as $tagid=>$ctag){
            @$ctp->Assign($tagid,$row[$ctag->GetName()]);
        }
        $revalue .= $ctp->GetResult();
    }
    return $revalue;
}