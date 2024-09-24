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
if(stripos($id,'_')===false) {
	$cid=intval($_GET['cid']);
	$link =adminchannel($cid);
	if($link['ifshowadmin']==0) {adminmsg('','此栏目已经禁用');}
	$csetting=json_decode($link['csetting'],1);
	if(isset($csetting['listnodel']) && $csetting['listnodel']==1) {die('error');}//禁止删除
	if(empty($articletable)) {
		if(isset($csetting['articletable'])) {$articletable=$csetting['articletable'];}else {die('栏目表名未知');}
	}
	$id=intval($_GET['id']);
	$thiscid = $GLOBALS['db'] -> fetchcount("SELECT cid FROM $articletable where id='$id' limit 1");
	//禁止删除
	$link =adminchannel($thiscid);
	$csetting=json_decode($link['csetting'],1);
	if(isset($csetting['listnodel']) && $csetting['listnodel']==1) {adminmsg('','禁止删除');}//禁止删除
	if(!power('s',$cid,$power,3)) {adminmsg('','无权限');}//用户没有删除权限
	if($thiscid && power('s',$thiscid,$power)) {//有权限
		$delsql='';//如果栏目开通了普通用户只能管理自己的文章
		if(power('sadmin',0) || power('s',$cid,$power,5)) {}else {if(isset($csetting['listadminuid']) && $csetting['listadminuid']==1) {$delsql=" and adminuid='$myadminuid'";}}//普通用户只能编辑自己的文章
		$thisid=$id;
		run_admin_hook($cid,'delete');
		$query = $GLOBALS['db'] -> query("delete from `$articletable` WHERE id='$id' and cid='$thiscid'$delsql");
		if($query) {
			$msg="删除成功";
			$thisid=$id;//把id给thisid
			run_admin_hook($cid,'deleted');
		}else {
			$msg="删除失败";
		}
		if(!isset($_SERVER["HTTP_REFERER"])) {$_SERVER["HTTP_REFERER"]='';}
		adminmsg($_SERVER["HTTP_REFERER"],$msg,1);
	}else {
		die('error');
	}
	
}else {
	$ids=explode('_',$id);
	$cid=intval($_GET['cid']);
	$link =adminchannel($cid);
	if($link['ifshowadmin']==0) {adminmsg('','此栏目已经禁用');}
	$csetting=json_decode($link['csetting'],1);
	if(isset($csetting['listnodel']) && $csetting['listnodel']==1) {adminmsg('','禁止删除');}//禁止删除
	if(empty($articletable)) {
		if(isset($csetting['articletable'])) {$articletable=$csetting['articletable'];}else {die('栏目表名未知');}
	}
	if(!power('s',$cid,$power,3)) {adminmsg('','无权限');}//用户没有删除权限
	$delsql='';//如果栏目开通了普通用户只能管理自己的文章
	if(power('sadmin',0) || power('s',$cid,$power,5)) {}else {if(isset($csetting['listadminuid']) && $csetting['listadminuid']==1) {$delsql=" and adminuid='$myadminuid'";}}//普通用户只能编辑自己的文章
	foreach ($ids as $value) 
	{
		$value=intval($value);
		$thisid=$value;
		run_admin_hook($cid,'delete');
		$query = $GLOBALS['db'] -> query("delete from `$articletable` WHERE id='$value' and cid='$cid'$delsql");
		if($query) {
			$thisid=$value;//把当前value给thisid,方便del函数调用
			run_admin_hook($cid,'deleted');
		}
	}
	if(!isset($_SERVER["HTTP_REFERER"])) {$_SERVER["HTTP_REFERER"]='';}
	adminmsg($_SERVER["HTTP_REFERER"],'删除成功',1);
}
?>

