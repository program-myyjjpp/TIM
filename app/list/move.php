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
$id=$_GET['id'];
checktoken();
//文章来源表
if(isset($_GET['articletable']) && !empty($_GET['articletable'])) {
	$articletable=dbstr($_GET['articletable']);
	$articletableuri='&articletable='.$articletable;
}else {
	$articletableuri='';
	$articletable='';
}
if(!admintablecheck($articletable)) {adminmsg('','栏目表名有误');}
$ids=explode('_',$id);
$cid=intval($_GET['cid']);
$targetcid=intval($_GET['targetcid']);

$link =adminchannel($cid);
if($link['ifshowadmin']==0) {adminmsg('','此栏目已经禁用');}
$csetting=json_decode($link['csetting'],1);
if(isset($csetting['listnoedit']) && $csetting['listnoedit']==1) {adminmsg('','栏目文章已禁止编辑');}
if(!isset($csetting['listarticlemove']) || $csetting['listarticlemove']==0) {adminmsg('','禁止转移');}
if(empty($articletable)) {
	if(isset($csetting['articletable'])) {$articletable=$csetting['articletable'];}else {die('栏目表名未知');}
}
if(!power('s',$cid,$power,2)) {adminmsg('','无权限');}//用户没有编辑权限
$delsql='';//如果栏目开通了普通用户只能管理自己的文章
if(power('sadmin',0) || power('s',$cid,$power,5)) {}else {if(isset($csetting['listadminuid']) && $csetting['listadminuid']==1) {$delsql=" and adminuid='$myadminuid'";}}//普通用户只能编辑自己的文章

//目标栏目
$targetlink =adminchannel($targetcid);
if($targetlink['ifshowadmin']==0) {adminmsg('','目标栏目已经禁用');}
$targetcsetting=json_decode($targetlink['csetting'],1);
if(!isset($targetcsetting['listarticlemove']) || $targetcsetting['listarticlemove']==0) {adminmsg('','目标栏目未开启文章转移');}
if(!isset($targetcsetting['articletable']) ) {adminmsg('','目标栏目表名未知');}
if($targetcsetting['articletable']<>$articletable) {
	adminmsg('','来源栏目数据库表与目标栏目数据库表不一致');
}
if(isset($targetcsetting['listnoadd']) && $targetcsetting['listnoadd']==1) {adminmsg('','目标栏目禁止增加');}
if(!power('s',$targetcid,$power,1)) {adminmsg('','没有目标栏目增加权限');}

$msg='转移成功';
foreach ($ids as $value) 
{
	$value=intval($value);
	$query = $GLOBALS['db'] -> query("UPDATE $articletable SET cid='$targetcid' WHERE id='$value' and cid='$cid'$delsql");
	if($query) {
		$thisid=$value;//把当前value给thisid,方便del函数调用
		run_admin_hook($cid,'move');
	}else {
		$msg.=$value.' 转移失败 ';
	}
}
if(!isset($_SERVER["HTTP_REFERER"])) {$_SERVER["HTTP_REFERER"]='';}
adminmsg($_SERVER["HTTP_REFERER"],$msg,1);
?>

