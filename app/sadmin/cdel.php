<?php

/**
 * PhpStorm
 * 开发时长两年半
 * 2023/12/25
 * 61468384@qq.com
 * 3.0
 * https://gpt.myyjjpp.com
 * 简单即是美 Simple is beautiful...
 **/


if (!defined('admin')) {exit();}
if(power('alevel')!=3) {die('error');}
checktoken();
$cid=intval($_GET['cid']);
$pagecount = $GLOBALS['db'] -> fetchcount("SELECT count(cid) FROM ".tableex('channel')." where fid='$cid'");
if($pagecount>0) {
	adminmsg('','请先删除下属栏目',1);
}
$query = $GLOBALS['db'] -> query("delete from `".tableex('str')."` WHERE strcid='$cid'");
if($query) {
	$query = $GLOBALS['db'] -> query("delete from `".tableex('moudle')."` WHERE cid='$cid'");
	if($query) {
		$query = $GLOBALS['db'] -> query("delete from `".tableex('channel')."` WHERE cid='$cid'");
		if($query) {
			$msg='删除成功';
			channelrouter();
			cachedel('channelscache','channel');
			cachedel('channelcache_'.$cid,'channel');
		}else {
			$msg='删除栏目失败';
		}
	}else {
		$msg='删除栏目模型失败';
	}
}else {
	$msg='删除栏目参数失败';
}
if(!isset($_SERVER["HTTP_REFERER"])) {$_SERVER["HTTP_REFERER"]='';}
adminmsg($_SERVER["HTTP_REFERER"],$msg,1);
?>