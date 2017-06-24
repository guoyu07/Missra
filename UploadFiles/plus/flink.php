<?php
/**
 *
 * 友情链接
 *
 * @version        $Id: flink.php
 * @package        Mi.Site
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/../include/common.inc.php");
if(empty($dopost)) $dopost = '';


if($dopost=='save') {
    $validate = isset($validate) ? strtolower(trim($validate)) : '';
    $svali = GetCkVdValue();
    if($validate=='' || $validate!=$svali) {
        ShowMsg('验证码不正确!','-1');
        exit();
    }
    $msg = mi_htmlspecialchars($msg);
    $email = mi_htmlspecialchars($email);
    $webname = mi_htmlspecialchars($webname);
    $url = mi_htmlspecialchars($url);
    $logo = mi_htmlspecialchars($logo);
    $typeid = intval($typeid);
    $dtime = time();
    $query = "INSERT INTO `#@__flink`(sortrank,url,webname,logo,msg,email,typeid,dtime,ischeck)
                    VALUES('50','$url','$webname','$logo','$msg','$email','$typeid','$dtime','0')";
    $dsql->ExecuteNoneQuery($query);
    ShowMsg('成功增加一个链接，但需要审核后才能显示!','-1',1);
}

//显示模板(简单PHP文件)
include_once(MITEMPLATE.'/plus/flink-list.htm');