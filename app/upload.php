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


require('../config/database.php');
require 'chk.php';
$filedomain='';//文件域名前缀例:http://www.baidu.com,不需要/结尾
$allowfileext=array();
foreach($ext_arr as $val) {
	foreach($val as $thisext) {
		$allowfileext[]=$thisext;
	}
}
if(isset($_POST['picsize'])) {
	$picsize=htmlspecialchars($_POST['picsize']);
}elseif(isset($_GET['picsize'])) {
	$picsize=htmlspecialchars($_GET['picsize']);
}else {
	$picsize='';
}

if(strtolower($_SERVER['REQUEST_METHOD'])=='post') {
	$ifpost=true;
}else {
	$ifpost=false;
}
if(isset($_GET['inputname']) && stripos($_GET['inputname'],'_multiple_upload')>0) {
	$multiple_upload=true;
}else {
	$multiple_upload=false;
}
if($ifpost==false) {
	if(isset($_GET['inputname'])) {
		$_GET['inputname']=htmlspecialchars($_GET['inputname']);
	}else {
		die('error');
	}
	if(isset($_GET['buttonvalue'])) {
		$buttonvalue=htmlspecialchars($_GET['buttonvalue']);
	}else {
		$buttonvalue='选择文件';
	}
	$jsstr='';
	foreach($allowfileext as $thisext) {
		$jsstr.='(filename.indexOf(".'.$thisext.'") == -1) && ';
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上传</title>
<style>
body{overflow-x:hidden;overflow-y:hidden;overflow:hidden;margin:0px;padding:0px;background:#F9F9F9}
#uploadfileform{display:none}
#uploadbutton{font-size:14px;line-height:34px;cursor:pointer}
</style>
<!--[if lt IE 10]>
<style>
#uploadfileform{display:block}
#imgFile{width:70px;height:30px;display:block;float:left;}
#uploadbutton{display:none}
#uploadtips{display:block;float:left;line-height:20px;margin-top:10px;}
</style>
<![endif]-->
</head>
<body  scroll=no>
<div class="uploadarea">
<form method=post enctype="multipart/form-data" action="?inputname=<?php echo($_GET['inputname']);?>" id="uploadfileform">
<input type="hidden" id="picsize" name="picsize" value="<?php echo($picsize);?>"/>

<?php
if($multiple_upload) {
?>
	<input type="file" id="imgFile" name="imgFile[]" onchange="gouploadfile();"  multiple="multiple"/>
<?php
}else {
?>
	<input type="file" id="imgFile" name="imgFile" onchange="gouploadfile();"/>
<?php
}
?>
<span  id="uploadtips"><?php if($buttonvalue<>'选择文件') {echo($buttonvalue);}?></span>
</form>
<label for="imgFile" id="uploadbutton" onClick="iframeuploadfile();"><?php echo($buttonvalue);?></label>
</div>
<script type="text/javascript">
function iframeuploadfile(){
	document.getElementById('uploadtips').innerText="上传中...";
}
function gouploadfile(){
	var filename=document.getElementById('imgFile').value.toLowerCase();
	if (<?php echo($jsstr);?> 1==1)
	{
		alert('该文件不允许上传');
		return false;
	}
	document.getElementById('uploadbutton').innerText="上传中...";
	document.getElementById('uploadfileform').submit();
}
</script>
</body>
</html>
<?php
	die();
}

$save_path =SystemRoot.UploadDir.DIRECTORY_SEPARATOR;
$save_url = $filedomain.SystemDir.UploadDir.'/';
$max_size = 100000000;//文件最大尺寸
$save_path = realpath($save_path) . '/';


if(!isset($_FILES['imgFile'])) {
	alert('上传错误');
}
$allfiles=array();
if(is_array($_FILES['imgFile']['name'])) {
	foreach($_FILES['imgFile']['name'] as $key=>$val) {
		$allfiles[]=array(
			'name'=>$_FILES['imgFile']['name'][$key],
			'type'=>$_FILES['imgFile']['type'][$key],
			'tmp_name'=>$_FILES['imgFile']['tmp_name'][$key],
			'error'=>$_FILES['imgFile']['error'][$key],
			'size'=>$_FILES['imgFile']['size'][$key],
			);
	}
}else {
	$allfiles[]=$_FILES['imgFile'];
}
if(count($allfiles)==0) {
	alert('上传错误。');
}
if (@is_dir($save_path) === false) {
	alert("上传目录不存在。");
}
if (@is_writable($save_path) === false) {
	alert("上传目录没有写权限。");
}
$allerror='';
foreach($allfiles as $filekey=>$thisfile) {
	$thisfile['error']=ucms_fileupload_error($thisfile);
	$thisfile['save_path']=$save_path;
	$thisfile['save_url']=$save_url;
	if(empty($thisfile['name'])) {
		$thisfile['error']='未知文件名。';
	}
	if (@is_uploaded_file($thisfile['tmp_name']) === false) {
		$thisfile['error']='上传失败。';
	}
	if ($thisfile['size'] > $max_size) {
		$thisfile['error']='上传文件大小超过限制。';
	}
	if ($thisfile['size'] ==0) {
		$thisfile['error']='上传文件大小有误。';
	}

	$temp_arr = explode(".", $thisfile['name']);
	$file_ext = array_pop($temp_arr);
	$file_ext = strtolower(trim($file_ext));
	
	unset($dir_name);
	foreach($ext_arr as $key=>$val) {
		if(in_array($file_ext, $val)) {
			$dir_name=$key;
			break;
		}
	}
	if(!isset($dir_name)) {
		$thisfile['error']="上传文件扩展名是不允许的扩展名。";
	}else {
		if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
			$thisfile['error']="上传文件扩展名是不允许的扩展名。";
		}
	}
	if($multiple_upload && isset($dir_name) && $dir_name!='image') {
		$thisfile['error']="上传文件扩展名是不允许的扩展名。";
	}
	if(empty($thisfile['error'])) {
		if($file_ext=='blob') {$file_ext='png';}
		$thisfile['save_path'] .= $dir_name . DIRECTORY_SEPARATOR;
		$thisfile['save_url']  .= $dir_name . "/";
		if (!file_exists($thisfile['save_path'])) {mkdir($thisfile['save_path']);}
		$ymd = date("Ymd");
		$thisfile['save_path'] .= $ymd . DIRECTORY_SEPARATOR;
		$thisfile['save_url'] .= $ymd . "/";
		if (!file_exists($thisfile['save_path'])) {mkdir($thisfile['save_path']);}
		$new_file_name = substr(md5(time().rand(10000, 99999)),0,9) .'.'.$file_ext;
		$file_path = $thisfile['save_path'] . $new_file_name;
		$thisfile['save_url'] .=$new_file_name;
		$picsizes=explode('_',$picsize);
		if(empty($thisfile['error'])) {
			if($dir_name=='image' && isset($picsizes[0]) && isset($picsizes[1]) && $picsizes[0]>1 && $picsizes[1]>1 && $picsizes[0]<10000  && $picsizes[1]<10000) {
				$a=imagezoom($thisfile['tmp_name'], $thisfile['tmp_name'], $picsizes[0], $picsizes[1], '#FFFFFF');
			}
			if (move_uploaded_file($thisfile['tmp_name'], $file_path) === false) {
				$thisfile['error']="上传文件失败。";
			}else {
				@chmod($file_path, 0644);
			}
		}
	}
	$allfiles[$filekey]=$thisfile;
	if(!empty($thisfile['error'])) {
		$allerror.=$thisfile['name'].':'.$thisfile['error']."\\r\\n";
	}
}
@header('Content-type: text/html; charset=UTF-8');
if(isset($_GET['inputname'])) {
	foreach($allfiles as $thisfile) {
		if(empty($thisfile['error'])) {
			echo("<script type=\"text/javascript\">parent.window.document.form1.".$_GET['inputname'].".value='".$thisfile['save_url']."';</script>");
			if($multiple_upload) {
				echo("<script type=\"text/javascript\">parent.window.document.form1.".$_GET['inputname'].".click();</script>");
			}
		}
	}
	if(!empty($allerror)) {
		echo('<script language="javascript">window.alert("'.$allerror.'");</script>');
		echo("<meta http-equiv=refresh content='0; url=?buttonvalue=继续上传&inputname=".$_GET['inputname']."&picsize=".$picsize."'>");
		die();
	}
	if($multiple_upload) {
		echo("<meta http-equiv=refresh content='0; url=?buttonvalue=继续上传&inputname=".$_GET['inputname']."&picsize=".$picsize."'>");
	}else {
		echo("<meta http-equiv=refresh content='0; url=?buttonvalue=上传成功&inputname=".$_GET['inputname']."&picsize=".$picsize."'>");
	}
	die();
}
if(empty($allerror)) {
	echo(json_encode(array('error' => 0,'success' => 1, 'url' => $allfiles[0]['save_url'],'message'=>'')));
}else {
	$allerror=str_replace("\\r\\n","",$allerror);
	echo(json_encode(array('error' => $allerror,'success' => 0, 'url' => '','message'=>$allerror)));
}
die();

function alert($msg) {
	@header('Content-type: text/html; charset=UTF-8');
	global $picsize;
	if(isset($_GET['inputname'])) {
		echo('<script language="javascript">window.alert("'.$msg.'");</script>');
		echo("<meta http-equiv=refresh content='0; url=?buttonvalue=上传失败&inputname=".$_GET['inputname']."&picsize=".$picsize."'>");
		die();
	}
	echo(json_encode(array('error' => 1, 'message' => $msg)));
	exit;
}
function ucms_fileupload_error($file) {
	switch($file['error']){
		case '1':
			$error = '超过系统允许的大小。';
			break;
		case '2':
			$error = '超过表单允许的大小。';
			break;
		case '3':
			$error = '图片只有部分被上传。';
			break;
		case '4':
			$error = '请选择图片。';
			break;
		case '6':
			$error = '找不到临时目录。';
			break;
		case '7':
			$error = '写文件到硬盘出错。';
			break;
		case '8':
			$error = 'File upload stopped by extension。';
			break;
		default:
			$error = '';
	}
	Return $error;
}
function imagezoom( $srcimage, $dstimage,  $dst_width, $dst_height, $backgroundcolor ) {
	$dstimg = imagecreatetruecolor( $dst_width, $dst_height );
	$color = imagecolorallocate($dstimg, hexdec(substr($backgroundcolor, 1, 2)),hexdec(substr($backgroundcolor, 3, 2)), hexdec(substr($backgroundcolor, 5, 2)));
	imagefill($dstimg, 0, 0, $color);
	if ( !$arr=getimagesize($srcimage) ) {
		Return false;
	}
	$src_width = $arr[0];
	$src_height = $arr[1];
	$srcimg = null;
	$fd = fopen( $srcimage, "rb" );
	$data = fread( $fd, 3 );
	$data = img_str2hex( $data );
	if($data=='474946') {
		 $srcimg=imagecreatefromgif($srcimage);
	}elseif($data=='FFD8FF') {
		$srcimg=imagecreatefromjpeg($srcimage);
	}elseif($data=='89504E') {
		$srcimg=imagecreatefrompng($srcimage);
	}else {
		Return 'ext error';
	}
	
	$dst_x = 0;
	$dst_y = 0;
	$dst_w = $dst_width;
	$dst_h = $dst_height;
	if ( ($dst_width / $dst_height - $src_width / $src_height) > 0 ) {
		$dst_w = $src_width * ( $dst_height / $src_height );
		$dst_x = ( $dst_width - $dst_w ) / 2;
	} elseif ( ($dst_width / $dst_height - $src_width / $src_height) < 0 ) {
		$dst_h = $src_height * ( $dst_width / $src_width );
		$dst_y = ( $dst_height - $dst_h ) / 2;
	}
	imagecopyresampled($dstimg, $srcimg, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $src_width, $src_height);
	if($data=='474946') {
		$a=imagegif($dstimg,$dstimage);
	}elseif($data=='FFD8FF') {
		$a=imagejpeg($dstimg,$dstimage);
	}elseif($data=='89504E') {
		$a=imagepng($dstimg,$dstimage);
	}
	imagedestroy($dstimg);
	imagedestroy($srcimg);
	Return $a;
}

function img_str2hex( $str ) {
	$ret = "";
	for( $i = 0; $i < strlen( $str ) ; $i++ ) {
		$ret .= ord($str[$i]) >= 16 ? strval( dechex( ord($str[$i]) ) ): '0'. strval( dechex( ord($str[$i]) ) );
	}
	return strtoupper( $ret );
}
