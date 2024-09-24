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
$cid=intval($_POST['cid']);
if(!$cid>0) {die('no id');}
$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('channel')." where cid='$cid' limit 1");
$oldinfo = $GLOBALS['db'] -> fetchone($query);
$oldsetting=json_decode($oldinfo['csetting'],1);
if(!isset($oldsetting['articletable'])) {$oldsetting['articletable']='';}
$fid=intval($_POST['fid']);
//fid不能为自己或子栏目
$sonfids=getsoncid($cid);
if($cid==$fid || in_array($fid,$sonfids)) {
	adminmsg('','不能将上级栏目设置为本栏目或栏目下属子栏目',1);
}
function getsoncid($fid) {
	global $channels;
	$array=array();
	foreach($channels as $key=>$val) {
		if($val['fid']==$fid) {
			$array[]=$val['cid'];
			$sonarray=getsoncid($val['cid']);
			foreach($sonarray as $key=>$val) {
				$array[]=$val;
			}
		}
	}
	Return $array;
}
$cname=dbstr($_POST['cname']);
isset($_POST['ifshowadmin']) ? $ifshowadmin=1 :$ifshowadmin=0;
isset($_POST['ifshowleft']) ? $ifshowleft=1 :$ifshowleft=0;
$corder=intval($_POST['corder']);
$ckind=intval($_POST['ckind']);
if(!$ckind>0) {die('no ckind');}

