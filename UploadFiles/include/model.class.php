<?php   if(!defined('MIINC')) exit("Request Error!");
/**
 * 模型基类
 *
 * @version        $Id: model.class.php
 * @package        Mi.Libraries
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */

class Model
{
    var $dsql;
    var $db;

    function __construct()
    {
        $this->Model();
    }

    // 析构函数
    function Model()
    {
        global $dsql;
        if ($GLOBALS['cfg_mysql_type'] == 'mysqli')
        {
            $this->dsql = $this->db = isset($dsql)? $dsql : new MiSqli(FALSE);
        } else {
            $this->dsql = $this->db = isset($dsql)? $dsql : new MiSql(FALSE);
        }

    }

    // 释放资源
    function __destruct()
    {
        $this->dsql->Close(TRUE);
    }
}
