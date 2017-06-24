<?php
/**
 * 管理后台首页主体
 *
 * @version        $Id: index_body.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/license.html
 * @link           http://www.missra.com
 */
require(dirname(__FILE__).'/config.php');
require(MIINC.'/image.func.php');
require(MIINC.'/mitag.class.php');
$defaultIcoFile = MIDATA.'/admin/quickmenu.txt';
$myIcoFile = MIDATA.'/admin/quickmenu-'.$cuserLogin->getUserID().'.txt';
if(!file_exists($myIcoFile)) $myIcoFile = $defaultIcoFile;

//默认主页
if(empty($dopost)) {
    require(MIINC.'/inc/inc_fun_funAdmin.php');
    $verLockFile = MIDATA.'/admin/ver.txt';
    $fp = fopen($verLockFile,'r');
    $upTime = trim(fread($fp,64));
    fclose($fp);
    $oktime = substr($upTime,0,4).'-'.substr($upTime,4,2).'-'.substr($upTime,6,2);
    $offUrl = SpGetNewInfo();
    $miidc = MIDATA.'/admin/idc.txt';
    $fp = fopen($miidc,'r');
    $miIDC = fread($fp,filesize($miidc));
    fclose($fp);
    include MiInclude('templets/index_body.htm');
    exit();
}
/*-----------------------
增加新项
function _AddNew() {   }
-------------------------*/
else if($dopost=='addnew') {
    if(empty($link) || empty($title)) {
        ShowMsg("链接网址或标题不能为空！","-1");
        exit();
    }

    $fp = fopen($myIcoFile,'r');
    $oldct = trim(fread($fp, filesize($myIcoFile)));
    fclose($fp);

    $link = preg_replace("#['\"]#", '`', $link);
    $title = preg_replace("#['\"]#", '`', $title);
    $ico = preg_replace("#['\"]#", '`', $ico);
    $oldct .= "\r\n<menu:item ico=\"{$ico}\" link=\"{$link}\" title=\"{$title}\" />";

    $myIcoFileTrue = MIDATA.'/admin/quickmenu-'.$cuserLogin->getUserID().'.txt';
    $fp = fopen($myIcoFileTrue, 'w');
    fwrite($fp, $oldct);
    fclose($fp);

    ShowMsg("成功增加一个项目！","index_body.php?".time());
    exit();
}
/*---------------------------
保存修改的项
function _EditSave() {   }
----------------------------*/
else if($dopost=='editsave') {
    $quickmenu = stripslashes($quickmenu);

    $myIcoFileTrue = MIDATA.'/admin/quickmenu-'.$cuserLogin->getUserID().'.txt';
    $fp = fopen($myIcoFileTrue,'w');
    fwrite($fp,$quickmenu);
    fclose($fp);

    ShowMsg("成功修改快捷操作项目！","index_body.php?".time());
    exit();
}
/*---------------------------
保存修改的项
function _EditSave() {   }
----------------------------*/
else if($dopost=='movesave') {   
    $movedata = str_replace('\\',"",$sortorder);
    $movedata = json_decode($movedata,TRUE);
    $movedata = serialize($movedata);
    $myIcoFileTrue = MIDATA.'/admin/move-'.$cuserLogin->getUserID().'.txt';
    $fp = fopen($myIcoFileTrue,'w');
    fwrite($fp,$movedata);
    fclose($fp);
}
/*-----------------------------
显示修改表单
function _EditShow() {   }
-----------------------------*/
else if($dopost=='editshow') {
    $fp = fopen($myIcoFile,'r');
    $oldct = trim(fread($fp,filesize($myIcoFile)));
    fclose($fp);
?>
<form name='editform' action='index_body.php' method='post'>
	<input type='hidden' name='dopost' value='editsave' />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height='28' background="images/tbg.gif">
				<div style='float:left'><b>修改快捷操作项</b></div>
				<div style='float:right;padding:3px 10px 0 0;'>
					 <a href="javascript:CloseTab('editTab')"><img src="images/close.gif" width="12" height="12" border="0" /></a>
				</div>
			</td>
		</tr>
		<tr>
			<td style="height:6px;font-size:1px;border-top:1px solid #8DA659">&nbsp;</td>
		</tr>
		<tr>
			<td>按原格式修改/增加XML项。</td>
		</tr>
		<tr>
			<td align='center'>
				<textarea name="quickmenu" rows="10" cols="50" style="width:94%;height:220px"><?php echo $oldct; ?></textarea>
			</td>
		</tr>
		<tr>
			<td height="45" align="center">
				<input type="submit" name="Submit" value="保存项目" class="np coolbg" style="width:80px;cursor:pointer" />&nbsp;
				<input type="reset" name="reset" value="重设" class="np coolbg" style="width:50px;cursor:pointer" />
			</td>
		</tr>
	</table>
</form>
<?php
exit();
}
/*---------------------------------
载入右边内容
function _getRightSide() {   }
---------------------------------*/
else if($dopost=='getRightSide') {
    $query = " SELECT COUNT(*) AS dd FROM `#@__member` ";
    $row1 = $dsql->GetOne($query);
    $query = " SELECT COUNT(*) AS dd FROM `#@__feedback` ";
    $row2 = $dsql->GetOne($query);
    
    $chArrNames = array();
    $query = "SELECT id, typename FROM `#@__channeltype` ";
    $dsql->Execute('c', $query);
    while($row = $dsql->GetArray('c')){
        $chArrNames[$row['id']] = $row['typename'];
    }
    
    $query = "SELECT COUNT(channel) AS dd, channel FROM `#@__arctiny` GROUP BY channel ";
    $allArc = 0;
    $chArr = array();
    $dsql->Execute('a', $query);
    while($row = $dsql->GetArray('a')) {
        $allArc += $row['dd'];
        $row['typename'] = $chArrNames[$row['channel']];
        $chArr[] = $row;
    }
?>
    <table width="100%" class="mi-table mi-table-boder-none">
        <tr>
            <td width='50%' class='nline'> 会员数： </td>
            <td class='nline'> <?php echo $row1['dd']; ?> </td>
        </tr>
        <tr>
            <td class='nline'> 文档数： </td>
            <td class='nline'> <?php echo $allArc; ?> </td>
        </tr>
        <?php
        foreach($chArr as $row) {
        ?>
        <tr>
            <td class='nline'> <?php echo $row['typename']; ?>： </td>
            <td class='nline'> <?php echo $row['dd']; ?>&nbsp; </td>
        </tr>
        <?php
        }
        ?>
        <tr>
            <td class='nline'> 评论数： </td>
            <td class='nline'> <?php echo $row2['dd']; ?> </td>
        </tr>
    </table>
<?php
    exit();
    } else if ($dopost=='getRightSideNews') {
    $query = "SELECT arc.id, arc.arcrank, arc.title, arc.channel, ch.editcon  FROM `#@__archives` arc
            LEFT JOIN `#@__channeltype` ch ON ch.id = arc.channel
             WHERE arc.arcrank<>-2 ORDER BY arc.id DESC LIMIT 0, 6 ";
    $arcArr = array();
    $dsql->Execute('m', $query);
    while($row = $dsql->GetArray('m')) {
        $arcArr[] = $row;
    }
    AjaxHead();
?>
    <table width="100%" class="dboxtable">
    <?php
    foreach($arcArr as $row) {
        if(trim($row['editcon'])=='') {
            $row['editcon'] = 'archives_edit.php';
        }
        $linkstr = "·<a href='{$row['editcon']}?aid={$row['id']}&channelid={$row['channel']}'>{$row['title']}</a>";
        if($row['arcrank']==-1) $linkstr .= "<font color='red'>(未审核)</font>";
    ?>
    <tr>
        <td class='nline'>
            <?php echo $linkstr; ?>
        </td>
    </tr>
    <?php } ?>
    </table>
<?php
exit;
}else if($dopost=='setskin'){
	$cskin = empty($cskin)? 1 : $cskin;
	$skin = !in_array($cskin, array(1,2,3,4))? 1 : $cskin;
	$skinconfig = MIDATA.'/admin/skin.txt';
	PutFile($skinconfig, $skin);
} elseif ( $dopost=='get_seo' ){
    if (!function_exists('fsocketopen') && !function_exists('curl_init')) {
        echo '<table class="dboxtable" width="100%"><tr><td class="nline">没有支持的curl或fsocketopen组件</td></tr></table>';
        exit;
    }
    function miseo_http_send($url, $limit=0, $post='', $cookie='', $timeout=5){
        $return = '';
        $matches = parse_url($url);
        $scheme = $matches['scheme'];
        $host = $matches['host'];
        $path = $matches['path'] ? $matches['path'].(@$matches['query'] ? '?'.$matches['query'] : '') : '/';
        $port = !empty($matches['port']) ? $matches['port'] : 80;

        if (function_exists('curl_init') && function_exists('curl_exec')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $scheme.'://'.$host.':'.$port.$path);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, @$_SERVER['HTTP_USER_AGENT']); 
            if ($post) {
                curl_setopt($ch, CURLOPT_POST, 1);
                $content = is_array($port) ? http_build_query($post) : $post;
                curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
            }
            if ($cookie) {
                curl_setopt($ch, CURLOPT_COOKIE, $cookie);
            }
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            $data = curl_exec($ch);
            $status = curl_getinfo($ch);
            $errno = curl_errno($ch);
            curl_close($ch);
            if ($errno || $status['http_code'] != 200) {
                return;
            } else {
                return !$limit ? $data : substr($data, 0, $limit);
            }
        }

        if ($post) {
            $content = is_array($port) ? http_build_query($post) : $post;
            $out = "POST $path HTTP/1.0\r\n";
            $header = "Accept: */*\r\n";
            $header .= "Accept-Language: zh-cn\r\n";
            $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $header .= "User-Agent: ".@$_SERVER['HTTP_USER_AGENT']."\r\n";
            $header .= "Host: $host:$port\r\n";
            $header .= 'Content-Length: '.strlen($content)."\r\n";
            $header .= "Connection: Close\r\n";
            $header .= "Cache-Control: no-cache\r\n";
            $header .= "Cookie: $cookie\r\n\r\n";
            $out .= $header.$content;
        } else {
            $out = "GET $path HTTP/1.0\r\n";
            $header = "Accept: */*\r\n";
            $header .= "Accept-Language: zh-cn\r\n";
            $header .= "User-Agent: ".@$_SERVER['HTTP_USER_AGENT']."\r\n";
            $header .= "Host: $host:$port\r\n";
            $header .= "Connection: Close\r\n";
            $header .= "Cookie: $cookie\r\n\r\n";
            $out .= $header;
        }

        $fpflag = 0;
        $fp = false;
        if (function_exists('fsocketopen')) {
            $fp = fsocketopen($host, $port, $errno, $errstr, $timeout);
        }
        if (!$fp) {
            $context = stream_context_create(array(
                'http' => array(
                    'method' => $post ? 'POST' : 'GET',
                    'header' => $header,
                    'content' => $content,
                    'timeout' => $timeout,
                ),
            ));
            $fp = @fopen($scheme.'://'.$host.':'.$port.$path, 'b', false, $context);
            $fpflag = 1;
        }

        if (!$fp) {
            return '';
        } else {
            stream_set_blocking($fp, true);
            stream_set_timeout($fp, $timeout);
            @fwrite($fp, $out);
            $status = stream_get_meta_data($fp);
            if (!$status['timed_out']) {
                while (!feof($fp) && !$fpflag) {
                    if (($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
                        break;
                    }
                }
                if ($limit) {
                    $return = stream_get_contents($fp, $limit);
                } else {
                    $return = stream_get_contents($fp);
                }
            }
            @fclose($fp);
            return $return;
        }
    }
?>
<table width="100%" class="dboxtable">
    <tbody>
<?php
    foreach( $seo_info as $key => $value ) {
        if ( $key=='id' OR $key=='create_time' ) continue;
?>

    <tr>
        <td width="50%" class="nline"> <?php echo $inff[$key];?>：</td>
        <td class="nline"> <?php echo $value; ?></td>
    </tr>
<?php } ?>

    </tbody>
</table>
<?php 
	exit;
} ?>
       
    

