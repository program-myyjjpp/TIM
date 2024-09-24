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
$cid=intval($_POST['cid']);
checktoken();
$link =adminchannel($cid);
if($link['ifshowadmin']==0) {adminmsg('','此栏目已经禁用');}
$csetting=json_decode($link['csetting'],1);
if(isset($csetting['listnoedit']) && $csetting['listnoedit']==1) {adminmsg('','禁止编辑');}
if(!power('s',$cid,$power,2)) {adminmsg('','无权限');}
//文章来源表
if(isset($_GET['articletable']) && !empty($_GET['articletable'])) {
	$articletable=dbstr($_GET['articletable']);
	$articletableuri='&articletable='.$articletable;
}else {
	$articletableuri='';
	if(isset($csetting['articletable'])) {$articletable=$csetting['articletable'];}else {die('栏目表名未知');}
}
if(!admintablecheck($articletable)) {adminmsg('','栏目表名有误');}
$id=intval($_POST['id']);
$delsql='';//如果栏目开通了普通用户只能管理自己的文章
if(power('sadmin',0) || power('s',$cid,$power,5)) {}else {if(isset($csetting['listadminuid']) && $csetting['listadminuid']==1) {$delsql=" and adminuid='$myadminuid'";}}//普通用户只能编辑自己的文章
$query = $GLOBALS['db'] -> query("SELECT * FROM $articletable where id='$id'$delsql limit 1");
$link = $GLOBALS['db'] -> fetchone($query);
if(!$link) {adminmsg('','文章不存在');}
$cid=$link['cid'];
$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('channel')." where cid='$cid' limit 1");
$link = $GLOBALS['db'] -> fetchone($query);
$csetting=json_decode($link['csetting'],1);
if(isset($csetting['listnoedit']) && $csetting['listnoedit']==1) {adminmsg('','禁止编辑');}
if(power('sadmin',0) || power('s',$cid,$power,5)) {$thissql='';}else {$thissql=" and ifadmin<>'1'";}//不是管理员则不要管理员字段
$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('moudle')." where hide<>'1' and ifcreated='1' and cid='$cid'$thissql order by morder asc");
$moudle = $GLOBALS['db'] -> fetchall($query);
$order=0;
$fid=0;
$posttime=time();
run_admin_hook($cid,'editpost');

$sql1='';
foreach ($moudle as $value) 
{
	$thismoudlevalue=dbstr(inputvalue($value));
	$thismsetting=json_decode($value['msetting'],1);
	$thismsetting['ifonly']=$value['ifonly'];
	$thismsetting['tablename']=$articletable;
	$acheck=acheck($value['mname'],$thismoudlevalue,$cid,$thismsetting,$id);
	if($acheck==='error') {adminmsg('',$value['minfo'].' 输入有误',3);}
	if($acheck==='short') {adminmsg('',$value['minfo'].' 输入太短',3);}
	if($acheck==='long') {adminmsg('',$value['minfo'].' 输入太长',3);}
	if($acheck==='exist') {adminmsg('',$value['minfo'].': '.htmlspecialchars($thismoudlevalue).' 已存在',3);}
	$sql1.=$value['mname'].'='."'".$thismoudlevalue."',";
}

$query = $GLOBALS['db'] -> query("UPDATE $articletable SET $sql1 cid='$cid' WHERE id='$id' and cid='$cid'");
if($query) {
	$refererurl='?do=list&cid='.$cid.$articletableuri;
	if(isset($_GET['articlemname'])) {
		$articlemname=(htmlspecialchars($_GET['articlemname']));
		if(isset($_GET['articlechoose'])) {
			$refererurl.='&articlechoose='.htmlspecialchars($_GET['articlechoose']).'&articlemname='.$articlemname;
		}elseif(isset($_GET['articleschoose'])) {
			$refererurl.='&articleschoose='.htmlspecialchars($_GET['articleschoose']).'&articlemname='.$articlemname;
		}elseif(isset($_GET['allarticleschoose'])) {
			$refererurl.='&allarticleschoose='.htmlspecialchars($_GET['allarticleschoose']).'&articlemname='.$articlemname;
		}
	}
	if(isset($_GET['moudleid']) && isset($_GET['fid'])) {
		$refererurl.='&moudleid='.htmlspecialchars($_GET['moudleid']).'&fid='.intval($_GET['fid']);
	}
	$msg='编辑成功,<a href="'.$_SERVER["HTTP_REFERER"].'">继续编辑</a>,<a href="'.$refererurl.'">返回列表页</a>';
	$thisid=$id;
	run_admin_hook($cid,'editposted');
	adminmsg($_SERVER["HTTP_REFERER"],$msg,5,'编辑页');
}else {
	$msg='编辑失败,更新数据库失败';
	adminmsg('',$msg);
}
?>
