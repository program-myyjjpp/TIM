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
$strcid=intval($_POST['strcid']);
$neworder = $GLOBALS['db'] -> fetchcount("SELECT strorder FROM ".tableex('str')." where strcid='$strcid' order by strorder desc limit 1");
if(!$neworder) {
	$neworder=0;
}
$msg='';
$ssetting=dbstr(json_encode(array('filterhtml'=>1)));//默认的html代码过滤规则 0不过滤 1过滤危险代码 2禁用代码 对超级管理员无效
if(isset($_POST['strname'])) {
	foreach($_POST['strname'] as $key=>$val) {
		if(!empty($_POST['strname'][$key])) {
			$strname=trim(dbstr($_POST['strname'][$key]));
			if($_POST['strorder'][$key]=='') {
				$strorder=$neworder+5;
				$neworder=$strorder;
			}else {
				$strorder=intval($_POST['strorder'][$key]);
			}
			$inputkind=intval($_POST['inputkind'][$key]);
			$pagecount = $GLOBALS['db'] -> fetchcount("SELECT count(id) FROM ".tableex('str')." where strname='$strname' and strcid='$strcid'");
			if($pagecount>0) {
				$msg.=$strname.':已存在该变量 ';
			}else{
				if(stripos($strname,'.')===false) {
					$query = $GLOBALS['db'] -> query("INSERT INTO `".tableex('str')."` (`strname`,`strcid`,`strorder`,`inputkind`,`strvalue`,`ifadmin`,`ssetting`) VALUES ('$strname','$strcid','$strorder','$inputkind','','0','$ssetting');");
					if(!$query) {
						$msg.=$strname.':增加失败 ';
					}
				}else {
					$msg.=$strname.':变量名不合法 ';
				}
			}
		}
	}
}
if(!isset($_SERVER["HTTP_REFERER"])) {$_SERVER["HTTP_REFERER"]='';}
$url=$_SERVER["HTTP_REFERER"];
if(empty($msg)) {
	$msg='增加成功';
	adminmsg($url,$msg,1);
}else {
	adminmsg($url,$msg,10);
}


?>
