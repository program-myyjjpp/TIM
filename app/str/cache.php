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
if(power('alevel')!=3) {adminmsg('','无权限',1);}
checktoken();
$filecount=0;
if(!transit_channel_cache()) {
	adminmsg('','更新过渡栏目网址失败',1);
}
if(deldir(CacheDir)) {
	if(channelrouter()==false) {
		adminmsg('','写入路由配置失败',1);
	}
	adminmsg('','清空成功',1);
}else {
	adminmsg('','清空失败',1);
}
function deldir($dir) {
	global $filecount;
	@$dh=opendir($dir);
	if(!$dh) {
		adminmsg('','无法打开缓存目录,请设置目录权限',1);
	}
	while ($file=readdir($dh)) {
		if($file!="." && $file!="..") {
			$fullpath=$dir."/".$file;
			if(!is_dir($fullpath)) {
				unlink($fullpath);
				$filecount++;
				if($filecount>250) {
					closedir($dh);
					echo('<script type="text/javascript">document.write("&nbsp;缓存文件较多,清除中,请稍等...");window.location.reload();</script>');
					exit;
				}
			} else {
				deldir($fullpath);
			}
		}
	}
	closedir($dh);
	if($dir!==CacheDir) {
		if(@rmdir($dir)) {
			$filecount++;
			return true;
		} else {
			adminmsg('','无法删除缓存目录'.$dir.',请设置目录权限',1);
			return false;
		}
	}
	Return true;
	
}