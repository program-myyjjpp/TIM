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
	$query = $GLOBALS['db'] -> query("delete from `".tableex('moudle')."` WHERE id='$id'");
	if($query) {
		if(!isset($_SERVER["HTTP_REFERER"])) {$_SERVER["HTTP_REFERER"]='';}
		adminmsg($_SERVER["HTTP_REFERER"],'删除成功',1);
	}else {
		adminmsg('','删除失败',3);
	}

?>
