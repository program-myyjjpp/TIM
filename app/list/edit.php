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
$editorarray=array();
$cid=intval($_GET['cid']);
$link =adminchannel($cid);
if($link['ifshowadmin']==0) {adminmsg('','此栏目已经禁用');}
$cname=$link['cname'];
$csetting=json_decode($link['csetting'],1);
if(isset($csetting['listnoedit']) && $csetting['listnoedit']==1) {adminmsg('','禁止编辑');}//禁止修改
if(!power('s',$cid,$power,2)) {adminmsg('','无权限');}//没有编辑权限
//文章来源表
if(isset($_GET['articletable']) && !empty($_GET['articletable'])) {
	$articletable=dbstr($_GET['articletable']);
	$articletableuri='&articletable='.$articletable;
}else {
	$articletable='';
	$articletableuri='';
	if(isset($csetting['articletable'])) {$articletable=$csetting['articletable'];}else {adminmsg('','栏目尚未配置');}
}
if(!admintablecheck($articletable)) {adminmsg('','栏目表名有误');}
if(isset($_GET['articlemname'])) {
	$articlemname=dbstr(htmlspecialchars($_GET['articlemname']));
	if(isset($_GET['articlechoose'])) {
		$articlechoose=dbstr(htmlspecialchars($_GET['articlechoose']));
		$articleschooseuri='&articlechoose='.$articlechoose.'&articlemname='.$articlemname;
	}elseif(isset($_GET['articleschoose'])) {
		$articleschoose=dbstr(htmlspecialchars($_GET['articleschoose']));
		$articleschooseuri='&articleschoose='.$articleschoose.'&articlemname='.$articlemname;
	}elseif(isset($_GET['allarticleschoose'])) {
		$allarticleschoose=dbstr(htmlspecialchars($_GET['allarticleschoose']));
		$articleschooseuri='&allarticleschoose='.$allarticleschoose.'&articlemname='.$articlemname;
	}else {
		$articleschooseuri='';
	}
}else {
	$articleschooseuri='';
}
if(isset($_GET['moudleid']) && isset($_GET['fid'])) {
	$moudleid=dbstr(htmlspecialchars($_GET['moudleid']));
	$fid=intval($_GET['fid']);
	$moudleiduri='&fid='.$fid.'&moudleid='.$moudleid;
}else {
	$moudleiduri='';
}
$id=intval($_GET['id']);
$delsql='';//如果栏目开通了普通用户只能管理自己的文章
if(power('sadmin',0) || power('s',$cid,$power,5)) {}else {if(isset($csetting['listadminuid']) && $csetting['listadminuid']==1) {$delsql=" and adminuid='$myadminuid'";}}//普通用户只能编辑自己的文章
$query = $GLOBALS['db'] -> query("SELECT * FROM $articletable where id='$id' and cid='$cid'$delsql limit 1");
$article = $GLOBALS['db'] -> fetchone($query);
if(!$article) {adminmsg('','文章不存在');}
if(power('sadmin',0) || power('s',$cid,$power,5)) {$thissql='';}else {$thissql=" and ifadmin<>'1'";}//不是管理员则不要管理员字段
$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('moudle')." where hide<>'1' and ifcreated='1' and cid='$cid'$thissql order by morder asc");
$moudle = $GLOBALS['db'] -> fetchall($query);
run_admin_hook($cid,'edit');
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<?php echo(admin_nav($link));?></div>   <div id="mainBox">
    <h3>
	<?php
	echo('<a href="?do=list&cid='.$cid.$articletableuri.$articleschooseuri.$moudleiduri.'" class="actionBtn" style="margin-left:10px"><em>返回</em></a>');
	?>
	<?php
	if($link['ifshow']){
		$visit=array();
		$visit['cid']=$cid;
		$visit['where']['id']=$id;
		$visit_article=a($visit);
		if ($visit_article && !empty($visit_article['link'])){
			echo('<a href="'.$visit_article['link'].'" class="actionBtn" style="margin-left:10px;padding: 0 30px;" target="_blank"><em>浏览</em></a>');
		}
	}
	?>
	<?php echo($cname);?></h3>
		<form id="form1" name="form1" method="post" action="?do=list_editpost&cid=<?php echo($cid);?><?php echo($articletableuri);?><?php echo($articleschooseuri);?><?php echo($moudleiduri);?>">
		<?php newtoken();?>
		<input type="hidden" name="id" value="<?php echo($id);?>">
		<input type="hidden" name="cid" value="<?php echo($cid);?>">
		<table width="100%" border="0" cellpadding="8" cellspacing="0" class="">
	<?php
		foreach ($moudle as $value) 
		{
			if(empty($value['fid'])) {
			$thisinput=array();
			$thisinput['style']=$value['mfunction'];
			if(isset($article[$value['mname']])) {
				$strdefault=$article[$value['mname']];
			}else {
				$strdefault='';
			}
	?>
		<tr<?php if($value['ifmore']==1){echo(' class="listhidden"');$haveshowmoudle=1;} ?>>
		<?php
		if(power('alevel')==3) {
		?>
			<td height="24" width="100" align="right"><a href="?do=sadmin_code&id=<?php echo($value['id']);?>&cid=<?php echo($cid);?>&kind=1"  tabindex="-1" target="_blank" style="color:#666666"><?php echo($value['minfo']);?></a></td>
		<?php
		}else{
		?>
			<td height="24" width="100" align="right"><?php echo($value['minfo']);?></td>
		<?php
		}
		?>

		  <td height="24" align="left">
		  <?php 
		$thisinput['pictips']=$value['mcontent'];
		$thisinput['id']=$value['id'];
		$thisinput['from']='list';
		$thisinput['strarray']=explode('|',$value['strarray']);
		$thisinput['kind']=$value['mkind'];
		$thisinput['inputname']=$value['mname'];
		$thisinput['inputvalue']=$strdefault;
		htmlinput($thisinput);
		unset($thisinput);
	?>
		
		<i><?php echo($value['mcontent']);?></i>
		<?php
			//二级字段
			foreach ($moudle as $value2) 
			{
				if($value2['fid']==$value['mname']) {
					$thisinput2=array();
					$thisinput2['style']=$value2['mfunction'];
					if(isset($article[$value2['mname']])) {$strdefault=$article[$value2['mname']];}else {$strdefault='';}
					echo('&nbsp;&nbsp;&nbsp;'.$value2['minfo'].':&nbsp;');
					$thisinput2['pictips']=$value2['mcontent'];
					$thisinput2['id']=$value2['id'];
					$thisinput2['from']='list';
					$thisinput2['strarray']=explode('|',$value2['strarray']);
					$thisinput2['kind']=$value2['mkind'];
					$thisinput2['inputname']=$value2['mname'];
					$thisinput2['inputvalue']=$strdefault;
					htmlinput($thisinput2);
					unset($thisinput2);
					echo('<i>'.$value2['mcontent'].'</i>');
				}
			}
		?>
		</td>
		</tr>
		<?php
			}//一级字段
		}
		?>
		<tr>
		<td></td>
		<td>
		<input class="btn" style="width:140px;" type="submit" value="编 辑" />
		<?php
		if(isset($haveshowmoudle)) {
			?>
		<a href="javascript:;" class="listmore">更多</a>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".listmore").click(function(){
					$(".listhidden").toggle();
					if ($(".listmore").text()=='隐藏')
					{
						$(".listmore").text('更多');
					}else{
						$(".listmore").text('隐藏');
					}
				});
			});
		</script>
			<?php
		}
		?>
			</td>
		</tr>
		</table>
	</form>
	</div>
 </div>