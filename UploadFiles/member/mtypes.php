<?php
/**
 * @version        $Id: mtypes.php
 * @package        Mi.Member
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__).'/config.php');
CheckRank(0, 0);
$dopost = isset($dopost) ? trim($dopost) : '';
$menutype = 'config';
if($dopost == '')
{
    if(empty($channelid)) $channelid = 0;
    $channelid = intval($channelid);
    $mtypearr = array();
    $addquery = '';
    if(!empty($channelid)) $addquery = " AND channelid='$channelid' ";
    $query = "SELECT * FROM `#@__mtypes` WHERE mid='{$cfg_ml->M_ID}' $addquery ";
    $dsql->SetQuery($query);
    $dsql->Execute();
    while($row = $dsql->GetArray())
    {
        $mtypearr[] = $row;
    }
    $tpl = new MiTemplate();
    $tpl->LoadTemplate(MIMEMBER.'/templets/mtypes.htm');
    $tpl->Display();
    exit();
}
elseif ($dopost == 'add')
{
    $mtypename = HtmlReplace(trim($mtypename));
    $channelid = intval($channelid);
    if(empty($channelid)) $channelid = 1;
    if(strlen($mtypename) > 40 || strlen($mtypename) < 2)
    {
        ShowMsg('分类名称必须大于两个字节少于40个字节', '-1');
        exit();
    }
    $query = "INSERT INTO `#@__mtypes`(mtypename, channelid, mid) VALUES ('$mtypename', '$channelid', '$cfg_ml->M_ID'); ";
    if($dsql->ExecuteNoneQuery($query))
    {
        ShowMsg('增加分类成功', 'mtypes.php');
    }
    else
    {
        ShowMsg('增加分类失败', '-1');
    }
    exit();
} elseif ($dopost == 'save') {
    if(isset($mtypeidarr) && is_array($mtypeidarr)) {
        $delids = '0';
        $mtypeidarr = array_filter($mtypeidarr, 'is_numeric');
        foreach($mtypeidarr as $delid) {
			$delid = HtmlReplace($delid);
            $delids .= ','.$delid;
            unset($mtypename[$delid]);
        }
        $query = "DELETE FROM `#@__mtypes` WHERE mtypeid IN ($delids) AND mid='$cfg_ml->M_ID';";
        $dsql->ExecNoneQuery($query);
    }
	
    foreach ($mtypename as $id => $name) {
        $name = HtmlReplace($name);
		
		/* 对$id进行规范化处理 */
		$id = intval($id);
		/* */
		
		$query = "update `#@__mtypes` set mtypename='$name' where mtypeid='$id' and mid='$cfg_ml->M_ID'"; 
		die(var_dump($query));
		$dsql->ExecuteNoneQuery($query);
		
    }
    ShowMsg('分类修改完成','mtypes.php');
}