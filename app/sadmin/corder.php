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
$corder=intval($_GET['corder']);
$query = $GLOBALS['db'] -> query("UPDATE ".tableex('channel')." SET corder='$corder' WHERE cid='$cid'");
	if($query) {
		$msg='修改成功';
	}else {
		$msg='修改失败';
	}
	if(!isset($_SERVER["HTTP_REFERER"])) {$_SERVER["HTTP_REFERER"]='';}
	adminmsg($_SERVER["HTTP_REFERER"],$msg,1);
?>