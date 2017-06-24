<?php
/**
 * 标签测试操作
 *
 * @version        $Id: tag_test_action.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('temp_Test');
require_once(MIINC."/arc.partview.class.php");
if(empty($partcode))
{
    ShowMsg('错误请求','javascript:;');
    exit;
}
$partcode = stripslashes($partcode);

if(empty($typeid)) $typeid = 0;
if(empty($showsource)) $showsource = "";

if($typeid>0) $pv = new PartView($typeid);
else $pv = new PartView();

$pv->SetTemplet($partcode, "string");
if( $showsource == "" || $showsource == "yes" )
{
    echo "模板代码:";
    echo "<span style='color:red;'><pre>".mi_htmlspecialchars($partcode)."</pre></span>";
    echo "结果:<hr size='1' width='100%'>";
}
$pv->Display();