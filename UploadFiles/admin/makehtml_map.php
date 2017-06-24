<?php
/**
 * 生成网站地图
 *
 * @version        $Id: makehtml_map.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(MIINC."/sitemap.class.php");
require_once(MIINC."/mitag.class.php");

if(empty($dopost))
{
    ShowMsg("参数错误!","-1");
    exit();
}
$isremote = empty($isremote)? 0 : $isremote;
$serviterm=empty($serviterm)? "" : $serviterm;
$sm = new SiteMap();
$maplist = $sm->GetSiteMap($dopost);
if($dopost=="site")
{
    $murl = $cfg_cmspath."/data/sitemap.html";
    $tmpfile = $cfg_basedir.$cfg_templets_dir."/plus/sitemap.htm";
}
else
{
    $murl = $cfg_cmspath."/data/rssmap.html";
    $tmpfile = $cfg_basedir.$cfg_templets_dir."/plus/rssmap.htm";
}
$dtp = new MiTagParse();
$dtp->LoadTemplet($tmpfile);
$dtp->SaveTo($cfg_basedir.$murl);
if($cfg_remote_site=='Y' && $isremote == 1)
{
    if($serviterm!="")
    {
        list($servurl, $servuser, $servpwd) = explode(',', $serviterm);
        $config=array( 'hostname' => $servurl, 'username' => $servuser, 
                   'password' => $servpwd,'debug' => 'TRUE');
    } else {
        $config=array();
    }
    if( $ftp->connect($config) )
    {
        //分析远程文件路径
        $remotefile = $murl;
        $localfile = '..'.$remotefile;
        $remotedir = preg_replace('#[^\/]*\.html#', '', $remotefile);
        $ftp->rmkdir($remotedir);
        if($ftp->upload($localfile, $remotefile, 'acii')) echo "远程发布成功!"."<br />";
    }
}
$dtp->Clear();
echo "<a href='$murl' target='_blank'>成功更新文件: $murl 浏览...</a>";
exit();