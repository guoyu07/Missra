<?php
/**
 * 站内新闻管理
 *
 * @version        $Id: mynews_main.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(MIINC."/typelink.class.php");
require_once(MIINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$miNowurl,time()+3600,"/");
$sql = "SELECT
 #@__mynews.aid,#@__mynews.title,#@__mynews.writer,
 #@__mynews.senddate,#@__mynews.typeid,
 #@__arctype.typename
 FROM #@__mynews
 LEFT JOIN #@__arctype ON #@__arctype.id=#@__mynews.typeid
 ORDER BY aid DESC";
$dlist = new DataListCP();
$dlist->SetTemplet(MIADMIN."/templets/mynews_main.htm");
$dlist->SetSource($sql);
$dlist->display();