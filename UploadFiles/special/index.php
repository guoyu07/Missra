<?php
/**
 * @version        $Id: index.php
 * @package        Mi.Site
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/../include/common.inc.php");
require_once(MIINC."/arc.specview.class.php");
if(strlen($art_shortname) > 6) exit("art_shortname too long!");
$specfile = dirname(__FILE__)."spec_1".$art_shortname;
//如果已经编译静态列表，则直接引入第一个文件
if(file_exists($specfile))
{
    include($specfile);
    exit();
}
else
{
  $sp = new SpecView();
  $sp->Display();
}