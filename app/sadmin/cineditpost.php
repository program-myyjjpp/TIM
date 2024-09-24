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
if(isset($_POST['cid'])) {
	$GLOBALS['db'] -> begin(); 
	$cid=intval($_POST['cid']);
	if($cid>0) {
		$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('channel')." where cid='$cid'");
		$thischannel = $GLOBALS['db'] -> fetchone($query);
		if(!$thischannel) {
			adminmsg('','栏目不存在',1);
		}
		$channel_name=$thischannel['cname'];
		$setting=json_decode($thischannel['csetting'],1);
		if(isset($setting['articletable']) && !empty($setting['articletable'])) {
			$thisarticletable=$setting['articletable'];
		}else {
			$thisarticletable=false;
		}
	}
	$channeldata=$_POST['channeldata'];
	$channelarray=json_decode(base64_decode($channeldata),1);
	if(!isset($channelarray['info']) && !isset($channelarray['moudle']) && !isset($channelarray['str'])) {
		adminmsg('','读取配置文件出错',1);
	}
	if(isset($channelarray['info']) && isset($_POST['info'])) {
		$newchannelinfo=array();
		if(stripos($channel_name,'临时栏目')===false) {

		}else {
			if(isset($channelarray['info']['cname']) && !empty($channelarray['info']['cname'])) {$newchannelinfo['cname']=dbstr(htmlspecialchars($channelarray['info']['cname'],ENT_QUOTES));}
		}
		if(isset($channelarray['info']['fid']) && !empty($channelarray['info']['fid'])) {
			$channelarray['info']['fid']=dbstr($channelarray['info']['fid']);
			$fidcid = $GLOBALS['db'] -> one("SELECT cid FROM ".tableex('channel')." where cname='".$channelarray['info']['fid']."' limit 1");
			if(isset($fidcid['cid'])) {
				//$newchannelinfo['fid']=intval($fidcid['cid']); 
			}
		}
		if(isset($channelarray['info']['cvalue']) && !empty($channelarray['info']['cvalue'])) {$newchannelinfo['cvalue']=dbstr($channelarray['info']['cvalue']);}
		if(isset($channelarray['info']['ckind']) && !empty($channelarray['info']['ckind'])) {$newchannelinfo['ckind']=dbstr($channelarray['info']['ckind']);}else {$newchannelinfo['ckind']=1;}
		if(isset($channelarray['info']['ifshow']) && !empty($channelarray['info']['ifshow'])) {$newchannelinfo['ifshow']=dbstr($channelarray['info']['ifshow']);}else {$newchannelinfo['ifshow']=0;}
		if(isset($channelarray['info']['ifshownav']) && !empty($channelarray['info']['ifshownav'])) {$newchannelinfo['ifshownav']=dbstr($channelarray['info']['ifshownav']);}else {$newchannelinfo['ifshownav']=0;}
		if(isset($channelarray['info']['ifshowadmin'])) {$newchannelinfo['ifshowadmin']=dbstr($channelarray['info']['ifshowadmin']);}else {$newchannelinfo['ifshowadmin']=1;}
		if(isset($channelarray['info']['ifshowleft'])) {$newchannelinfo['ifshowleft']=dbstr($channelarray['info']['ifshowleft']);}else {$newchannelinfo['ifshowleft']=1;}
		if(isset($channelarray['info']['newwindow']) && !empty($channelarray['info']['newwindow'])) {$newchannelinfo['newwindow']=dbstr($channelarray['info']['newwindow']);}else {$newchannelinfo['newwindow']=0;}

		$temp_setting=json_decode($channelarray['info']['csetting'],1);
		if(isset($temp_setting['articletable']) && !empty($temp_setting['articletable'])) {
			$thisarticletable=$temp_setting['articletable'];
		}else {
			$temp_setting['articletable']=$thisarticletable;
		}
		$channelarray['info']['csetting']=json_encode($temp_setting);
		if(isset($channelarray['info']['csetting'])) {$newchannelinfo['csetting']=dbstr($channelarray['info']['csetting']);}

		$query = $GLOBALS['db'] -> update(tableex('channel'),"cid='$cid'",$newchannelinfo);
		if(!$query) {
			adminmsg('','导入栏目配置信息失败',1);
		}
	}
	
	if(isset($_POST['moudle']) && isset($channelarray['moudle'])) {
		$insetcount=0;
		foreach($channelarray['moudle'] as $thismoudle) {
			if(isset($_POST['moudle'][$thismoudle['id']])) {
				$thismname=dbstr($thismoudle['mname']);
				$pagecount = $GLOBALS['db'] -> fetchcount("SELECT count(id) FROM ".tableex('moudle')." where cid='$cid' and mname='$thismname';");
				if($pagecount==0) {
					$insetcount++;
					$thismoudlearray=array();
					$thismoudlearray['cid']=$cid;
					$thismoudlearray['ifcreated']=0;
					if(isset($thismoudle['fid'])) {$thismoudlearray['fid']=dbstr($thismoudle['fid']);}else {$thismoudlearray['fid']='';}
					if(isset($thismoudle['mname'])) {$thismoudlearray['mname']=dbstr($thismoudle['mname']);}else {$thismoudlearray['mname']='';}
					if(isset($thismoudle['minfo'])) {$thismoudlearray['minfo']=dbstr($thismoudle['minfo']);}else {$thismoudlearray['minfo']='';}
					if(isset($thismoudle['mcontent'])) {$thismoudlearray['mcontent']=dbstr($thismoudle['mcontent']);}else {$thismoudlearray['mcontent']='';}
					if(isset($thismoudle['mkind']) && !empty($thismoudle['mkind'])) {$thismoudlearray['mkind']=dbstr($thismoudle['mkind']);}else {$thismoudlearray['mkind']=1;}
					if(isset($thismoudle['morder']) && !empty($thismoudle['morder'])) {$thismoudlearray['morder']=dbstr($thismoudle['morder']);}else {$thismoudlearray['morder']=1;}
					if(isset($thismoudle['ifshow']) && !empty($thismoudle['ifshow'])) {$thismoudlearray['ifshow']=dbstr($thismoudle['ifshow']);}else {$thismoudlearray['ifshow']=0;}
					if(isset($thismoudle['ifonly']) && !empty($thismoudle['ifonly'])) {$thismoudlearray['ifonly']=dbstr($thismoudle['ifonly']);}else {$thismoudlearray['ifonly']=0;}
					if(isset($thismoudle['ifadmin']) && !empty($thismoudle['ifadmin'])) {$thismoudlearray['ifadmin']=dbstr($thismoudle['ifadmin']);}else {$thismoudlearray['ifadmin']=0;}
					if(isset($thismoudle['ifmore']) && !empty($thismoudle['ifmore'])) {$thismoudlearray['ifmore']=dbstr($thismoudle['ifmore']);}else {$thismoudlearray['ifmore']=0;}
					if(isset($thismoudle['hide']) && !empty($thismoudle['hide'])) {$thismoudlearray['hide']=dbstr($thismoudle['hide']);}else {$thismoudlearray['hide']=0;}
					if(isset($thismoudle['ifshowtemp'])) {$thismoudlearray['ifshowtemp']=dbstr($thismoudle['ifshowtemp']);}else {$thismoudlearray['ifshowtemp']='';}
					if(isset($thismoudle['strarray'])) {$thismoudlearray['strarray']=dbstr($thismoudle['strarray']);}else {$thismoudlearray['strarray']='';}
					if(isset($thismoudle['strdefault'])) {$thismoudlearray['strdefault']=dbstr($thismoudle['strdefault']);}else {$thismoudlearray['strdefault']='';}
					if(isset($thismoudle['mfunction'])) {$thismoudlearray['mfunction']=dbstr($thismoudle['mfunction']);}else {$thismoudlearray['mfunction']='';}
					if(isset($thismoudle['msetting'])) {$thismoudlearray['msetting']=dbstr($thismoudle['msetting']);}else {$thismoudlearray['msetting']='';}
					$thisid = $GLOBALS['db'] -> insert(tableex('moudle'),$thismoudlearray);
				}
			}
		}
		if(isset($_POST['createtable']) && $insetcount>0) {
			if($thisarticletable!=false) {
				$createreturn=channeltable($cid,$thisarticletable);
				if($createreturn===true || $createreturn=='no') {
					$query = $GLOBALS['db'] -> query("UPDATE ".tableex('moudle')." SET ifcreated='1' WHERE cid='$cid'");
				}else {
					adminmsg('','数据库中创建字段失败',1);
				}
			}
		}
	}
	if(isset($_POST['str']) && isset($channelarray['str'])) {
		foreach($channelarray['str'] as $thisstr) {
			if(isset($_POST['str'][$thisstr['id']])) {
				$thisstrname=dbstr($thisstr['strname']);
				$pagecount = $GLOBALS['db'] -> fetchcount("SELECT count(id) FROM ".tableex('str')." where strcid='$cid' and strname='$thisstrname';");
				if($pagecount==0) {
					$thisstrarray=array();
					$thisstrarray['strcid']=$cid;
					if(isset($thisstr['strname'])) {$thisstrarray['strname']=dbstr($thisstr['strname']);}else {$thisstrarray['strname']='';}
					if(isset($thisstr['strinfo'])) {$thisstrarray['strinfo']=dbstr($thisstr['strinfo']);}else {$thisstrarray['strinfo']='';}
					if(isset($thisstr['strstyle'])) {$thisstrarray['strstyle']=dbstr($thisstr['strstyle']);}else {$thisstrarray['strstyle']='';}
					if(isset($thisstr['ifshow']) && !empty($thisstr['ifshow'])) {$thisstrarray['ifshow']=dbstr($thisstr['ifshow']);}else {$thisstrarray['ifshow']=0;}
					if(isset($thisstr['ifbind']) && !empty($thisstr['ifbind'])) {$thisstrarray['ifbind']=dbstr($thisstr['ifbind']);}else {$thisstrarray['ifbind']=0;}
					if(isset($thisstr['ifadmin']) && !empty($thisstr['ifadmin'])) {$thisstrarray['ifadmin']=dbstr($thisstr['ifadmin']);}else {$thisstrarray['ifadmin']=0;}
					if(isset($thisstr['inputkind']) && !empty($thisstr['inputkind'])) {$thisstrarray['inputkind']=dbstr($thisstr['inputkind']);}else {$thisstrarray['inputkind']=1;}
					if(isset($thisstr['strorder']) && !empty($thisstr['strorder'])) {$thisstrarray['strorder']=dbstr($thisstr['strorder']);}else {$thisstrarray['strorder']=1;}
					if(isset($thisstr['strarray'])) {$thisstrarray['strarray']=dbstr($thisstr['strarray']);}else {$thisstrarray['strarray']='';}
					if(isset($thisstr['ssetting'])) {$thisstrarray['ssetting']=dbstr($thisstr['ssetting']);}else {$thisstrarray['ssetting']='';}
					if(isset($thisstr['strtip'])) {$thisstrarray['strtip']=dbstr($thisstr['strtip']);}else {$thisstrarray['strtip']='';}
					if(isset($thisstr['strvalue']) && !empty($thisstr['strvalue'])) {$thisstrarray['strvalue']=dbstr($thisstr['strvalue']);}else {
						$thisstrarray['strvalue']='';
						if($thisstr['strname']=='栏目标题') {$thisstrarray['strvalue']=dbstr($channel_name);}
					}
					$thisid = $GLOBALS['db'] -> insert(tableex('str'),$thisstrarray);
				}
			}
		}
	}
	$GLOBALS['db'] -> commit(); 
	channelrouter();
	cachedel('channelscache','channel');
	cachedel('channelcache_'.$cid,'channel');
	if($cid==0) {
		adminmsg('?do=sadmin_sbasic','导入完成',1);
	}
	if($_POST['cinkind']==1 || $_POST['cinkind']==0) {
		adminmsg('?do=sadmin_cedit&cid='.$cid,'导入完成',1,'配置页面');
	}
	if($_POST['cinkind']==2) {
		adminmsg('?do=sadmin_aindex&cid='.$cid,'导入完成',1,'配置页面');
	}
	if($_POST['cinkind']==3) {
		adminmsg('?do=sadmin_sbasic&cid='.$cid,'导入完成',1,'配置页面');
	}
	exit();
	
}
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere">后台管理<b>></b><strong>栏目配置</strong> </div>   <div id="mainBox">
     <h3>
<a href="?do=sadmin" class="actionBtn" style="margin-left:10px"><em>返回</em></a>导入完成
 </h3>
<?php

?>
	
	</div>
</div>

