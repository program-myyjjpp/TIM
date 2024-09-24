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
$id=intval($_POST['id']);
$strcid=intval($_POST['strcid']);
$strorder=intval($_POST['strorder']);
$strname=dbstr(trim($_POST['strname']));
if(stripos($strname,'.')===false) {
}else {
	adminmsg('','变量名中不能包含(.)',1);
}
$inputkind=intval($_POST['inputkind']);
$pagecount = $GLOBALS['db'] -> fetchcount("SELECT count(id) FROM ".tableex('str')." where strname='$strname' and id<>'$id' and strcid='$strcid' and inputkind>0");
if($pagecount>0) {
	adminmsg('','变量名重复',1);
}
if(isset($_POST['ifbind'])) {
	$ifbind=1;
	$pagecount = $GLOBALS['db'] -> fetchcount("SELECT count(id) FROM ".tableex('str')." where strcid='$strcid' and ifbind='1' and id<>'$id' and inputkind>0");
	if($pagecount>0) {
		adminmsg('','一个栏目下只能有一个绑定的变量',1);
	}
}else {$ifbind=0;}
if(isset($_POST['ifadmin'])) {
	$ifadmin=1;
}else {
	$ifadmin=0;
}
$strtip=dbstr($_POST['strtip']);
$strstyle=dbstr($_POST['strstyle']);
$ssetting=dbstr(json_encode($_POST['ssetting']));

$strfrom=0;
foreach($inputkindarray as $val) {
	if($inputkind==$val['id'] && isset($val['strfrom'])) {
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
		adminmsg('','函数名有误',3);
	}
}else {
	$strarray='';
}


$query = $GLOBALS['db'] -> query("UPDATE ".tableex('str')." SET strname='$strname',inputkind='$inputkind',strstyle='$strstyle',strorder='$strorder',strtip='$strtip',strarray='$strarray',ifbind='$ifbind',ifadmin='$ifadmin',ssetting='$ssetting' WHERE id='$id'");

if($query) {
	$msg='修改成功,<a href="?do=sadmin_sbasic&cid='.$strcid.'">返回列表页</a>';
	if(!isset($_SERVER["HTTP_REFERER"])) {$_SERVER["HTTP_REFERER"]='';}
	$url=$_SERVER["HTTP_REFERER"];
}else {
	$msg='修改失败';
	$url='';
}
adminmsg($url,$msg,3,'配置页');
?>
