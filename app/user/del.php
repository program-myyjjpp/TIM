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
checktoken();
$mylevel=power('alevel');
if($mylevel<2) {
	adminmsg('','无权限',3);
}else {
	if($mylevel==3) {
		$alevel=3;
	}elseif($mylevel==2) {
		$alevel=1;
	}else {
		$alevel=0;
	}
}
$id=intval($_GET['id']);
$thisname=getadminname();
$delinfo = $GLOBALS['db'] -> one("SELECT * FROM `".tableex('admin')."` where id='$id' limit 1");
if($thisname==$delinfo['username']) {
	adminmsg('','不能删除自己的账号',3);
}
if($alevel==2) {
	if($delinfo['alevel']>=$alevel) {
		adminmsg('','无权限',3);
	}
}
$superadmincount = $GLOBALS['db'] -> fetchcount("SELECT count(id) FROM `".tableex('admin')."` where id<>'$id' and alevel='3'");
if($superadmincount<1) {
	adminmsg('','系统必须拥有一位超级管理员',3);
}
$query = $GLOBALS['db'] -> query("delete from `".tableex('admin')."` WHERE id='$id' and alevel<='$alevel' and username<>'$thisname'");
	if($query) {
		$msg='删除成功';
	}else {
		$msg='删除失败';
	}
adminmsg('?do=user',$msg,3);
?>