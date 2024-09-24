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
$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('channel')." order by corder asc");
$category = $GLOBALS['db'] -> fetchall($query);
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>栏目配置</strong> </div>   <div id="mainBox">
 <h3>
 <a style="margin-left:10px" href="?do=sadmin_url" class="actionBtn">自定义页面</a>
 <a style="margin-left:10px" href="?do=sadmin_sbasic" class="actionBtn">站点变量</a>
 
 栏目配置
 </h3>
 <form method=post action="?do=sadmin_caddpost">
 <input type="hidden" name="multiple_add">
	<?php newtoken();?>
     <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tablerowtip">
<tr>
<th width="5%">编号</th>
<th width="10%">栏目类型</th>
 <th>栏目名</th>
   <th width="270px">操作</th>
   <th width="10%">排序</th>
</tr>
<?php
$neworder=0;
$allchannels=channel_select(0,0,0,0);
$i=0;
foreach($allchannels as $value) {
	$csetting=json_decode($value['csetting'],1);
?>
<tr> 
<td width="5%" align="center"><?php echo($value['cid']);?></td>
 <td width="10%" align="center">
 <?php
if($value['ckind']==1) {
	echo('<font color="#0000FF">单页栏目</font>');
}elseif($value['ckind']==2) {
	echo('<font color="#FF0000">文章栏目</font>');
}elseif($value['ckind']==3) {
	echo('<font color="#FFCC00">前台链接</font>');
}elseif($value['ckind']==4) {
	echo('后台链接');
}elseif($value['ckind']==5) {
	echo('<font color="#339900">过渡栏目</font>');
}else {
	echo('未知');
}

?>
 </td>
  <td height="21px" align="left" class="nocolor">
	<?php 
	
	if($value['ckind']==1) {
		$thisurl='?do=str&cid='.$value['cid'];
	}elseif($value['ckind']==2) {
		$thisurl='?do=list&cid='.$value['cid'];
	}elseif($value['ckind']==3) {
		$thisurl='?do=str&cid='.$value['cid'];
	}elseif($value['ckind']==4) {
		$thisurl=$value['cvalue'];
	}elseif($value['ckind']==5) {
		$thisurl=get_transit_channel($value['cid'],2);
	}
		echo $value['ext'].'<A href="'.$thisurl.'">'.$value['cname'].'&nbsp;</a>';
		if($value['ifshowadmin']!=1) {
			echo('<font color="#FF0000">隐藏</font>');
		}
		if($value['ifshow']>0) {
			$thisurl=getchannelurl($value);
			echo(' <i><a href="'.$thisurl.'" target="_blank" style="color:#4791d0">访问</a></i>');
		}else {
			echo(' <i>前台已禁用</i>');
		}
		if($value['ckind']==1) {
			echo(' <i><a href="?do=sadmin_sbasic&cid='.$value['cid'].'" style="color:#4791d0">变量管理</a></i>');
		}
		if($value['ckind']==2) {
			echo(' <i><a href="?do=sadmin_sbasic&cid='.$value['cid'].'" style="color:#4791d0">变量管理</a></i>');
			echo(' <i><a href="?do=sadmin_aindex&cid='.$value['cid'].'" style="color:#4791d0">字段管理</a></i>');
		}
	?>
</td>
<td  width="270px" class="" align=center>
	<a href="?do=sadmin_cedit&cid=<?php echo($value['cid']);?>">栏目配置</a>&nbsp;
	<a href="?do=sadmin_cadd&cid=<?php echo($value['cid']);?>" >增加子栏目</a>&nbsp;
	<a href="?do=sadmin_cout&cid=<?php echo($value['cid']);?>" >导出栏目</a>&nbsp;
	<a href="javascript:;"  onclick="javascript:confirmurl('?do=sadmin_cdel&cid=<?php echo($value['cid']);?>&<?php echo(newtoken(2));?>','确认删除该栏目？\r\n栏目配置信息和栏目模型都会被删除!!!\r\n数据库请手动删除.');">删除栏目</a>
</td>
<td width="10%" align="center">
		<a href="javascript:changeorder(<?php echo($value['cid']);?>,<?php echo($value['corder']);?>);" ><?php echo($value['corder']);?></a>
</td>
  </tr>
<?php
		$i++;
		if($neworder<$value['corder']) {
			$neworder=$value['corder'];
		}
	}
?>
<tr class="addactiontr">
<td colspan="5" align="left">
<a href="javascript:;" class="add_channeltr" style="color:#FF6600">[+]增加栏目</a>
<a style="margin-left:10px" href="?do=sadmin_cadd" class="actionBtn" target="_blank">导入栏目</a>
<input type="submit" id="savebutton" value="保存" class="btn" style="float:right;margin-right:10px;display:none">


</td>
</tr>
<?php
if(isset($common_channel) && count($common_channel)>0) {
	?>
	<tr class="quick_moudle">
<td colspan="6" align="left">
<span>常用栏目:</span> 
<?php
foreach($common_channel as $val) {
	echo('<a href="javascript:;" rel="'.$val[0].'">'.$val[1].'</a>');
}
?>
</td></tr>
	<?php
}
?>
     </table>

</form>
       </div>
 </div>

<table id="newchannelhtml" style="display:none">
<tr class="new_channeltr">
<td align="center">*</td>
<td align="center">
<select name="ckind[]">
	<option value="1">单页栏目</option>
	<option value="2">文章栏目</option>
	<option value="5">过渡栏目</option>
	<option value="3">前台链接</option>
	<option value="4">后台链接</option>
</select>
</td>
<td>
<input type="text" name="cname[]" placeholder="栏目名" class="inputtext"> 

<select name="fid[]">
<?php
channel_select();
?>
</select>
</td>
<td align=center>
<a href="javascript:;" onclick="del_channeltr(this)">删除</a>
</td>
<td align="center"><input name="corder[]" size="10"  value="" size="10" class="inputtext moudlemorder" style="text-align:center"></td>

</tr>
</table>
<script type="text/javascript">
var neworder=<?php echo($neworder);?>;
$(function(){
	$('.add_channeltr').click(quick_add_channel);
	$('.quick_moudle a').click(function(){
		if ($(this).attr('rel')!='')
		{
			quick_add_channel($(this).attr('rel'),$(this).html());
		}
	});
	function quick_add_channel(ckind,cname){
		$('#savebutton').show();
		neworder=neworder+5;
		$('.addactiontr').before('<tr class="new_channeltr">'+$('#newchannelhtml tr').html()+'</tr>');
		if (ckind>0)
		{
			$('.new_channeltr').eq(-2).find("input").eq(0).val(cname);
			$('.new_channeltr').eq(-2).find("select").eq(0).find("option[value='"+ckind+"']").attr("selected",true);
		}
		$('.new_channeltr').eq(-2).find("input").eq(1).val(neworder);
	}
});
function del_channeltr(delbtn){
	$(delbtn).parent().parent().remove();
	if ($('.new_channeltr').length==1)
	{
		$('#savebutton').hide();
	}
}
function changeorder(cid,corder){
	if ($('.new_channeltr').length>1)
	{
		alert("请先保存栏目");
		return;
	}
		var corder=prompt("请输入新的排序",corder);
		if (corder!==null)
		{
			var re = /^[0-9]+.?[0-9]*$/;
			if (!re.test(corder))
			{
				alert("请输入数字");
			}else{
				window.location.href='?do=sadmin_corder&cid='+cid+'&corder='+corder+'&<?php echo(newtoken(2));?>';
			}
		}
	}
</script>
