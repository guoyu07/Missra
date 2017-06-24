<?php
if (!defined('MIINC'))
    exit('Request Error!');
/**
 * 
 *
 * @version        $Id: php.lib.php1
 * @package        Mi.Taglib
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
 
 /*>>missra>>
<name>PHP代码标签</name>
<type>全局标记</type>
<for>V1.X</for>
<description>调用PHP代码</description>
<demo>
{missra:php}
$a = "missra";
echo $a;
{/missra:php}
</demo>
<attributes>
</attributes> 
>>missra>>*/
 
function lib_php(&$ctag, &$refObj)
{
    global $dsql;
    global $db;
    $phpcode = trim($ctag->GetInnerText());
    if ($phpcode == '')
        return '';
    ob_start();
    extract($GLOBALS, EXTR_SKIP);
    @eval($phpcode);
    $revalue = ob_get_contents();
    ob_clean();
    return $revalue;
}