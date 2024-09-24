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
if(!AdminFileedit) {
	adminmsg('','文件管理功能已关闭',0);
}
if(isset($_SERVER["HTTP_REFERER"])) {
	$refererurl=$_SERVER["HTTP_REFERER"];
}else {
	$refererurl='';
}
if(isset($_GET['dir'])) {
	$getdir=$_GET['dir'];
	if($_GET['dir']=='/') {
		$dir=$_GET['dir'];
	}else {
		if(substr($_GET['dir'],strlen($_GET['dir'])-1,1)!=='/') {
			$dir=$_GET['dir'].'/';
		}else {
			$dir=$_GET['dir'];
		}
	}
	$alldir=$_SERVER['DOCUMENT_ROOT'].$dir;
	if(stripos($_GET['dir'],'..')===false) {}else {die('error dir');}
	$backdir=dirname($dir);
}else {
	$dir=SystemDir;
	$_GET['dir']=$dir;
	$backdir=$_GET['dir'];
	$getdir='/';
	$alldir=SystemRoot;
}
if(isset($_POST['newdir'])) {
	checktoken();
	$newdirname=$alldir.'/'.$_POST['newdir'];
	if(is_dir($newdirname)) {
		adminmsg($refererurl,'文件夹已存在',1);
	}else {
		if(@mkdir($newdirname)) {
			adminmsg($refererurl,'文件夹创建成功',0);
		}else {
			adminmsg($refererurl,'文件夹创建失败,请确认目录权限',1);
		}
	}
	exit();
}
if(isset($_POST['newfile'])) {
	checktoken();
	$newfilename=$alldir.'/'.$_POST['newfile'];
	if(is_file($newfilename)){ 
		adminmsg($refererurl,'文件已存在',1);
	}else {
		$fp = @fopen($newfilename,"w");
		@fclose($fp);
		if(is_file($newfilename)) {
			adminmsg($refererurl,'文件创建成功',0);
		}else {
			adminmsg($refererurl,'文件创建失败',1);
		}
	}
	exit();
}
if(isset($_GET['delfile'])) {
	checktoken();
	if(!isset($_SERVER["HTTP_REFERER"])) {
		die('error');
	}
	if(stripos($_GET['deldir'],'..')===false) {}else {die('error dir');}
	if(stripos($_GET['delfile'],'..')===false) {}else {die('error file');}
	$delfile=$alldir.$_GET['delfile'];
	if(@unlink($delfile)) {
		adminmsg($refererurl,'删除成功',0);
	}else {
		adminmsg($refererurl,'删除失败',0);
	}
	exit();
}
if(isset($_GET['newname'])) {
	checktoken();
	if(!isset($_SERVER["HTTP_REFERER"])) {
		die('error');
	}
	if(stripos($_GET['oldname'],'..')===false) {}else {die('error dir');}
	if(stripos($_GET['newname'],'..')===false) {}else {die('error file');}
	if(stripos($_GET['dirname'],'..')===false) {}else {die('error file');}
	$oldname=$alldir.$_GET['oldname'];
	$newname=$alldir.$_GET['newname'];
	if(is_file($newname) || is_dir($newname)) {
		adminmsg($refererurl,'新命名文件夹/文件已经存在',1);
		exit();
	}
	if(rename ($oldname,$newname)) {
		adminmsg($refererurl,'重命名成功',0);
	}else {
		adminmsg($refererurl,'重命名失败',1);
	}
	exit();
}
if(isset($_FILES['uploadfile'])) {
	checktoken();
	if(!isset($_SERVER["HTTP_REFERER"])) {
		die('error');
	}
	if(stripos($_GET['dir'],'..')===false) {}else {die('error file');}
	if(is_uploaded_file($_FILES['uploadfile']['tmp_name'])){
		$filaname=$alldir.$_FILES["uploadfile"]["name"];
		if(@move_uploaded_file($_FILES['uploadfile']['tmp_name'],$filaname)) {
			adminmsg($refererurl,'上传成功',0);
		}else {
			adminmsg($refererurl,'上传失败,无法写入文件,请确认目录权限',1);
		}
		exit();
	}else {
		adminmsg($refererurl,'未上传',1);
		exit();
	}
	exit();
}