$csetting=$oldsetting;
$newwindow=0;
$ifshow=0;
$ifshownav=0;
isset($_POST['cnote']) ? $csetting['cnote']=htmlspecialchars($_POST['cnote']) :'';
//前台其他页面
$otherpagearray=array();
if(isset($_POST['otherpageurl'])) {
	foreach($_POST['otherpageurl'] as $key=>$val) {
		if(strlen($_POST['otherpageurl'][$key])>0) {
			$otherpagearray[]=array('uri'=>postroutercheck($_POST['otherpageurl'][$key],1),'res'=>postroutercheck($_POST['otherpagetemplate'][$key]),'cache'=>intval($_POST['otherpagecache'][$key]));
		}
	}
}
//独立域名
if(isset($_POST['channeldomain'])) {
	$_POST['channeldomain']=trim($_POST['channeldomain']);
	$_POST['channeldomain']=str_replace('http://','',$_POST['channeldomain']);
	$_POST['channeldomain']=str_replace('/','',$_POST['channeldomain']);
	$csetting['channel_domain']=postroutercheck($_POST['channeldomain']);
}else {
	$csetting['channel_domain']='';
}
$csetting['otherpage']=json_encode($otherpagearray);
if($ckind==1) {
	//编辑器单页
	$cvalue=$oldinfo['cvalue'];
	isset($_POST['newwindow1']) ? $newwindow=1 :$newwindow=0;
	isset($_POST['ifshow1']) ? $ifshow=0 :$ifshow=1;
	isset($_POST['ifshownav1']) ? $ifshownav=1 :$ifshownav=0;
	isset($_POST['channel_url1']) ? $csetting['channel_url']=postroutercheck($_POST['channel_url1'],1) :$csetting['channel_url']='';
	isset($_POST['channel_urlcache1']) ? $csetting['channel_urlcache']=intval($_POST['channel_urlcache1']) :$csetting['channel_urlcache']=0;
	isset($_POST['template1']) ? $csetting['template']=postroutercheck($_POST['template1']) :$csetting['template']='';
}elseif($ckind==2) {
	$cvalue=$oldinfo['cvalue'];
	//文章列表
	//文章表
	if(isset($_POST['articletable'])) {
		if(strlen($_POST['articletable'])>0) {
			$_POST['articletable']=strtolower($_POST['articletable']);
			if(!admintablecheck($_POST['articletable'])) {adminmsg('','数据库表表名只能为字母数字下划线组合',1);}
		}
		if($_POST['articletable']==tableex('admin') || $_POST['articletable']==tableex('channel') || $_POST['articletable']==tableex('moudle') || $_POST['articletable']==tableex('str')) {
			adminmsg('','数据库表表名与系统表冲突,请更换',1);
		}
		$csetting['articletable']=$_POST['articletable'];
	}else {die();}
	
	//添加
	isset($_POST['listnoadd']) ? $csetting['listnoadd']=1 :$csetting['listnoadd']=0;
	//编辑
	isset($_POST['listnoedit']) ? $csetting['listnoedit']=1 :$csetting['listnoedit']=0;
	//删除
	isset($_POST['listnodel']) ? $csetting['listnodel']=1 :$csetting['listnodel']=0;
	//复制
	isset($_POST['listcopy']) ? $csetting['listcopy']=1 :$csetting['listcopy']=0;
	//转移
	isset($_POST['listarticlemove']) ? $csetting['listarticlemove']=1 :$csetting['listarticlemove']=0;
	//显示文章用户
	isset($_POST['listshowadminname']) ? $csetting['listshowadminname']=1 :$csetting['listshowadminname']=0;
	//默认显示父分类
	isset($_POST['listfidshow']) ? $csetting['listfidshow']=1 :$csetting['listfidshow']=0;
	//文章限定
	isset($_POST['listadminuid']) ? $csetting['listadminuid']=1 :$csetting['listadminuid']=0;
	//前台设定
	isset($_POST['newwindow2']) ? $newwindow=1 :$newwindow=0;
	isset($_POST['ifshow2']) ? $ifshow=0 :$ifshow=1;
	isset($_POST['ifshownav2']) ? $ifshownav=1 :$ifshownav=0;
	
	isset($_POST['channel_url2']) ? $csetting['channel_url']=postroutercheck($_POST['channel_url2'],1) :$csetting['channel_url']='';
	isset($_POST['channel_pageurl']) ? $csetting['channel_pageurl']=postroutercheck($_POST['channel_pageurl'],1) :$csetting['channel_pageurl']='';
	isset($_POST['channel_articleurl']) ? $csetting['channel_articleurl']=postroutercheck($_POST['channel_articleurl'],1) : '';

	isset($_POST['channel_urlcache2']) ? $csetting['channel_urlcache']=intval($_POST['channel_urlcache2']) :$csetting['channel_urlcache']=0;
	isset($_POST['channel_pageurlcache']) ? $csetting['channel_pageurlcache']=intval($_POST['channel_pageurlcache']) :$csetting['channel_pageurlcache']=0;
	isset($_POST['channel_articleurlcache']) ? $csetting['channel_articleurlcache']=intval($_POST['channel_articleurlcache']) :$csetting['channel_articleurlcache']=0;
	isset($_POST['template2']) ? $csetting['template']=postroutercheck($_POST['template2']) :$csetting['template']='';
	isset($_POST['templatelist']) ? $csetting['templatelist']=postroutercheck($_POST['templatelist']) :$csetting['templatelist']='';
	isset($_POST['templatearticle']) ? $csetting['templatearticle']=postroutercheck($_POST['templatearticle']) :$csetting['templatearticle']='';

	isset($_POST['temppage_size']) ? $csetting['temppage_size']=intval($_POST['temppage_size']) : '';
	isset($_POST['temppage_order']) ? $csetting['temppage_order']=trim($_POST['temppage_order']) : '';
}elseif($ckind==3) {
	isset($_POST['newwindow3']) ? $newwindow=1 :$newwindow=0;
	isset($_POST['ifshow3']) ? $ifshow=0 :$ifshow=1;
	isset($_POST['ifshownav3']) ? $ifshownav=1 :$ifshownav=0;
	$cvalue=dbstr($_POST['cvalue']);
	$ifbindstr = $GLOBALS['db'] -> fetchcount("SELECT count(id) FROM ".tableex('str')." where strcid='$cid' and ifbind='1'");
	if($ifbindstr<1) {
		$query = $GLOBALS['db'] -> query("INSERT INTO `".tableex('str')."` (`strname`,`strcid`,`strorder`,`inputkind`,`strvalue`,`ifbind`) VALUES ('$cname','$cid','1','1','','1');");
	}
	$query = $GLOBALS['db'] -> query("UPDATE `".tableex('str')."` SET strvalue='$cvalue' WHERE strcid='$cid' and ifbind='1'");
}elseif($ckind==4) {
	isset($_POST['newwindow4']) ? $newwindow=1 :$newwindow=0;
	$cvalue=dbstr($_POST['cvalue1']);
}elseif($ckind==5) {
	isset($_POST['newwindow5']) ? $newwindow=1 :$newwindow=0;
	isset($_POST['ifshow5']) ? $ifshow=0 :$ifshow=1;
	isset($_POST['ifshownav5']) ? $ifshownav=1 :$ifshownav=0;
	$cvalue=get_transit_channel($cid);//获得下属第一个栏目的网址
}else {

}
$strarraysql=dbstr(json_encode($csetting));
$query = $GLOBALS['db'] -> query("UPDATE ".tableex('channel')." SET 
cvalue='$cvalue',cname='$cname',fid='$fid',ifshow='$ifshow',ifshownav='$ifshownav',ifshowadmin='$ifshowadmin',ifshowleft='$ifshowleft',newwindow='$newwindow',
ckind='$ckind',corder='$corder',csetting='$strarraysql' WHERE cid='$cid'");
if($query) {
	if(!isset($_SERVER["HTTP_REFERER"])) {$_SERVER["HTTP_REFERER"]='';}
	$url=$_SERVER["HTTP_REFERER"];
		if(channelrouter()==false) {
			adminmsg('','写入栏目缓存失败',1);
		}
		$msg='修改成功';
		if(!transit_channel_cache()) {
			$msg.=',更新过渡栏目网址失败';
		}
		cachedel('channelscache','channel');
		cachedel('channelcache_'.$cid,'channel');
}else {
		$msg='修改失败';
		$url='';
	}
	adminmsg($url,$msg,1,'编辑页');
?>
