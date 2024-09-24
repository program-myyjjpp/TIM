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
if(isset($_GET['cid']) && $_GET['cid']>0) {
	$cid=intval($_GET['cid']);
	$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('channel')." where cid='$cid'");
	$link = $GLOBALS['db'] -> fetchone($query);
	if(!$link) {
		die('no channel');
	}
	$cname=$link['cname'];
}else {
	$cid=0;
	$cname='站点变量';
}
if(isset($_GET['cinkind'])) {
	$cinkind=intval($_GET['cinkind']);
}else {
	$cinkind=0;
}
if(!isset($_GET['key'])) {
	die('参数错误');
}else {
	$key=$_GET['key'];
}
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>栏目配置</strong> </div>   <div id="mainBox">
     <h3>
<a href="?do=sadmin" class="actionBtn" style="margin-left:10px"><em>返回</em></a>导入向导
 </h3>
	<form id="form1" method="post" action="?do=sadmin_cineditpost" enctype="multipart/form-data"  onsubmit="return cineditcheck()">
	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="">
<?php newtoken();?>
		<input type="hidden" name="cid" value="<?php echo($cid);?>">
		<input type="hidden" name="cinkind" value="<?php echo($cinkind);?>">
		<input type="hidden" name="key" value="<?php echo($key);?>">
		<input type="hidden" name="channeldata" value="" id="channeldata">
		<?php if(isset($_GET['new'])) {echo('<input type="hidden" name="new" value="1">');}?>
<tr><td width="130" align="right">栏目名</td>
<td align="left">
<?php echo($cname);?>
</td></tr>
<tr<?php if($cid==0 || $cinkind==2 || $cinkind==3) {echo(' style="display:none"');}?>>
<td width="100" align="right">栏目配置信息</td><td align="left">
<p class="cineditloading" id="channel_info"><img src="img/loading.gif"> 载入中</p><i>导入后将覆盖原有配置</i>
</td>
</tr>

<tr<?php if($cid==0 || $cinkind==1 || $cinkind==3) {echo(' style="display:none"');}?>>
<td width="100" align="right">栏目字段[<a href="javascript:;" class="checkall_moudle">全选</a>]
[<a href="javascript:;" class="checkall_moudle_change">反选</a>]</td><td align="left">
<p class="cineditloading" id="channel_moudle"><img src="img/loading.gif"> 载入中</p>
<p style="clear:both"></p><br><i>已存在的字段不会被导入</i>
<p class="ifcreatetable" style="display:none"><br><br>
<label><input type="checkbox" name="createtable" checked>将字段创建到数据库</label> <i>如您还需修改表名或调整字段,请不必勾选,请保持默认文章表字段一致</i>
</p>
</td>
</tr>
<tr<?php if($cinkind==1 || $cinkind==2) {echo(' style="display:none"');}?>>
<td width="100" align="right">
<?php if($cid==0) {echo('站点变量');}else {echo('栏目变量');}?>[<a href="javascript:;" class="checkall_str">全选</a>]
[<a href="javascript:;" class="checkall_str_change">反选</a>]</td>
<td align="left">
<p class="cineditloading" id="channel_str"><img src="img/loading.gif"> 载入中</p>
<p style="clear:both"></p><br><i>已存在的变量不会被导入</i>
</td>
</tr>
      <tr>
       <td></td>
       <td>
        <input class="btn btn140" type="submit" value="确认导入" />
       </td>
      </tr>
     </table>
    </form>
       </div>
 </div>
 <div id="channel_js" style="display:none"></div>
<script type="text/javascript">
$(function(){
	$("#channel_moudle input").each(function(){
		$(".ifcreatetable").show();
	});
	$('.checkall_moudle').click(function(){
		$('#channel_moudle input').prop('checked',true);
	});
	$('.checkall_moudle_change').click(function(){
		$("#channel_moudle input").each(function(){
			if ($(this).prop('checked'))
			{
				$(this).prop('checked',false);
			}else{
				$(this).prop('checked',true);
			}
		});
	});
	$('.checkall_str').click(function(){
		$('#channel_str input').prop('checked',true);
	});
	$('.checkall_str_change').click(function(){
		$("#channel_str input").each(function(){
			if ($(this).prop('checked'))
			{
				$(this).prop('checked',false);
			}else{
				$(this).prop('checked',true);
			}
		  });
	});
<?php
if($cinkind==1) {
	echo('$(\'#channel_info input\').prop(\'checked\',true);');
}elseif($cinkind==2) {
	echo('$(\'#channel_moudle input\').prop(\'checked\',true);');
}elseif($cinkind==3) {
	echo('$(\'#channel_str input\').prop(\'checked\',true);');
}else {
	echo('$(\'td input\').prop(\'checked\',true);');
}
?>

});
function cineditcheck()
{
 <?php
 if($cid==0) {
	?>
	document.getElementById("channel_info").innerHTML='';
	document.getElementById("channel_moudle").innerHTML='';
	<?php
 }
 ?>
if (document.getElementById("channeldata").value=='')
{
	alert('配置信息尚未载入,请稍后');
	return false;
}
return true;
}
</script>
<?php
	echo('<script src="?do=sadmin_cineditjs&key='.$key.'&nohtml=1"></script>');
?>


