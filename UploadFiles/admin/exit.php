<?php
/**
 * 退出
 *
 * @version        $Id: exit.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(MIINC.'/userlogin.class.php');
$cuserLogin = new userLogin();
$cuserLogin->exitUser();
if(empty($needclose))
{
    header('location:index.php');
}
else
{
    $msg = "<script type='text/javascript'>
    if(document.all) window.opener=true;
    window.close();
    </script>";
    echo $msg;
}