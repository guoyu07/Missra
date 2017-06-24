<?php
/**
 * 文件管理器
 *
 * @version        $Id: file_manage_main.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require(dirname(__FILE__)."/config.php");
CheckPurview('plus_文件管理器');
if(!isset($activepath)) $activepath=$cfg_cmspath;

$inpath = "";
$activepath = str_replace("..", "", $activepath);
$activepath = preg_replace("#^\/{1,}#", "/", $activepath);
if($activepath == "/") $activepath = "";

if($activepath == "") $inpath = $cfg_basedir;
else $inpath = $cfg_basedir.$activepath;

$activeurl = $activepath;
if(preg_match("#".$cfg_templets_dir."#i", $activepath))
{
    $istemplets = TRUE;
}
else
{
    $istemplets = FALSE;
}
include MiInclude('templets/file_manage_main.htm');