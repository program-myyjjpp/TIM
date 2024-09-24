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
if(isset($_POST['cid'])) {
	$cid=intval($_POST['cid']);
}else {
	adminmsg('','参数有误,请重新提交',3);
}
checktoken();
if(!power('s',$cid,$power,1)) {adminmsg('','无权限');}
$link =adminchannel($cid);
if($link['ifshowadmin']==0) {adminmsg('','此栏目已经禁用');}
$cname=$link['cname'];
$csetting=json_decode($link['csetting'],1);
//文章来源表
if(isset($_GET['articletable']) && !empty($_GET['articletable'])) {
	$articletable=dbstr($_GET['articletable']);
	$articletableuri='&articletable='.$articletable;
}else {
	$articletableuri='';
	if(isset($csetting['articletable'])) {$articletable=$csetting['articletable'];}else {die('栏目表名未知');}
}
if(!admintablecheck($articletable)) {adminmsg('','栏目表名有误');}
if(isset($csetting['listnoadd']) && $csetting['listnoadd']==1) {adminmsg('','禁止增加');}
if(power('sadmin',0) || power('s',$cid,$power,5)) {
	$thissql='';
	$hidemoudle=array();
}else {
	$thissql=" and ifadmin<>'1'";
	$hidemoudle = $GLOBALS['db'] -> all("SELECT * FROM ".tableex('moudle')." where hide<>'1' and ifcreated='1' and ifadmin='1' and cid='$cid'  order by morder asc");
}
$moudle = $GLOBALS['db'] -> all("SELECT * FROM ".tableex('moudle')." where hide<>'1' and ifcreated='1' and cid='$cid'$thissql order by morder asc");
$order=0;
$fid=0;
$posttime=time();
run_admin_hook($cid,'addpost');

$sql1='';
$sql2='';
foreach ($moudle as $value) 
{
	$thismoudlevalue=inputvalue($value);
	$thismsetting=json_decode($value['msetting'],1);
	$thismsetting['ifonly']=$value['ifonly'];
	$thismsetting['tablename']=$articletable;
	$acheck=acheck($value['mname'],$thismoudlevalue,$cid,$thismsetting);
	if($acheck==='error') {adminmsg('',$value['minfo'].' 输入有误',3);}
	if($acheck==='short') {adminmsg('',$value['minfo'].' 输入太短',3);}
	if($acheck==='long') {adminmsg('',$value['minfo'].' 输入太长',3);}
	if($acheck==='exist') {adminmsg('',$value['minfo'].': '.htmlspecialchars($thismoudlevalue).' 已存在',3);}
	$sql1.=',`'.$value['mname'].'`';
	$sql2.=",'".dbstr($thismoudlevalue)."'";
}
//非管理员提交时管理员字段值为默认值
foreach($hidemoudle as $value) {
	$thismsetting=json_decode($value['msetting'],1);
	$thismoudlevalue=$value['strdefault'];
	$sql1.=',`'.$value['mname'].'`';
	$sql2.=",'".dbstr($thismoudlevalue)."'";
}
if(power('alevel')!=3) {unset($_POST['uuu_addcsarticle']);}
if(isset($_POST['uuu_addcsarticle'])) {
	//增加测试文章
	$addtimes=intval($_POST['uuu_addcsarticle']);
	if($addtimes>1000) {
		$addtimes=1000;
	}
	$GLOBALS['db'] -> begin();
	for ($i=1;$i<=$addtimes;$i++) {  
		$sql1='';
		$sql2='';
		 foreach ($moudle as $value) 
		{
			$sql1.=',`'.$value['mname'].'`';

			if($value['mname']=='title' && $value['mkind']<3) {
				$sql2.=",'".dbstr(inputvalue($value)).rand(1000,2000)."'";
			}else {
				$sql2.=",'".dbstr(inputvalue($value))."'";
			}
		}
		$query = $GLOBALS['db'] -> query("INSERT INTO `$articletable` (`posttime`,`cid`,`adminuid`$sql1) VALUES ('$posttime','$cid','$myadminuid'$sql2);");
	}
	$GLOBALS['db'] -> commit();
}else {
	$query = $GLOBALS['db'] -> query("INSERT INTO `$articletable` (`posttime`,`cid`,`adminuid`$sql1) VALUES ('$posttime','$cid','$myadminuid'$sql2);");
}

if($query) {
	$thisid=$GLOBALS['db'] ->lastId();
	$listurl='?do=list&cid='.$cid.$articletableuri;
	$nextaddurl='?do=list_add&cid='.$cid.$articletableuri;
	if(isset($csetting['listcopy']) && $csetting['listcopy']==1) {
		$copyurl=',<a href="?do=list_add&cid='.$cid.'&id='.$thisid.$articletableuri.'">复制此文章</a>';
	}else {
		$copyurl='';
	}
	if(isset($_GET['articlemname'])) {
		$articlemname=(htmlspecialchars($_GET['articlemname']));
		if(isset($_GET['articlechoose'])) {
			$listurl.='&articlechoose='.htmlspecialchars($_GET['articlechoose']).'&articlemname='.$articlemname;
			$nextaddurl.='&articlechoose='.htmlspecialchars($_GET['articlechoose']).'&articlemname='.$articlemname;
		}elseif(isset($_GET['articleschoose'])) {
			$listurl.='&articleschoose='.htmlspecialchars($_GET['articleschoose']).'&articlemname='.$articlemname;
			$nextaddurl.='&articleschoose='.htmlspecialchars($_GET['articleschoose']).'&articlemname='.$articlemname;
		}elseif(isset($_GET['allarticleschoose'])) {
			$listurl.='&allarticleschoose='.htmlspecialchars($_GET['allarticleschoose']).'&articlemname='.$articlemname;
			$nextaddurl.='&allarticleschoose='.htmlspecialchars($_GET['allarticleschoose']).'&articlemname='.$articlemname;
		}
	}
	if(isset($_GET['moudleid']) && isset($_GET['fid'])) {
		$listurl.='&moudleid='.htmlspecialchars($_GET['moudleid']).'&fid='.intval($_GET['fid']);
		$nextaddurl.='&moudleid='.htmlspecialchars($_GET['moudleid']).'&fid='.intval($_GET['fid']);
	}
	if(isset($_POST['uuu_addcsarticle'])) { 
		$msg='提交成功'.',<a href="'.$listurl.'">返回列表页</a>';
		run_admin_hook($cid,'addposted');
		adminmsg($listurl,$msg,3,'列表页');
	}else {
		$editpageurl='?do=list_edit&id='.$thisid.'&cid='.$cid.$articletableuri;
		$msg='提交成功'.',<a href="'.$listurl.'">返回列表页</a>';
		if((isset($csetting['listnoedit']) && $csetting['listnoedit']==0) && power('s',$cid,$power,2)) {
			$msg.=',<a href="'.$editpageurl.'">编辑此文章</a>';
		}
		$msg.=',<a href="'.$nextaddurl.'">继续增加</a>'.$copyurl;
		run_admin_hook($cid,'addposted');
		adminmsg($editpageurl,$msg,5,'列表页');
	}
}else {
	$msg='提交失败,文章插入时数据库发生错误';
	adminmsg('',$msg);
}

?>