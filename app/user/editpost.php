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
$id=intval($_POST['id']);
$nickname=dbstr(trim(htmlspecialchars($_POST['nickname'])));
$username = $GLOBALS['db'] -> fetchcount("SELECT username FROM `".tableex('admin')."` where id='$id' and alevel<='$alevel' limit 1");
if(!$username) {
	adminmsg('','用户不存在',3);
}
$psd=trim($_POST['psd']);
if(strlen($psd)>0) {
	$psd1=trim($_POST['psd1']);
	if($psd<>$psd1) {
		adminmsg('','两次输入密码不一致');
	}
}
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
	if(power('alevel')==3) {//超级管理员可以添加任意类型用户
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
	if(stripos($_SERVER['HTTP_REFERER'],'?do=user_edit')===false) {
		die('error referer');
	}
}
$sql='';
if($psd<>'') {
	$psd=password_md5($psd);
	$sql.=",psd='".$psd."'";
}
if(isset($_POST['ucmsid'])) {
	$sql.=",ucmsid=''";
}
//系统中必须有一个超级管理员
if($quan['alevel']<3) {
	$superadmincount = $GLOBALS['db'] -> fetchcount("SELECT count(id) FROM `".tableex('admin')."` where id<>'$id' and alevel='3'");
	if($superadmincount<1) {
		adminmsg('','系统必须拥有一位超级管理员',3);
	}
}
$thisname=getadminname();
if($username==$thisname) {
	if(!isset($quan['b'][1])) {
		adminmsg('','不能停用自己的账户',3);
	}
	if($quan['alevel']<>power('alevel')) {
		adminmsg('','不能修改自己的账户类型',3);
	}
}

$query = $GLOBALS['db'] -> query("UPDATE ".tableex('admin')." SET nickname='$nickname',alevel='".$quan['alevel']."',power='$thispower'$sql WHERE id='$id'");
if($query) {
	$msg='修改成功';
}else {
	$msg='修改失败';
}

adminmsg('?do=user_edit&id='.$id,$msg,3);
?>

