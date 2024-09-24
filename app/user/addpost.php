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
checktoken();
$quan=array();

//基础权限
if(isset($_POST['b'])) {
	foreach($_POST['b'] as $key=>$val) {
		$val=intval($val);
		$quan['b'][$val]=1;
	}
}
//管理员类型
if(isset($_POST['alevel'])) {
	if($_POST['alevel']>power('alevel')) {
		$_POST['alevel']=power('alevel');
	}
	if(power('alevel')==3) {
		$quan['alevel']=intval($_POST['alevel']);
	}else {
		$quan['alevel']=1;
	}
}else {
	$quan['alevel']=1;
}
//栏目权限
if($quan['alevel']==1) {
	if(isset($_POST['s'])) {
		foreach($_POST['s'] as $key=>$val) {
			$val=intval($val);
			if(isset($_POST['s_'.$val])) {
				$quan['s'][$val][0]=1;
				foreach($_POST['s_'.$val] as $skey=>$sval) {
					$quan['s'][$val][$sval]=1;
				}
			}
		}
	}
}

$thispower=dbstr(json_encode($quan));
if(isset($_SERVER['HTTP_REFERER'])) {
	if(stripos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST'])===false) {
		die('error referer');
	}
	if(stripos($_SERVER['HTTP_REFERER'],'?do=user_add')===false) {
		die('error referer');
	}
}
$nickname=dbstr(trim(htmlspecialchars($_POST['nickname'])));
$username=dbstr(trim(htmlspecialchars($_POST['username'])));
$psd=trim($_POST['psd']);
$psd1=trim($_POST['psd1']);
if($psd<>$psd1) {
	$msg='两次输入密码不一致';
}else {
	if($username=='') {
		$msg='用户名太短';
	}else {
		if(!preg_match("/^[a-z][a-z0-9_]+$/",$username)){
				adminmsg('','用户名名只能为字母或字母与数字组合',1);
		}
		$psd=password_md5($psd);
		$pagecount = $GLOBALS['db'] -> fetchcount("SELECT count(id) FROM ".tableex('admin')." where username='$username'");
		if($pagecount>0) {
			$msg='已存在该用户名';
		}else {
			$query = $GLOBALS['db'] -> query("INSERT INTO `".tableex('admin')."` (`username` ,`nickname`,`psd`,`alevel`,`power`,`kind`) VALUES ('$username','$nickname','$psd','".$quan['alevel']."','$thispower','0');");
			if($query) {
				$msg='添加成功';
			}else {
				$msg='添加失败';
			}
		}
	}
}
adminmsg('?do=user',$msg,3);
?>


