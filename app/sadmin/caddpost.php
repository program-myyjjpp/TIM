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
if(isset($_POST['multiple_add'])) {
	foreach($_POST['cname'] as $key=>$val) {
		$cname=dbstr(trim(htmlspecialchars($val,ENT_QUOTES)));
		if(empty($cname)) {
			$cname='临时栏目';
		}
		$ckind=intval($_POST['ckind'][$key]);
		$fid=intval($_POST['fid'][$key]);
		$corder=intval($_POST['corder'][$key]);
		$defaultcsetting=array();
		if($ckind==1 || $ckind==2) {
			//栏目页
			$defaultcsetting['channel_url']='/(cid)/';
			$defaultcsetting['template']='page.php';
			if($ckind==2) {
				$defaultcsetting['template']='list.php';
			}
			$defaultcsetting['channel_urlcache']='0';
			//列表页
			$defaultcsetting['channel_pageurl']='/(cid)/page_(page).html';
			$defaultcsetting['templatelist']='list.php';
			$defaultcsetting['channel_pageurlcache']='0';
			//文章页
			$defaultcsetting['channel_articleurl']='/(cid)/(id).html';
			$defaultcsetting['templatearticle']='article.php';
			$defaultcsetting['channel_articleurlcache']='0';
			if(defined('ArticleTable')) {
				$defaultcsetting['articletable']=ArticleTable;
			}else {
				$defaultcsetting['articletable']=tableex('table_'.$lastid.'_'.rand(1000,9999));
			}
			$defaultcsetting['temppage_size']=15;
			$defaultcsetting['temppage_order']='id desc';
			$defaultcsetting['listadminuid']=1;
		}
		$defaultcsetting=json_encode($defaultcsetting);
		$query = $GLOBALS['db'] -> query("INSERT INTO `".tableex('channel')."` (`fid`,`cname`,`ckind`,`corder`,`ifshow`,`ifshownav`,`ifshowadmin`,`ifshowleft`,`csetting`) VALUES ('$fid','$cname','$ckind','$corder','1','1','1','1','$defaultcsetting');");
		if($query) {
			$lastid=$GLOBALS['db']->lastId();
			//如果是链接,创建一个该栏目的str
			if($ckind==3) {
				$query = $GLOBALS['db'] -> query("INSERT INTO `".tableex('str')."` (`strname`,`strcid`,`strorder`,`inputkind`,`strvalue`,`ifbind`) VALUES ('网址','$lastid','1','1','','1');");
			}
		}
		
	}
	channelrouter();
	adminmsg('?do=sadmin','栏目增加成功,请在各个栏目内增加相应的字段与变量',10);
}
$cname=dbstr(trim(htmlspecialchars($_POST['cname'],ENT_QUOTES)));
$fid=intval($_POST['fid']);
if(!isset($_FILES['txt'])) {
	if(empty($cname)) {
		adminmsg('','栏目名太短',1);
	}
}else {
	if(empty($cname)) {
		$cname='临时栏目_'.rand(999,9999);
	}
}
$ckind=intval($_POST['ckind']);

