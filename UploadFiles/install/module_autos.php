<?php
	require_once(dirname(__FILE__).'/../include/common.inc.php');
	$moduleCacheFile = dirname(__FILE__).'/modules.tmp.inc';
	include($moduleCacheFile);
	$modules = split(',',$selModule);
	$insLockfile = dirname(__FILE__).'/install_lock.txt';

	if(file_exists($insLockfile)){
		exit();
	}

	foreach($module_autos as $hh=>$module_auto){
		if(!in_array($hh, $modules)) continue;
		$autofile = dirname(__FILE__).'/module_autos/'.$module_auto['name'].'.php';
		if(file_exists($autofile)) require_once($autofile);
		else continue;
		$clsname = ucfirst($module_auto['name']);
		$macls = new $clsname();
		if(!$macls->run()) $logs .= "初始化{$module_auto['title']}出错：".$macls->errmsg."<br/>";
		else $logs .= "成功初始化{$module_auto['title']}<br/>";
	}

	$fp = fopen($insLockfile,'w');
	fwrite($fp,'ok');
	fclose($fp);
	@unlink('./modules.tmp.inc');
?>