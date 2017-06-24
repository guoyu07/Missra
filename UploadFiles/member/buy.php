<?php
/**
 * @version        $Id: buy.php
 * @package        Mi.Member
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__).'/config.php');
CheckRank(0,0);
$menutype = 'mymi';
$menutype_son = 'op';
$myurl = $cfg_basehost.$cfg_member_dir.'/index.php?uid='.$cfg_ml->M_LoginID;
$moneycards = '';
$membertypes = '';
$dsql->SetQuery("SELECT * FROM #@__moneycard_type ");
$dsql->Execute();
while($row = $dsql->GetObject())
{
    $row->money = sprintf("%01.2f", $row->money);
    $moneycards .= "<tr align='center'>
    <td><input type='radio' name='pid' value='{$row->tid}'></td>
    <td><strong>{$row->pname}</strong></td>
    <td>{$row->num}个</td>
    <td>{$row->money}元</td>
    </tr>
    ";
}
$dsql->SetQuery("SELECT #@__member_type.*,#@__arcrank.membername,#@__arcrank.money as cm From #@__member_type LEFT JOIN #@__arcrank on #@__arcrank.rank = #@__member_type.rank ");
$dsql->Execute();
while($row = $dsql->GetObject())
{
    $row->money = sprintf("%01.2f", $row->money); 
    $membertypes .= "<tr align='center'>
    <td><input type='radio' name='pid' value='{$row->aid}'></td>
    <td><strong>{$row->pname}</strong></td>
    <td>{$row->membername}</td>
    <td>{$row->exptime}</td>
    <td>{$row->money}元</td>
    </tr>
    ";
}
$tpl = new MiTemplate();
$tpl->LoadTemplate(MIMEMBER.'/templets/buy.htm');
$tpl->Display();