$listedcount=0;
if(isset($_GET['dir'])) {
	if($_GET['dir']=='') {
		$filelist=array();
		getlastfile(SystemRoot,'');
		$filelist=multi_array_sort($filelist,'order');
	}else {
		$filelist=getfilelist($alldir,$dir);
	}
}else {
	$filelist=getfilelist($alldir,$dir);
	$backdir='/';
}
function getlastfile($alldir,$thisdir) {
	global $listedcount,$filelist;
	if($listedcount>200) {
		Return false;
	}
	if(is_dir($alldir)) {
		$dir =opendir($alldir);
	}else {
		Return false;
	}
	$cachedirname=str_replace("\\","/",CacheDir);
	while (($file = readdir($dir)) !== false){
		if(ifshowfile($file)) {
			$thisfile=$alldir.'/'.$file;
			$thisfile=str_replace("//","/",$thisfile);
			$thisfile=str_replace("\\\\","\\",$thisfile);
			$thisfile=str_replace("\\","/",$thisfile);
			if($file!='.' && $file!='..' && stripos($thisfile,$cachedirname)===false) {
				if(is_dir($alldir.'/'.$file)) {
					$listedcount--;
					getlastfile($alldir.$file.'/',$thisdir.$file.'/');
				}else {
					$listedcount++;
					$thisctime=filectime($thisfile);
					$thismtime=filemtime($thisfile);
					$filelist[]=array('name'=>$file,
						'dirname'=>$thisdir,
						'isdir'=>0,
						'ctime'=>$thisctime,
						'mtime'=>$thismtime,
						'order'=>$thisctime>$thismtime ? $thisctime : $thismtime,
						'size'=>filesize($thisfile));
				}
			}
		}
		// $isdir=is_dir($thisfile);
	}
	 closedir($dir);
}
function getfilelist($alldir,$thisdir) {
	global $listedcount;
	$filelist=array();
	if(is_dir($alldir)) {
		@$dir =opendir($alldir);
		if(!$dir) {
			adminmsg('','无法打开此目录,请设置目录权限',1);
		}
	}else {
		echo('no dir');
		die();
	}
	while (($file = readdir($dir)) !== false){
		//$cnname=iconv("GB2312//IGNORE", "UTF-8",$file);
		$thisfile=$alldir.$file;
		if($file!='.' && $file!='..') {
			if(ifshowfile($file)) {
				$listedcount++;
				if(is_dir($alldir.$file)) {
					$filelist[]=array('name'=>$file,'dirname'=>$thisdir,'isdir'=>1,'ctime'=>filectime($thisfile),'mtime'=>filemtime($thisfile),'size'=>filesize($thisfile));
				}else {
					$filelist[]=array('name'=>$file,'dirname'=>$thisdir,'isdir'=>0,'ctime'=>filectime($thisfile),'mtime'=>filemtime($thisfile),'size'=>filesize($thisfile));
				}
			}
		}
		// $isdir=is_dir($thisfile);
	}
	 closedir($dir);
	Return $filelist;
}
function isedit($filename) {
	$array=array('php','css','js','htm','html','txt','asp','aspx','inc','conf');
	foreach($array as $val) {
		if(pathinfo($filename, PATHINFO_EXTENSION)==$val) {
			Return true;
		}
	}
	Return false;
}
function istemplatefile($filename) {
	$array=array('php','htm','html','tpl');
	foreach($array as $val) {
		if(pathinfo($filename, PATHINFO_EXTENSION)==$val) {
			Return true;
		}
	}
	Return false;
}
function ifshowfile($filename) {
	$array=array('.htaccess');
	foreach($array as $val) {
		if(stripos($filename,$val)===false) {
			
		}else {
			Return false;
		}
	}
	Return true;
}
function multi_array_sort($multi_array,$sort_key,$sort=SORT_DESC){ 
	if(is_array($multi_array)){ 
	foreach ($multi_array as $row_array){ 
	if(is_array($row_array)){ 
	$key_array[] = $row_array[$sort_key]; 
	}else{ 
	return false; 
	} 
	} 
	}else{ 
	return false; 
	} 
	array_multisort($key_array,$sort,$multi_array); 
	return $multi_array; 
} 
if($backdir=='\\' || $backdir=='//' ) {
	$backdir='/';
}

?>
<div id="UMain">
   <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>文件管理</strong> </div>   <div id="mainBox">
    <h3>文件管理<?php echo('&nbsp;&nbsp;'.$dir);?>
	<a href="?do=sadmin_file&dir=<?php echo($backdir);?>" class="actionBtn" style="margin-left:10px"><em>返回</em></a>
	<a href="?do=sadmin_file&dir=" class="actionBtn" style="margin-left:10px">最近修改</a>
	
	<a href="?do=sadmin_file&dir=/" class="actionBtn" style="margin-left:10px">根目录</a>
	</h3>
        <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
     <tr>
      <th align="left">文件名</th>
	  <th align="left" width=150>文件大小</th>
	  <th align="left" width=150>创建时间</th>
	  <th align="left" width=150>修改时间</th>
	<th align="center" width=150>操作</th>
     </tr>

