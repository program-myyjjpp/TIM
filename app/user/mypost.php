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
if(!power('b',2)) {
	adminmsg('','无权限',3);
}
checktoken();
$nickname=dbstr(trim(htmlspecialchars($_POST['nickname'])));
$psd=trim($_POST['psd']);
if(strlen($psd)>0) {
	$psd1=trim($_POST['psd1']);
	if($psd<>$psd1) {
		adminmsg('','两次输入密码不一致',3);
	}
}
$thisname=getadminname();
if(isset($_SERVER['HTTP_REFERER'])) {
	if(stripos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST'])===false) {
		die('error referer');
	}
	if(stripos($_SERVER['HTTP_REFERER'],'?do=user_my')===false) {
		die('error referer');
	}
}
if($psd=='') {
	$query = $GLOBALS['db'] -> query("UPDATE ".tableex('admin')." SET nickname='$nickname' WHERE username='$thisname'");
	if($query) {
		$msg='修改成功';
	}else {
		$msg='修改失败';
	}
}else {
	$psd=password_md5($psd);
	$query = $GLOBALS['db'] -> query("UPDATE ".tableex('admin')." SET nickname='$nickname',psd='$psd' WHERE username='$thisname'");
	if($query) {
		$msg='修改成功,请重新登录';
		adminmsg('?do=user_my',$msg,3,'登录页');//setadminpsd($psd);
	}else {
		$msg='修改失败';
	}
}
adminmsg('?do=user_my',$msg,3);
?>