$order = $GLOBALS['db'] -> fetchcount("SELECT corder FROM ".tableex('channel')." order by corder desc limit 1");
if($order) {
	$corder=$order+5;
}else {
	$corder=5;
}
$ifshowleft=1;
$query = $GLOBALS['db'] -> query("INSERT INTO `".tableex('channel')."` (`fid`,`cname`,`ckind`,`corder`,`ifshow`,`ifshownav`,`ifshowadmin`,`ifshowleft`) VALUES ('$fid','$cname','$ckind','$corder','1','1','1','$ifshowleft');");
if($query) {
	$lastid=$GLOBALS['db']->lastId();
	//修改新的栏目的默认设置
	$defaultcsetting=array();
	$cvalue='';
	if($ckind==1 || $ckind==2) {
		//父栏目域名
		$fidsetting=$GLOBALS['db'] -> one("SELECT csetting FROM ".tableex('channel')." where cid='$fid' limit 1");
		if($fidsetting) {
			$fidsettingarray=json_decode($fidsetting[0],1);
			if(isset($fidsettingarray['channel_domain']) && strlen($fidsettingarray['channel_domain'])>0) {
				$defaultcsetting['channel_domain']=$fidsettingarray['channel_domain'];
			}
		}
		//栏目页
		$defaultcsetting['channel_url']='/(cid)/';
		$defaultcsetting['template']='page.php';
		if($ckind==2) {
			$defaultcsetting['template']='list.php';
		}
		$defaultcsetting['channel_urlcache']='0';
		//列表页
		$defaultcsetting['channel_pageurl']='/(cid)/page_(page).html';
		$defaultcsetting['templatelist']='list.php';
		$defaultcsetting['channel_pageurlcache']='0';
		//文章页
		$defaultcsetting['channel_articleurl']='/(cid)/(id).html';
		$defaultcsetting['templatearticle']='article.php';
		$defaultcsetting['channel_articleurlcache']='0';
		if(defined('ArticleTable')) {
			$defaultcsetting['articletable']=ArticleTable;
		}else {
			$defaultcsetting['articletable']=tableex('table_'.$lastid.'_'.rand(1000,9999));
		}
		$defaultcsetting['temppage_size']=15;
		$defaultcsetting['temppage_order']='id desc';
		$defaultcsetting['listadminuid']=1;
	}
	$defaultcsetting=json_encode($defaultcsetting);
	$query1 = $GLOBALS['db'] -> query("UPDATE ".tableex('channel')." SET csetting='$defaultcsetting' WHERE cid='$lastid'");
	if($query1) {
		$url='?do=sadmin_cedit&cid='.$lastid;
		$msg='添加成功,清空缓存后才能在前台显示';
		channelrouter();
	}else {
		$msg='添加栏目成功,修改栏目信息失败';
		$url='';
	}
	if($lastid>0 && isset($_POST['key']) && strlen($_POST['key'])>5) {
		echo('<script type="text/javascript">window.location.href = "?do=sadmin_cinedit&cid='.$lastid.'&key='.htmlspecialchars($_POST['key']).'";</script>');
		die();
	}
	if($lastid>0)
	{
		$settingfile_copy=intval($_POST['settingfile_copy']);
		$settingfile=intval($_POST['settingfile']);
		if($settingfile==2 && empty($_FILES['txt']['error'])) {
			$str=file_get_contents($_FILES['txt']['tmp_name']);
			if($str) {
				$keyname='my_channel_in'.time().rand(100,999);
				$savestr=cacheset($keyname,$str,3600*12,'channel_in');
				if($savestr) {
					echo('<script type="text/javascript">window.location.href = "?do=sadmin_cinedit&cid='.$lastid.'&key='.$keyname.'";</script>');
					exit();
				}else {
					$msg.=' 您关闭了缓存,不能导入栏目配置';
				}
			}else {
				$msg.=' 读取栏目配置文件失败';
			}
		}elseif($settingfile==1 && $ckind==1) {
			$keyname='default_1';
			echo('<script type="text/javascript">window.location.href = "?do=sadmin_cinedit&cid='.$lastid.'&key='.$keyname.'";</script>');
			exit();
		}elseif($settingfile==1 && $ckind==2) {
			$keyname='default_2';
			echo('<script type="text/javascript">window.location.href = "?do=sadmin_cinedit&cid='.$lastid.'&key='.$keyname.'";</script>');
			exit();
		}elseif($settingfile==3 && ($fid>0 || $settingfile_copy>0)) {
			if($settingfile_copy==0) {$settingfile_copy=$fid;}
			$fidinfo = $GLOBALS['db'] -> one("SELECT * FROM ".tableex('channel')." where cid='$settingfile_copy'");
			if(!$fidinfo) {
				adminmsg('','指定的栏目已不存在');
			}
			$channeldata=array();
			$fidinfo['fid']=$fid;
			$channeldata['info']=$fidinfo;
			$moudles = $GLOBALS['db'] -> all("SELECT * FROM ".tableex('moudle')." where cid='$settingfile_copy' order by morder asc");
			foreach($moudles as $key=>$thismoudle) {
				foreach($thismoudle as $key1=>$val) {
					if(is_numeric($key1)) {
						unset($moudles[$key][$key1]);
					}
				}
				unset($moudles[$key]['ifcreated']);
			}
			$channeldata['moudle']=$moudles;
			$strs = $GLOBALS['db'] -> all("SELECT * FROM ".tableex('str')." where strcid='$settingfile_copy' order by strorder asc");
			foreach($strs as $key=>$thisstr) {
				foreach($thisstr as $key1=>$val) {
					if(is_numeric($key1)) {
						unset($strs[$key][$key1]);
					}
				}
			}
			$channeldata['str']=$strs;
			$keyname='my_channel_in'.time().rand(100,999);
			$str=base64_encode(json_encode($channeldata));
			$savestr=cacheset($keyname,$str,3600*12,'channel_in');
			if($savestr) {
				echo('<script type="text/javascript">window.location.href = "?do=sadmin_cinedit&cid='.$lastid.'&key='.$keyname.'";</script>');
				exit();
			}else {
				$msg.=' 您关闭了缓存,不能导入栏目配置';
			}
		}
		
		//如果是单页或链接,创建一个该栏目的str
		if($ckind==1) {
			$query = $GLOBALS['db'] -> query("INSERT INTO `".tableex('str')."` (`strname`,`strcid`,`strorder`,`inputkind`,`strvalue`,`ifbind`) VALUES ('内容','$lastid','1','4','','0');");
		}elseif($ckind==3) {
			$query = $GLOBALS['db'] -> query("INSERT INTO `".tableex('str')."` (`strname`,`strcid`,`strorder`,`inputkind`,`strvalue`,`ifbind`) VALUES ('网址','$lastid','1','1','','1');");
		}
		
	}
}else {
		$msg='添加失败';
		$url='';
}
adminmsg($url,$msg,3);
?>
