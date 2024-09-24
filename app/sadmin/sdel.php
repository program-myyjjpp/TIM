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
$id=intval($_GET['id']);
$query = $GLOBALS['db'] -> query("delete from `".tableex('str')."` WHERE id='$id' and inputkind>0");
if(!isset($_SERVER["HTTP_REFERER"])) {$_SERVER["HTTP_REFERER"]='';}
$url=$_SERVER["HTTP_REFERER"];
	if($query) {
		$msg='删除成功';
	}else {
		$msg='删除失败';
	}
	adminmsg($url,$msg,1);
?>
