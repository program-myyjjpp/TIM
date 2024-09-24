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
if(!isset($_GET['key'])) {die('参数错误');}else {$key=$_GET['key'];}
if(isset($default_channel_setting[$key])) {
	$channeldata=$default_channel_setting[$key];
}else {
	$channeldata=cacheget($key,3600*12,'channel_in');
}

function cineditjs_jsformat($str)
{
	$str = trim($str);
	$str = str_replace('\\s\\s', '\\s', $str);
	$str = str_replace(chr(10), '', $str);
	$str = str_replace(chr(13), '', $str);
	$str = str_replace('    ', '', $str);
	$str = str_replace('\\', '\\\\', $str);
	$str = str_replace('"', '\\"', $str);
	$str = str_replace('\\\'', '\\\\\'', $str);
	$str = str_replace("'", "\'", $str);
	return $str;
}
header('Content-Type: application/x-javascript; charset=UTF-8');
if($channeldata==false) {
	echo('alert("栏目配置导入失败,请重新上传");');
	$channeldata='';
	$js_info='载入失败,请重新上传';
	$js_moudle='载入失败,请重新上传';
	$js_str='载入失败,请重新上传';
}else {
	$channelarray=json_decode(base64_decode($channeldata),1);
	if(!isset($channelarray['info']) && !isset($channelarray['moudle']) && !isset($channelarray['str'])) {
		$channeldata='';
		echo('alert("栏目配置文件有误,请重新导出后再试");');
		$js_info='载入失败,请确认文件是否正常';
		$js_moudle='载入失败,请确认文件是否正常';
		$js_str='载入失败,请确认文件是否正常';
	}else {
		if(isset($channelarray['info'])) {
			$js_info='<label><input type=checkbox name=info value=1>导入栏目配置</label>';
		}else {
			$js_info='无配置信息';
		}
		if(isset($channelarray['moudle']) && count($channelarray['moudle'])>0) {
			$js_moudle='';
			foreach($channelarray['moudle'] as $val) {
				$js_moudle.='<label><input type=checkbox name=moudle['.intval($val['id']).'] value=1>'.cineditjs_jsformat($val['minfo']).'['.cineditjs_jsformat($val['mname']).']</label>';
			}
		}else {
			$js_moudle='无栏目字段';
		}
		if(isset($channelarray['str']) && count($channelarray['str'])>0) {
			$js_str='';
			foreach($channelarray['str'] as $val) {
				$js_str.='<label><input type=checkbox name=str['.intval($val['id']).'] value=1>'.cineditjs_jsformat($val['strname']).'</label>';
			}
		}else {
			$js_str='无栏目变量';
		}
	}
?>
var channeldata="<?php echo($channeldata);?>";
document.getElementById("channeldata").value=channeldata;
document.getElementById("channel_info").innerHTML="<?php echo($js_info);?>";
document.getElementById("channel_moudle").innerHTML="<?php echo($js_moudle);?>";
document.getElementById("channel_str").innerHTML="<?php echo($js_str);?>";
<?php
}
?>