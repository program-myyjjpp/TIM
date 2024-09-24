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
checktoken();
$msg='修改成功';
$GLOBALS['db'] -> begin(); 
foreach ($_POST as $key => $value) 
{
	$poststr=explode('_',$key);
	if(isset($poststr[1]) && is_numeric($poststr[1])) {
		$thisid=intval($poststr[1]);
		$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('str')." where id='$thisid' and inputkind>0;");
		$link = $GLOBALS['db'] -> fetchone($query);
		if($link) {
			$thisssetting=json_decode($link['ssetting'],1);
			$cid=$link['strcid'];
			if(!power('s',$cid,$power,4)) {adminmsg('','无权限');}
			if($link['ifadmin']==1 && !power('s',$cid,$power,5)) {
				adminmsg('',$link['strname'].'无权限');
			}
			$thischannel =adminchannel($cid);
			if($cid>0 && $thischannel['ifshowadmin']==0) {adminmsg('','此栏目已经禁用');}
			unset($thisarray);
			$thisarray=array('mkind'=>$link['inputkind'],'mname'=>$key,'msetting'=>$link['ssetting'],'strarray'=>$link['strarray']);
			$value=inputvalue($thisarray);
			if(isset($thisssetting['regular']) && strlen($thisssetting['regular'])>3) {
				if(!preg_match($thisssetting['regular'],$value)){
					adminmsg('',$link['strname'].' 输入有误',3);
				}
			}
			if(isset($thisssetting['lenmin']) && is_numeric($thisssetting['lenmin']) && $thisssetting['lenmin']>0) {
				if(strlen($value)<$thisssetting['lenmin']) {
					adminmsg('',$link['strname'].' 输入太短',3);
				}
			}
			if(isset($thisssetting['lenmax']) && is_numeric($thisssetting['lenmax']) && $thisssetting['lenmax']>0) {
				if(strlen($value)>$thisssetting['lenmax']) {
					adminmsg('',$link['strname'].' 输入太长',3);
				}
			}
			$value=dbstr($value);
			$strname=dbstr($link['strname']);
			$query = $GLOBALS['db'] -> query("UPDATE ".tableex('str')." SET strvalue='$value' WHERE strname='".$strname."' and strcid='$cid';");
			if($query) {
				if($link['ifbind']==1) {//如果该值绑定到栏目,前台链接栏目,修改栏目value
					$query = $GLOBALS['db'] -> query("UPDATE ".tableex('channel')." SET cvalue='$value' WHERE cid='$cid'");
				}
				cachedel($strname.'_'.$cid,'str');
				run_admin_hook($cid,'stredited');
				$msg='修改成功';
			}else {
				$msg='修改失败';
			}
		}
	}
}
$GLOBALS['db'] -> commit(); 
if(!isset($_SERVER["HTTP_REFERER"])) {$_SERVER["HTTP_REFERER"]='';}
adminmsg($_SERVER["HTTP_REFERER"],$msg,3);
?>
