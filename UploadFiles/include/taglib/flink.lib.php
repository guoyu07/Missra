<?php
if(!defined('MIINC'))
{
    exit("Request Error!");
}
/**
 * 友情链接
 *
 * @version        $Id: flink.lib.php
 * @package        Mi.Taglib
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */

/*>>missra>>
<name>友情链接</name>
<type>全局标记</type>
<for>V1.X</for>
<description>用于获取友情链接</description>
<demo>
{missra:flink row='24'/}
</demo>
<attributes>
    <iterm>type:链接类型</iterm> 
    <iterm>row:链接数量</iterm>
    <iterm>titlelen:站点文字的长度</iterm>
    <iterm>linktype:链接位置内页</iterm>
    <iterm>typeid:所有类型，可以在系统后台[模块]-[友情链接]中的“网站类型管理”中查看</iterm>
</attributes> 
>>missra>>*/
helper('cache');
function lib_flink(&$ctag,&$refObj)
{
	
    global $dsql,$cfg_soft_lang;
    $attlist="type|textall,row|24,titlelen|24,linktype|1,typeid|0";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);
    $totalrow = $row;
    $revalue = '';
    if (isset($GLOBALS['envs']['flinkid']))
    {
        $typeid = $GLOBALS['envs']['flinkid'];
    }

    $wsql = " where ischeck >= '$linktype' ";
	
    if($typeid == 0)
    {
        $wsql .= '';
    }
    else if($typeid == 999)
	{
		$prefix = 'flink';
		$key = '999';
		$row = GetCache($prefix, $key);
		
		if(!is_array($row))
		{
			require (MIDATA.'/admin/config_update.php');
			if (!class_exists('MiHttpDown', false)) {
				require_once(MIINC.'/mihttpdown.class.php');
			}
			$del = new MiHttpDown();
			$del->OpenUrl($linkHost);
			$linkUrl = $del->GetHtml()."flink.php?lang={$cfg_soft_lang}&site={$_SERVER['SERVER_NAME']}";
			$del->OpenUrl($linkUrl);
			$linkInfo = $del->GetHtml();
			
			if(!empty($linkInfo)){
				$milink = explode("\t", $linkInfo);
				for($i=0; $i<count($milink); $i++) {
					if($i%5==0 && $i!=count($milink)) {
						$revalue .= "<li><a href='http://".@$milink[$i+1]."' target='_blank' title='".@$milink[$i+4]."'>".@$milink[$i]."</a></li>";
					}
				}
			} else {
				$revalue=<<<EOT
<li><a href='http://ad.missra.com' target='_blank' title='Missra广告'>Missra广告</a></li><li><a href='http://service.missra.com' target='_blank' title='玫莎客户服务中心'>
玫莎客户服务中心</a></li><li><a href='http://ask.missra.com' target='_blank' title='玫莎问答'>
玫莎问答</a></li><li><a href='http://tools.missra.com' target='_blank' title='站长工具'>
站长工具</a></li><li><a href='http://site.missra.com' target='_blank' title='Missra建站中心'>
Missra建站中心</a></li><li><a href='http://help.missra.com' target='_blank' title='玫莎CMS帮助中心'>
玫莎CMS帮助中心</a></li><li><a href='http://' target='_blank' title=''>
</a></li>
EOT;
			}
			$row['reval'] = $revalue;
			SetCache($prefix, $key, $row, 60*60*1);
		}
		
		return $row['reval'];
	}
	else
    {
        $wsql .= "And typeid = '$typeid'";
    }
    if($type=='image')
    {
        $wsql .= " And logo<>'' ";
    }
    else if($type=='text')
    {
        $wsql .= " And logo='' ";
    }

    $equery = "SELECT * FROM #@__flink $wsql order by sortrank asc limit 0,$totalrow";

    if(trim($ctag->GetInnerText())=='') $innertext = "<li>[field:link /]</li>";
    else $innertext = $ctag->GetInnerText();
    
    $dsql->SetQuery($equery);
    $dsql->Execute();
    
    while($dbrow=$dsql->GetObject())
    {
        if($type=='text'||$type=='textall')
        {
            $link = "<a href='".$dbrow->url."' target='_blank'>".cn_substr($dbrow->webname,$titlelen)."</a> ";
        }
        else if($type=='image')
        {
            $link = "<a href='".$dbrow->url."' target='_blank'><img src='".$dbrow->logo."' width='88' height='31' border='0'></a> ";
        }
        else
        {
            if($dbrow->logo=='')
            {
                $link = "<a href='".$dbrow->url."' target='_blank'>".cn_substr($dbrow->webname,$titlelen)."</a> ";
            }
            else
            {
                $link = "<a href='".$dbrow->url."' target='_blank'><img src='".$dbrow->logo."' width='88' height='31' border='0'></a> ";
            }
        }
        $rbtext = preg_replace("/\[field:url([\/\s]{0,})\]/isU", $row['url'], $innertext);
         $rbtext = preg_replace("/\[field:webname([\/\s]{0,})\]/isU", $row['webname'], $rbtext);
         $rbtext = preg_replace("/\[field:logo([\/\s]{0,})\]/isU", $row['logo'], $rbtext);
         $rbtext = preg_replace("/\[field:link([\/\s]{0,})\]/isU", $link, $rbtext);
         $revalue .= $rbtext;
    }
    return $revalue;
}