<?php
/**
 *
 * 下载次数统计
 *
 * 如果想显示下载次数,即把下面ＪＳ调用放到文档模板适当位置
 * <script src="{missra:global name='cfg_phpurl'/}/disdls.php?aid={missra:field name='id'/}" type="text/javascript"></script>
 *
 * @version        $Id: disdls.php
 * @package        Mi.Site
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/../include/common.inc.php");
$aid = (isset($aid) && is_numeric($aid)) ? $aid : 0;
$row = $dsql->GetOne("SELECT SUM(downloads) AS totals FROM `#@__downloads` WHERE id='$aid' ");
if(empty($row['totals'])) $row['totals'] = 0;
echo "document.write('{$row['totals']}');";
exit();