<?php
if(!defined('MIINC'))
{
    exit("Request Error!");
}
/**
 * 调用任意表的数据标签
 *
 * @version        $Id: loop.lib.php
 * @package        Mi.Taglib
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
 
/*>>missra>>
<name>万能循环</name>
<type>全局标记</type>
<for>V1.X</for>
<description>调用任意表的数据标签</description>
<demo>
{missra:loop table='mi_archives' sort='' row='4' if=''}
<a href='[field:arcurl/]'>[field:title/]</a>
{/missra:loop}
</demo>
<attributes>
    <iterm>table:查询表名</iterm> 
    <iterm>sort:用于排序的字段</iterm>
    <iterm>row:返回结果的条数</iterm>
    <iterm>if:查询的条件</iterm>
</attributes> 
>>missra>>*/
 
require_once(MIINC.'/mivote.class.php');
function lib_loop(&$ctag,&$refObj)
{
    global $dsql;
    $attlist="table|,tablename|,row|8,sort|,if|,ifcase|,orderway|desc";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);

    $innertext = trim($ctag->GetInnertext());
    $revalue = '';
    if(!empty($table)) $tablename = $table;

    if($tablename==''||$innertext=='') return '';
    if($if!='') $ifcase = $if;

    if($sort!='') $sort = " ORDER BY $sort $orderway ";
    if($ifcase!='') $ifcase=" WHERE $ifcase ";
    $dsql->SetQuery("SELECT * FROM $tablename $ifcase $sort LIMIT 0,$row");
    $dsql->Execute();
    $ctp = new MiTagParse();
    $ctp->SetNameSpace("field","[","]");
    $ctp->LoadSource($innertext);
    $GLOBALS['autoindex'] = 0;
    while($row = $dsql->GetArray())
    {
        $GLOBALS['autoindex']++;
        foreach($ctp->CTags as $tagid=>$ctag)
        {
                if($ctag->GetName()=='array')
                {
                        $ctp->Assign($tagid, $row);
                }
                else
                {
                    if( !empty($row[$ctag->GetName()])) $ctp->Assign($tagid,$row[$ctag->GetName()]); 
                }
        }
        $revalue .= $ctp->GetResult();
    }
    return $revalue;
}