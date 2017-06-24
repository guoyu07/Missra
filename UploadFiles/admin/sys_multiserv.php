<?php
/**
 * 多站点设置
 *
 * @version        $Id: sys_multiserv.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_SoftConfig');
if(empty($dopost)) $dopost = '';

//保存
if($dopost=="save")
{
    $configfile = MIDATA."/cache/inc_remote_config.php";
    $rminfo = serialize(array('rmhost'=>$c_rmhost, 'rmport'=>$c_rmport, 
                               'rmname'=>$c_rmname, 'rmpwd'=>$c_rmpwd));
    $query = "UPDATE `#@__multiserv_config` SET
           `remoteuploads` = '$c_remoteuploads' ,
           `remoteupUrl` ='$c_remoteupUrl' ,
           `rminfo` = '$rminfo',
           `servinfo` = '$c_servinfo'";
    $dsql->ExecuteNoneQuery($query);
    //更新配置缓存文件
    
    $configstr = "\$remoteuploads = '".$c_remoteuploads."';\r\n";
    $configstr .= "\$remoteupUrl = '".$c_remoteupUrl."';\r\n";
    $configstr .= "\$rmhost = '".$c_rmhost."';\r\n";
    $configstr .= "\$rmport = '".$c_rmport."';\r\n";
    $configstr .= "\$rmname = '".$c_rmname."';\r\n";
    $configstr .= "\$rmpwd = '".$c_rmpwd."';\r\n";
    $configstr = "<"."?php\r\n".$configstr."?".">\r\n";
    
    $fp = fopen($configfile, "w") or die("写入文件 $safeconfigfile 失败，请检查权限！");
    fwrite($fp, $configstr);
    fclose($fp);
    
    ShowMsg('成功保存参数！', 'sys_multiserv.php');
    exit();
}

//读取参数
$row = $dsql->GetOne("SELECT * FROM `#@__multiserv_config` ");
if(!is_array($row))
{
    $dsql->ExecuteNoneQuery("INSERT INTO `#@__multiserv_config` 
                            (`remoteuploads`, `remoteupUrl`, `rminfo`, `servinfo`) 
                     VALUES ('0','http://img.missra.com', '', '')"
    );
    $row['remoteuploads']   = 1;
    $row['remoteupUrl'] = 'http://img.missra.com';
    $row['rminfo']    = '';
    $row['servinfo']   = '';
}
//对配置信息进行处理
if(!empty($row['rminfo']))
{
    $row['rminfo'] = unserialize($row['rminfo']);
}

//获取会员列表
$query = "SELECT #@__admin.*,#@__admintype.typename FROM #@__admin LEFT JOIN #@__admintype ON #@__admin.usertype = #@__admintype.rank";
$dsql->SetQuery($query);
$dsql->Execute();
while($row3 = $dsql->GetArray())
{
    $adminLists[] = $row3;
}
include MiInclude('templets/sys_multiserv.htm');
exit();