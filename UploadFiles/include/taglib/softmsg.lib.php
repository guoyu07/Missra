<?php
if(!defined('MIINC'))
{
    exit("Request Error!");
}
/**
 * 下载说明标签
 *
 * @version        $Id: softmsg.lib.php
 * @package        Mi.Taglib
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
 
/*>>missra>>
<name>下载说明</name>
<type>软件内容模板</type>
<for>V1.X</for>
<description>下载说明标签</description>
<demo>
{missra:softmsg /}
</demo>
<attributes>
</attributes> 
>>missra>>*/
 
function lib_softmsg(&$ctag,&$refObj)
{
    global $dsql;
    //$attlist="type|textall,row|24,titlelen|24,linktype|1";
    //FillAttsDefault($ctag->CAttribute->Items,$attlist);
    //extract($ctag->CAttribute->Items, EXTR_SKIP);
    $revalue = '';
    $row = $dsql->GetOne(" SELECT * FROM `#@__softconfig` ");
    if(is_array($row)) $revalue = $row['downmsg'];
    return $revalue;
}