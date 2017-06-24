<?php
/**
 * 获取网站搜索的热门关键字
 *
 * @version        $Id: hotwords.lib.php
 * @package        Mi.Taglib
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
 
/*>>missra>>
<name>热门关键词</name>
<type>全局标记</type>
<for>V1.X</for>
<description>获取网站搜索的热门关键字</description>
<demo>
{missra:hotwords /}
</demo>
<attributes>
    <iterm>num:关键词数目</iterm> 
    <iterm>subday:天数</iterm>
    <iterm>maxlength:关键词最大长度</iterm>
</attributes> 
>>missra>>*/
 
function lib_hotwords(&$ctag,&$refObj)
{
    global $cfg_phpurl,$dsql;

    $attlist="num|6,subday|365,maxlength|16";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);

    $nowtime = time();
    if(empty($subday)) $subday = 365;
    if(empty($num)) $num = 6;
    if(empty($maxlength)) $maxlength = 20;
    $maxlength = $maxlength+1;
    $mintime = $nowtime - ($subday * 24 * 3600);
    $dsql->SetQuery("SELECT keyword FROM `#@__search_keywords` WHERE lasttime>$mintime AND length(keyword)<$maxlength ORDER BY count DESC LIMIT 0,$num");
    $dsql->Execute('hw');
    $hotword = '';
    while($row=$dsql->GetArray('hw')){
        $hotword .= "　<a href='".$cfg_phpurl."/search.php?keyword=".urlencode($row['keyword'])."'>".$row['keyword']."</a> ";
    }
    return $hotword;
}