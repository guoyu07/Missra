<?php   if(!defined('MIINC')) exit('Request Error!');
/**
 * 获得责任编辑名称
 *
 * @version        $Id: adminname.lib.php
 * @package        Mi.Taglib
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */

 /**
 *  获得责任编辑名称
 *
 * @access    public
 * @param     object  $ctag  解析标签
 * @param     object  $refObj  引用对象
 * @return    string  成功后返回解析后的标签内容
 */
 
 /*>>missra>>
<name>责任编辑</name> 
<type>仅内容模板</type> 
<for>V1.X</for>
<description>获得责任编辑名称</description>
<demo>
{missra:adminname /}	
</demo>
<attributes>
</attributes> 
>>missra>>*/

function lib_adminname(&$ctag, &$refObj)
{
    global $dsql;
    if(empty($refObj->Fields['dutyadmin']))
    {
        $dutyadmin = $GLOBALS['cfg_df_dutyadmin'];
    }
    else
    {
        $row = $dsql->GetOne("SELECT uname FROM `#@__admin` WHERE id='{$refObj->Fields['dutyadmin']}' ");
        $dutyadmin = isset($row['uname']) ? $row['uname'] : $GLOBALS['cfg_df_dutyadmin'];
    }
    return $dutyadmin;
}