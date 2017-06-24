<?php
/**
 * 模板文件管理
 *
 * @version        $Id: templets_main.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__).'/config.php');
CheckPurview('plus_文件管理器');

if(empty($acdir)) $acdir = $cfg_df_style;
$templetdir = $cfg_basedir.$cfg_templets_dir;
$templetdird = $templetdir.'/'.$acdir;
$templeturld = $cfg_templeturl.'/'.$acdir;

if(preg_match("#\.#", $acdir))
{
    ShowMsg('Not Allow dir '.$acdir.'!', '-1');
    exit();
}

//获取默认文件说明信息
function GetInfoArray($filename)
{
    $arrs = array();
    $dlist = file($filename);
    foreach($dlist as $d)
    {
        $d = trim($d);
        if($d!='')
        {
            list($dname, $info) = explode(',', $d);
            $arrs[$dname] = $info;
        }
    }
    return $arrs;
}

$dirlists  = GetInfoArray($templetdir.'/templet-dirlist.inc');
$filelists = GetInfoArray($templetdir.'/templet-filelist.inc');
$pluslists = GetInfoArray($templetdir.'/templet-pluslist.inc');
$fileinfos = ($acdir=='plus' ? $pluslists : $filelists);

include MiInclude('templets/templets_default.htm');