<?php
foreach($filelist as $val) {
	$file=$val['name'];
	$isdir=$val['isdir'];
	$jsname=str_replace("\\","\\\\",$val['dirname']);
	if(substr($val['dirname'],0,1)=='/') {
		$val['dirname']=substr($val['dirname'],1,strlen($val['dirname']));
	}
?>
 <tr>
      <td>
	<?php
		if($isdir) {
			echo('<em class="folder"></em>&nbsp;<a href="?do=sadmin_file&dir='.'/'.$val['dirname'].$file.'">'.$file.'</a>');
		}else {
			if(isedit($val['name'])) {
				echo('<em class="file"></em>&nbsp;<a target="_blank" href="?do=sadmin_fileedit&dir='.'/'.$val['dirname'].'&file='.$file.'">'.$file.'</a>');
			}else {
				echo('<em class="file"></em>&nbsp;<a target="_blank" href="/'.$val['dirname'].''.$file.'">'.$file.'</a>');
			}
			if(isset($_GET['chosetemplate']) && istemplatefile($file)) {
				echo(' <a class="chose_template_click_return" rel="'.$file.'">选择</a>');
			}
				
				if(isset($_GET['dir']) && $_GET['dir']=='') {
					echo('<div style="color:#ccc;display:inline;float:right">'.$val['dirname'].'</div>');
				}
		}
	?>
	  
	  </td>
	  <td>
	  <?php
		if(!$isdir) {
		  echo(getRealSize($val['size']));
		  }
	  ?></td>
      <td align="center">
	  <?php
	 echo(date("Y-m-d H:i:s",$val['ctime']));
	  ?></td>
      <td align="center">
	  <?php
	 echo(date("Y-m-d H:i:s",$val['mtime']));
	  ?></td>
	  <?php
		  if($isdir) {
			echo('<td align="center">
			<a href="?do=sadmin_file&dir='.'/'.$val['dirname'].$file.'">打开文件夹</a>
			&nbsp;&nbsp;<a href="javascript:;" onclick="javascript:rename(\''.$jsname.'\',\''.$file.'\');">重命名</a>
			</td>');
		  }else {
			echo('<td align="center">'); 
			if(isedit($val['name'])) {
				echo('<a target="_blank" href="?do=sadmin_fileedit&dir='.'/'.$val['dirname'].'&file='.$file.'">编辑</a>&nbsp;&nbsp;');
			}
			echo('<a href="javascript:;" onclick="javascript:rename(\''.$jsname.'\',\''.$file.'\');">重命名</a>');
			echo('&nbsp;&nbsp;<a href="javascript:;" onClick="javascript:delfile(\''.$jsname.'\',\''.$file.'\');">删除</a>');
			echo('</td>');
		  }
		?>
	  
     </tr>
<?php
}
?>
<tr>
<td colspan=4>
<?php
if(isset($_GET['dir']) && $_GET['dir']<>'') {
?>
<form style="display:inline" method=post action="?do=sadmin_file&dir=<?php echo($getdir);?>">
<?php newtoken();?>
	新建文件夹: 
	<input type="text" name="newdir" class="inputtext">
	<input name="submit" class="btn" style="width:60px;" type="submit" value="提交">
</form>

<form style="margin-left:20px;display:inline" method=post action="?do=sadmin_file&dir=<?php echo($getdir);?>">
<?php newtoken();?>
	新建文件: 
	<input type="text" name="newfile" class="inputtext">
	<input name="submit" class="btn" style="width:60px;" type="submit" value="提交">
</form>


<form style="margin-left:10px;display:inline" action="?do=sadmin_file&dir=<?php echo($getdir);?>" enctype="multipart/form-data" method="post" name="uploadfile">
<?php newtoken();?>
上传文件：<input type="file" name="uploadfile" /> 
<input type="submit" class="btn" style="width:60px;" value="上传" />
</form> 
<?php
}
?>

</td>
<td>
总数:<?php echo($listedcount);?>
</td>
</tr>
         </table>
		 <script type="text/javascript">
		 function delfile(dir,filename){
			 if (window.confirm('确认删除?'))
			 {
				 window.location.href="?do=sadmin_file&<?php newtoken(2);?>&dir=<?php echo(str_replace("\\","\\\\",$getdir));?>&deldir="+dir+"&delfile="+filename;
			 }
			 return false;
		 }
		 function rename(dir,oldname){
			var newname=prompt("请填写新名称",oldname);
			if(typeof(newname)=="object"){
				return false;
			}
			if (newname.length<1)
				{
					return false;
				}
				window.location.href="?do=sadmin_file&<?php newtoken(2);?>&dir=<?php echo(str_replace("\\","\\\\",$getdir));?>&dirname="+dir+"&oldname="+oldname+"&newname="+newname;
			return false;
		 }
		 
$(function(){
	$('.chose_template_click_return').click(function(){
		window.opener.document.nowinputclickdom.prev().prev().find('input').val($(this).attr('rel'));
		window.close();
	});

	
});
		 
		 </script>
       </div>
 </div>
 <?php
 function getRealSize($size)
    { 
        $kb = 1024;         // Kilobyte
        $mb = 1024 * $kb;   // Megabyte
        $gb = 1024 * $mb;   // Gigabyte
        $tb = 1024 * $gb;   // Terabyte
        
        if($size < $kb)
        { 
            return $size." B";
        }
        else if($size < $mb)
        { 
            return round($size/$kb,2)." KB";
        }
        else if($size < $gb)
        { 
            return round($size/$mb,2)." MB";
        }
        else if($size < $tb)
        { 
            return round($size/$gb,2)." GB";
        }
        else
        { 
            return round($size/$tb,2)." TB";
        }
    }
 ?>

