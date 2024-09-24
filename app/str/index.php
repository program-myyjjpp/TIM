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
unset($link);
if(isset($_GET['cid'])) {
	$cid=intval($_GET['cid']);
	$link =adminchannel($cid);
	if($link['ifshowadmin']==0) {adminmsg('','此栏目已经禁用');}
	$csetting=json_decode($link['csetting'],1);
	$cname=$link['cname'];
	if($link['ckind']==2 && !power('s',$cid,$power,4)) {
		adminmsg('','无权限',3);
	}
}else{
	$cid=0;
	$cname = '站点设置';
}
if(!power('s',$cid)) {adminmsg('','无权限');}
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<?php 
if(isset($link)) {
	echo(admin_nav($link));
	if($link['ckind']==2) {
		echo('<b>&gt;</b>设置');
	}
}else {
	echo('<b>&gt;</b><strong>'.$cname.'</strong> ');
}
?>
<div class="list">
<?php
if($cid>0) {
	admin_nav_list($cid);
}
?>
</div>
</div>

<div id="mainBox">
    <h3>
<?php
if($cid>0 && $link['ckind']==2) {
echo('<a style="margin-left:10px" href="?do=list&cid='.$cid.'" class="actionBtn">返回</a>');
}
?>
	<?php echo($cname);?></h3>
<form  id="form1" name="form1" method="post" action="?do=str_editpost&cid=<?php echo($cid);?>">
<?php newtoken();?>
     <table width="100%" border="0" cellpadding="8" cellspacing="0" class="">
<?php
if(power('s',$cid,$power,5)) {
	$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('str')." where strcid='$cid' and inputkind>0 order by strorder");
}else {
	$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('str')." where strcid='$cid' and inputkind>0 and ifadmin='0' order by strorder");
}
$strlist = $GLOBALS['db'] -> fetchall($query);
if($cid==0 && !$strlist && power('alevel')==3) {
	echo("<meta http-equiv=refresh content='0; url=?do=install'>");
	exit();
}
foreach ($strlist as $link) 
{ 
	?>
<tr>
<?php
if(power('alevel')==3) {
?>
	<td width="100" align="right"><a href="?do=sadmin_code&id=<?php echo($link['id']);?>&cid=<?php echo($cid);?>&kind=0" tabindex="-1" target="_blank" style="color:#666666"><?php echo($link['strname']);?></a></td>
<?php
}else{
?>
	<td width="100" align="right"><?php echo($link['strname']);?></td>
<?php
}
?>
<td>
<?php
$strarray=explode('|',$link['strarray']);
$thisinput=array(
	'id'=>$link['id'],
	'from'=>'str',
	'pictips'=>$link['strtip'],
	'kind'=>$link['inputkind'],
	'inputname'=>'input_'.$link['id'],
	'inputvalue'=>$link['strvalue'],
	'style'=>$link['strstyle'],
	'strarray'=>$strarray
);
htmlinput($thisinput);
	echo(' '.$link['strtip']);
?>
	</td>
		</tr>
	<?php
}
?>
<?php
if(power('s',$cid,$power,4)) {
?>
	<tr>
		<td></td>
		<td>
		<input class="btn" style="width:140px;" type="submit" value="提交" />

		<?php
			if($cid>0 && !$strlist && power('alevel')==3) {
				echo('<a href="?do=sadmin_sbasic&cid='.$cid.'">该栏目尚未添加变量,前去添加</a>');
			}

		?>
		</td>
	</tr>
<?php
}
?>
	</table>
	</form>
	</div>
 </div>