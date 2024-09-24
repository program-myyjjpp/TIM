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


$start_time=microtime(true);
require('../config/database.php');
require('chk.php');
define('admin', true);
newtoken(10);
if(isset($_GET['do']) && isset($_GET['nohtml'])) {
	if(isset($_GET['do'])) {$thisdo=explode('_',$_GET['do']);}
	if(!isset($thisdo[1])) {$thisdo[1]='index';}
	check_admin_file($thisdo[0],$thisdo[1]);
	require($thisdo[0].'/'.$thisdo[1].'.php');
	die();
}
function check_admin_file($dir,$file) {
	if(!preg_match("/^[a-z\d]{1,25}$/i",$dir)){
		die('file error');
	}
	if(!preg_match("/^[a-z\d]{1,25}$/i",$file)){
		die('file error');
	}
	if(!is_file($dir.'/'.$file.'.php')) {
		die('file not exist');
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>后台管理中心</title>
<meta name="referrer" content="origin-when-cross-origin">
<link href="img/admin.css" rel="stylesheet" type="text/css">
<script src="img/jquery.min.js"></script>
<script src="img/js.js"></script>
<script type="text/javascript">cmsversion='<?php echo(version);?>';</script>
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
<meta name="renderer" content="webkit">
<link rel="shortcut icon" href="img/ico.ico" >
</head>
<body>
<?php
if(isset($_GET['do'])) {
	$thisdo=explode('_',$_GET['do']);
}
?>
<?php require('top.php');?>
<?php 
	if(isset($_GET['do'])) {
		if(!isset($thisdo[1])) {
			$thisdo[1]='index';
		}
		check_admin_file($thisdo[0],$thisdo[1]);
		require($thisdo[0].'/'.$thisdo[1].'.php');
	}else {
			if(power('s',0,$power)){
				echo("<meta http-equiv=refresh content='0; url=?do=str'>");
				exit();
			}
			foreach($channels as $value){
				if(power('s',$value['cid'])) {
					if($value['ckind']==1 || $value['ckind']==3) {
						$firsturl='?do=str&cid='.$value['cid'];
					}
					if($value['ckind']==2) {
						$firsturl='?do=list&cid='.$value['cid'];
					}
					if($value['ckind']==4) {
						if($value['newwindow']!=1) {
							$firsturl=$value['cvalue'];
						}
					}
					break;
				}
			}
			if(isset($firsturl)) {
				echo("<meta http-equiv=refresh content='0; url=$firsturl'>");
				exit();
			}
		
	}
?>
 <div class="clear"></div>
<div id="UFooter">
  <?php
	$end_time=microtime(true);
	$total_time=substr($end_time-$start_time,0,5);
	if($total_time=="0.000") {$total_time="0.001";}
  ?>
  &copy;<a href="http://uuu.la" target="_blank">UCMS <?php echo(version);?></a>. Processed in <?php echo($total_time);?> second(s),<?php echo($GLOBALS['db']->querynum++);?>  queries 
  <?php //未授权请勿去掉版权,详情请见http://uuu.la/services/ ?>
</div>
<div class="clear"></div> </div>
</body>
</html>
