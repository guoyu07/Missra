<?php
/**
 * 根据条件生成标记
 *
 * @version        $Id: mytag_tag_guide_ok.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('temp_Other');

//根据条件生成标记
$attlist = "";
$attlist .= " row='".$row."'";
$attlist .= " titlelen='".$titlelen."'";
if($orderby!='senddate') $attlist .= " orderby='".$orderby."'";
if($order!='desc') $attlist .= " order='".$order."'";
if($typeid>0) $attlist .= " typeid='".$typeid."'";
if(isset($arcid)) $attlist .= " idlist='".$arcid."'";
if($channel>0) $attlist .= " channelid='".$channel."'";
if($att>0) $attlist .= " att='".$att."'";
if($col>1) $attlist .= " col='".$col."'";
if($subday>0) $attlist .= " subday='".$subday."'";

if(!empty($types))
{
    $attlist .= " type='";
    foreach($types as $v)
    {
        $attlist .= $v.'.';
    }
    $attlist .= "'";
}
$innertext = stripslashes($innertext);
if($keyword!="")
{
    $attlist .= " keyword='$keyword'";
}
$fulltag = "{missra:arclist$attlist}
$innertext
{/missra:arclist}\r\n";
if($dopost=='savetag')
{
    $fulltag = addslashes($fulltag);
    $tagname = "auto";
    $inQuery = "
     INSERT INTO #@__mytag(typeid,tagname,timeset,starttime,endtime,normbody,expbody)
     VALUES('0','$tagname','0','0','0','$fulltag','');
    ";
    $dsql->ExecuteNoneQuery($inQuery);
    $id = $dsql->GetLastID();
    $dsql->ExecuteNoneQuery("UPDATE #@__mytag SET tagname='{$tagname}_{$id}' WHERE aid='$id'");
    $fulltag = "{missra:mytag name='{$tagname}_{$id}' ismake='yes'/}";
}
include MiInclude('templets/mytag_tag_guide_ok.htm');