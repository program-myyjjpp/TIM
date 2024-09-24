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
$mid=intval($_POST['mid']);
$mname=dbstr(strtolower(trim($_POST['mname'])));
if(!preg_match("/^[a-z][a-z0-9_]+$/",$mname)){
	adminmsg('','字段名只能为字母或字母+数字',1);
}
if(strlen($mname)<1) {
	adminmsg('','字段名太短',1);
}
if(strlen($mname)>20) {
	adminmsg('','字段名太长',1);
}
if(in_array($mname,$notallowfield)) {adminmsg('','字段名冲突,请不要使用保留的字段名',1);}
if(strlen($mname)<1) {die('too short');}
$minfo=dbstr($_POST['minfo']);
$cid=intval($_POST['cid']);
$mkind=intval($_POST['mkind']);
$morder=intval($_POST['morder']);
if(isset($_POST['ifshow'])) {$ifshow=1;}else {$ifshow=0;}
if(isset($_POST['ifonly'])) {$ifonly=1;}else {$ifonly=0;}
if(isset($_POST['ifadmin'])) {$ifadmin=1;}else {$ifadmin=0;}
if(isset($_POST['hide'])) {$hide=1;}else {$hide=0;}
if(isset($_POST['ifmore'])) {$ifmore=1;}else {$ifmore=0;}
$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('channel')." where cid='$cid' limit 1");
$link = $GLOBALS['db'] -> fetchone($query);
$csetting=json_decode($link['csetting'],1);
$pagecount = $GLOBALS['db'] -> fetchcount("SELECT count(id) FROM ".tableex('moudle')." where mname='$mname' and cid='$cid' and id<>'$mid'");
if($pagecount>0) {
	adminmsg('','已存在该字段',3);
}
	if(!isset($_POST['fid'])) {
		$fid='';
	}else {
		$fid=dbstr($_POST['fid']);
	}
	$ifshowtemp=dbstr($_POST['ifshowtemp']);
	$msetting=dbstr(json_encode($_POST['msetting']));
	$mcontent=dbstr($_POST['mcontent']);
	$mfunction=dbstr($_POST['mfunction']);
	$strdefault=dbstr($_POST['strdefault']);

	$strfrom=0;
	foreach($inputkindarray as $val) {
		if($mkind==$val['id'] && isset($val['strfrom'])) {
			$strfrom=$val['strfrom'];
		}
	}
	
	if($strfrom==1) {
		$strarray0=intval($_POST['strarray0']);
		$strarray1=dbstr($_POST['strarray1']);
		if(!preg_match("/^[a-z][a-z0-9_]+$/",$strarray1) && !empty($strarray1)) {
			die('error');
		}
		$strarray=$strarray0.'|'.$strarray1;
	}elseif($strfrom==2) {
		$strarray=dbstr($_POST['strarray2']);
		if(!preg_match("/^[a-zA-Z][a-zA-Z0-9_]+$/",$strarray) && !empty($strarray)) {
			adminmsg('','函数名有误',5);
		}
	}else {
		$strarray='';
	}
	
	
	$oldmname = $GLOBALS['db'] -> fetchcount("SELECT mname FROM ".tableex('moudle')." where id='$mid';");
	$query = $GLOBALS['db'] -> query("UPDATE ".tableex('moudle')." SET fid='$fid',hide='$hide',ifadmin='$ifadmin',ifonly='$ifonly',ifmore='$ifmore',strdefault='$strdefault',mfunction='$mfunction',mname='$mname',minfo='$minfo',mcontent='$mcontent',mkind='$mkind',morder='$morder',ifshow='$ifshow',ifshowtemp='$ifshowtemp',strarray='$strarray',msetting='$msetting' WHERE id='$mid'");
	if($query) {
		if($oldmname<>$mname) {
			$query = $GLOBALS['db'] -> query("UPDATE ".tableex('moudle')." SET ifcreated='0' WHERE id='$mid'");
			$query = $GLOBALS['db'] -> query("UPDATE ".tableex('moudle')." SET fid='$mname' WHERE fid='$oldmname' and cid='$cid'");
		}
		if(!isset($_SERVER["HTTP_REFERER"])) {$_SERVER["HTTP_REFERER"]='';}
		adminmsg($_SERVER["HTTP_REFERER"],'修改成功,<a href="?do=sadmin_aindex&cid='.$cid.'">返回列表页</a>',3,'配置页');
	}else {
		adminmsg('','修改失败',3);
	}
?>
