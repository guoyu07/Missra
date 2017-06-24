<?php
/**
 * 增加任务
 *
 * @version        $Id: sys_task_add.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require(dirname(__FILE__)."/config.php");
CheckPurview('sys_Task');
if(empty($dopost)) $dopost = '';

if($dopost=='save')
{
    $starttime = empty($starttime) ? 0 : GetMkTime($starttime);
    $endtime = empty($endtime) ? 0 : GetMkTime($endtime);
    $runtime = $h.':'.$m;
    $Query = "INSERT INTO `#@__sys_task`(`taskname`,`dourl`,`islock`,`runtype`,`runtime`,`starttime`,`endtime`,`freq`,`lastrun`,`description`,`parameter`,`settime`)
        VALUES('$taskname', '$dourl', '$nislock', '$runtype', '$runtime', '$starttime', '$endtime','$freq', '0', '$description','$parameter', '".time()."'); ";
    $rs = $dsql->ExecuteNoneQuery($Query);
    if($rs) 
    {
        ShowMsg('成功增加一个任务!', 'sys_task.php');
    }
    else
    {
        ShowMsg('增加任务失败!'.$dsql->GetError(), 'javascript:;');
    }
    exit();
}

include MiInclude('templets/sys_task_add.htm');