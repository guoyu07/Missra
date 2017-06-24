<?php   if(!defined('MIINC')) exit('Request Error!');
/**
 * 广告调用
 *
 * @version        $Id: myad.lib.php
 * @package        Mi.Taglib
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
 
/*>>missra>>
<name>广告标签</name>
<type>全局标记</type>
<for>V1.X</for>
<description>获取广告代码</description>
<demo>
{missra:myad name=''/}
</demo>
<attributes>
    <iterm>typeid:投放范围,0为全站</iterm> 
    <iterm>name:广告标识</iterm>
</attributes> 
>>missra>>*/
 
require_once(MIINC.'/taglib/mytag.lib.php');

function lib_myad(&$ctag, &$refObj)
{
    $attlist = "typeid|0,name|";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);

    $body = lib_GetMyTagT($refObj, $typeid, $name, '#@__myad');
    
    return $body;
}