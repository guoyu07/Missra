<?php
/**
 *
 * 评论js调用
 *
 * @version        $Id: freelist.php
 * @package        Mi.Site
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/../include/common.inc.php");
if($cfg_feedback_forbid=='Y') exit("document.write('系统已经禁止评论功能！');\r\n");
require_once(MIINC."/datalistcp.class.php");
if(isset($arcID)) $aid = $arcID;

$arcID = $aid = (isset($aid) && is_numeric($aid)) ? $aid : 0;
if($aid==0) exit(" Request Error! ");

$querystring = "SELECT fb.*,mb.userid,mb.face as mface,mb.spacesta,mb.scores FROM `#@__feedback` fb
                 LEFT JOIN `#@__member` mb ON mb.mid = fb.mid
                 WHERE fb.aid='$aid' AND fb.ischeck='1' ORDER BY fb.id DESC";
$dlist = new DataListCP();
$dlist->pageSize = 6;
$dlist->SetTemplet(MITEMPLATE.'/plus/feedback_templet_js.htm');
$dlist->SetSource($querystring);
$dlist->display();

?>