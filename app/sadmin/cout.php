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
if(isset($_GET['cid'])) {
	$cid=intval($_GET['cid']);
}elseif(isset($_POST['cid'])) {
	$cid=intval($_POST['cid']);
}else {
	die('error');
}
if(isset($_GET['cid']) && $_GET['cid']==0) {
	$channeldata=array();
	$strs = $GLOBALS['db'] -> all("SELECT * FROM ".tableex('str')." where strcid='0' order by id asc");
	$channeldata['str']=$strs;
	filedownload('站点变量',$channeldata);
}
$link = $GLOBALS['db'] -> one("SELECT * FROM ".tableex('channel')." where cid='$cid'");
if(!$link) {
	die('no channel');
}
$csetting=json_decode($link['csetting'],1);
if(!isset($csetting['cnote'])) {
	$csetting['cnote']='';
}
if(isset($_POST['cid'])) {
	if(!isset($_POST['info']) && !isset($_POST['moudle']) && !isset($_POST['str'])) {
		die('no one selected');
	}
	$channeldata=array();
	$csetting['cnote']=htmlspecialchars($_POST['cnote']);
	$link['csetting']=(json_encode($csetting));
	if(isset($_POST['info'])) {
		if($link['fid']>0) {
			$fidname = $GLOBALS['db'] -> one("SELECT cname FROM ".tableex('channel')." where cid='".$link['fid']."' limit 1");
			if(isset($fidname['cname'])) {$link['fid']=$fidname['cname'];}
		}
		$channeldata['info']=$link;
	}
	if(isset($_POST['moudle'])) {
		$moudles = $GLOBALS['db'] -> all("SELECT * FROM ".tableex('moudle')." where cid='$cid' order by morder asc");
		foreach($moudles as $key=>$thismoudle) {
			foreach($thismoudle as $key1=>$val) {
				if(is_numeric($key1)) {
					unset($moudles[$key][$key1]);
				}
			}
			unset($moudles[$key]['ifcreated']);
		}
		$channeldata['moudle']=$moudles;
	}
	if(isset($_POST['str'])) {
		$strs = $GLOBALS['db'] -> all("SELECT * FROM ".tableex('str')." where strcid='$cid' order by strorder asc");
		foreach($strs as $key=>$thisstr) {
			foreach($thisstr as $key1=>$val) {
				if(is_numeric($key1)) {
					unset($strs[$key][$key1]);
				}
			}
		}
		$channeldata['str']=$strs;
	}
	filedownload($link['cname'],$channeldata);
}
function filedownload($filename,$filecontent) {
	$filecontent=base64_encode(json_encode($filecontent));
	Header("Content-type:application/octet-stream"); 
	Header("Accept-Ranges:bytes"); 
	header("Content-Disposition:attachment;filename=".$filename.".txt"); 
	header("Expires:0"); 
	header("Cache-Control:must-revalidate,post-check=0,pre-check=0"); 
	header("Pragma:public");
	echo($filecontent);
	die();
}
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>栏目配置</strong> </div>   <div id="mainBox">
     <h3>
<a href="?do=sadmin" class="actionBtn" style="margin-left:10px"><em>返回</em></a>导出栏目
 </h3>
	<form id="form1" method="post" action="?do=sadmin_cout&nohtml=1" target="_blank">
	<?php newtoken();?>
	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="">
		<input type="hidden" name="cid" value="<?php echo($link['cid']);?>">
		
			<tr><td width="100" align="right">栏目名</td>
				<td align="left">
				<?php echo($link['cname']);?>
				</td></tr>
				<tr><td width="100" align="right">栏目备注</td>
				<td align="left">
				<input type="text" name="cnote" value="<?php echo($csetting['cnote']);?>" size="80"  class="inputtext">
				</td></tr>
			<tr><td width="100" align="right">导出配置</td><td align="left">
			<label><input type="checkbox" name="info" checked>栏目配置</label>
			<label><input type="checkbox" name="moudle" checked>栏目字段</label>
			<label><input type="checkbox" name="str" checked>栏目变量</label>

				</td></tr>

			</table>
</td></tr>
 <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic"  style="border-top:0px;border-bottom:0px;">
      <tr>
       <td width="100"></td>
       <td>
        <input class="btn" type="submit" value="导出配置" />
       </td>
      </tr>
     </table>
    </form>
       </div>
 </div>
