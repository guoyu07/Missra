<?php
/**
 * 单页文档相同标识调用标签
 *
 * @version        $Id: likepage.lib.php
 * @package        Mi.Taglib
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
 
/*>>missra>>
<name>单页文档相同标识调用标签</name>
<type>全局标记</type>
<for>V1.X</for>
<description>调用相同标识单页文档</description>
<demo>
{missra:likepage likeid='' row=''/}
</demo>
<attributes>
    <iterm>row:调用条数</iterm> 
    <iterm>likeid:标识名</iterm>
</attributes> 
>>missra>>*/
 
if(!defined('MIINC')) exit('Request Error!');
require_once(dirname(__FILE__).'/likesgpage.lib.php');

function lib_likepage(&$ctag,&$refObj)
{
    return lib_likesgpage($ctag, $refObj);
}
