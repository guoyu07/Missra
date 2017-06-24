<?php
/**
 * 生成专题
 *
 * @version        $Id: makehtml_spec.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_MakeHtml');
$isremote = empty($isremote)? 0 : $isremote;
$serviterm = empty($serviterm)? "" : $serviterm;
if(empty($dopost)) $dopost = "";

if($dopost=="ok")
{
    require_once(MIINC."/arc.specview.class.php");
    if($cfg_remote_site=='Y' && $isremote=="1")
    {
        if($serviterm!="")
        {
            list($servurl,$servuser,$servpwd) = explode(',',$serviterm);
            $config=array( 'hostname' => $servurl, 'username' => $servuser, 
                           'password' => $servpwd,'debug' => 'TRUE');
        } else {
            $config=array();
        }
        if(!$ftp->connect($config)) exit('Error:None FTP Connection!');
    }
    $sp = new SpecView();
    $rurl = $sp->MakeHtml($isremote);
    echo "成功生成所有专题HTML列表！<a href='$rurl' target='_blank'>预览</a>";
    exit();
}
include MiInclude('templets/makehtml_spec.htm');