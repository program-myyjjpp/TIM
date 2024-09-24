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
if(!isset($_GET['cid'])) {die();}
$cid=intval($_GET['cid']);
if(!empty($_FILES['txt']['error']))
{
	die('上传错误');
}else {
	$str=file_get_contents($_FILES['txt']['tmp_name']);
	$strs=json_decode($str,1);
	if(count($strs)==0) {
		echo('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">');
		echo('<script type="text/javascript">alert("格式错误");</script>');
		echo("<meta http-equiv=refresh content='0; url=?do=sadmin_aindex&cid=".$cid."'>");
		die();
	}
	foreach($strs as $value) {
		$mname=dbstr($value['mname']);
		$pagecount = $GLOBALS['db'] -> fetchcount("SELECT count(id) FROM ".tableex('moudle')." where cid='$cid' and mname='$mname';");
		if($pagecount>0) {
			
		}else {
			if(is_numeric($value['fid']) && $value['fid']<>0 && $value['fid']<>null) {
				foreach($strs as $values) {
					if($value['fid']==$values['id']) {
						$thisfidname=dbstr($values['mname']);
						$thisfid = $GLOBALS['db'] -> fetchcount("SELECT id FROM ".tableex('moudle')." where cid='$cid' and mname='".$values['mname']."';");
						if($thisfid) {
						}else {
							$thisfid=0;
						}
					}
				}
			}else {
				$thisfid=0;
			}
			$fid=$thisfid;
			$mname=dbstr($value['mname']);
			$minfo=dbstr($value['minfo']);
			$mkind=dbstr($value['mkind']);
			$morder=dbstr($value['morder']);
			$ifshow=dbstr($value['ifshow']);
			$ifadmin=dbstr($value['ifadmin']);
			$ifmore=dbstr($value['ifmore']);
			$mcontent=dbstr($value['mcontent']);
			$ifshowtemp=dbstr($value['ifshowtemp']);
			$hide=dbstr($value['hide']);
			$strarray=dbstr($value['strarray']);
			$strdefault=dbstr($value['strdefault']);
			$mfunction=dbstr($value['mfunction']);
			$query = $GLOBALS['db'] -> query("INSERT INTO `".tableex('moudle')."` (`fid`,`mname` ,`minfo`,`mkind`,`morder`,`cid`,`ifshow`,`ifmore`,`mcontent`,`ifshowtemp`,`hide`,`strarray`,`strdefault`,`mfunction`) 
			VALUES ('$fid','$mname','$minfo','$mkind','$morder','$cid','$ifshow','$ifmore','$mcontent','$ifshowtemp','$hide','$strarray','$strdefault','$mfunction');");
		}
	}
	echo("<meta http-equiv=refresh content='0; url=?do=sadmin_aindex&cid=".$cid."'>");
}
die();
?>

