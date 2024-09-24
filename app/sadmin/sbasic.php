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
	$link= $GLOBALS['db'] -> one("SELECT * FROM ".tableex('channel')." where cid='$cid';");
	$cname=$link['cname'];
}else {
	$cid=0;
	$cname='站点变量';
}
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>栏目配置</strong> </div>   <div id="mainBox">
    <h3>
	<a style="margin-left:10px" href="?do=sadmin" class="actionBtn">返回</a>
	<?php
	if($cid>0) {
		if($link['ckind']==1 || $link['ckind']==2) {
			echo('<a style="margin-left:10px" href="?do=sadmin_sbasic&cid='.$cid.'" class="actionBtn">栏目变量</a>');
		}
		if($link['ckind']==2) {
			echo('<a style="margin-left:10px" href="?do=sadmin_aindex&cid='.$cid.'" class="actionBtn">字段管理</a>');
		}
		echo('<a href="?do=sadmin_cedit&cid='.$cid.'" class="actionBtn">栏目配置</a>');
	}else {
		echo('<a style="margin-left:10px" href="?do=sadmin_cout&cid=0&nohtml=1" class="actionBtn">导出站点变量</a>');
	}
	?>
	

	<?php echo($cname);?> <i>变量列表</i>
	</h3>

<form id="form1" method="post" action="?do=sadmin_saddpost">
<input type="hidden" name="strcid" value="<?php echo($cid);?>">
<?php newtoken();?>
<table width="700px" border="0" cellpadding="8" cellspacing="0" class="tablerowtip" align=center>
	 <tr>
	<th>变量名</th>
	<th>变量类型</th>
	<th width="80">排序</th>
	<th width="180">操作</th>
</tr>
<?php
$neworder=0;
	$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('str')." where strcid='$cid' and inputkind>0 order by strorder asc");
	$linkbasic = $GLOBALS['db'] -> fetchall($query);
foreach ($linkbasic as $link1){
	$neworder=$link1['strorder'];
?>
<tr>
<td>
<?php echo($link1['strname']);?>
<?php if($link1['ifadmin']==1) {echo(' <a style="color:#FF0000" title="管理员变量">管</a>');} ?>
<?php
	$thissetting=explode('|',$link1['strarray']);
	$val=inputkindinfo($link1['inputkind']);
	if($val && $val['strfrom']==1) {
		if(count($thissetting)<2) {
			echo(' <a href="?do=sadmin_sbasicedit&cid='.$link1['strcid'].'&id='.$link1['id'].'" style="color:#FF0000">尚未配置</a>');
		}else{
			$query = $GLOBALS['db'] -> one("SELECT id FROM ".tableex('moudle')." where cid='".$thissetting[0]."' and mname='".$thissetting[1]."' and hide<>'1' limit 1");
			if(!$query) {
				echo(' <a href="?do=sadmin_sbasicedit&cid='.$link1['strcid'].'&id='.$link1['id'].'" style="color:#FF0000">配置有误</a>');
			}
		}
	}elseif($val && $val['id']==30) {
		if(empty($link1['strarray'])) {
			echo(' <a href="?do=sadmin_sbasicedit&cid='.$link1['strcid'].'&id='.$link1['id'].'" style="color:#FF0000">尚未配置</a>');
		}elseif(!function_exists($link1['strarray'])) {
			echo(' <a href="?do=sadmin_sbasicedit&cid='.$link1['strcid'].'&id='.$link1['id'].'" style="color:#FF0000">函数不存在</a>');
		}
	}
?>
</td>
<td>
<?php
if($val) {
	echo($val['name']);
}
?>
</td>
<td align="center">
<?php echo($link1['strorder']);?>
</td>
<td align="center">
<a href="?do=sadmin_sbasicedit&cid=<?php echo($link1['strcid']);?>&id=<?php echo($link1['id']);?>">配置</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="?do=sadmin_code&cid=<?php echo($link1['strcid']);?>&id=<?php echo($link1['id']);?>&kind=0">调用</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="javascript:;"  onclick="javascript:confirmurl('?do=sadmin_sdel&id=<?php echo($link1['id']);?>&<?php newtoken(2);?>','确定删除此变量吗？');">删除</a>
</td>
</tr>
<?php
	}
?>
		<tr  class="addactiontr">
			<td colspan="4">
				<a href="javascript:;" class="add_moudletr" style="color:#FF6600">[+]增加变量</a>
				<a style="margin-left:10px" href="?do=sadmin_cin&cid=<?php echo($cid);?>&cinkind=3" class="actionBtn" target="_blank">导入变量</a>
				<?php
					if($cid==0) {
				?>
					<a style="margin-left:10px" href="//uuu.la/temphelper/?page=1"  target="_blank" class="actionBtn" target="_blank">站点变量调用帮助</a>
				<?php
					}else {
				?>
					<a style="margin-left:10px" href="//uuu.la/temphelper/?page=2"  target="_blank" class="actionBtn" target="_blank">栏目变量调用帮助</a>
				<?php
					}
				?>
				

				<input type="submit" id="savebutton" value="保存"  class="btn"  style="float:right;margin-right:10px;display:none">
			</td>
		</tr>
<?php
if(isset($common_var) && count($common_var)>0) {
?>
<tr class="quick_moudle">
<td colspan="4" align="left">
<span>常用变量:</span> 
<?php
foreach($common_var as $val) {
	echo('<a href="javascript:;" rel="'.$val[0].'" title="'.$val[1].'">'.$val[1].'</a>');
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
<script type="text/javascript">
var neworder=<?php echo($neworder);?>;
$(function(){
	$('.add_moudletr').click(quick_add_str);
	$('.quick_moudle a').click(function(){
		if ($(this).attr('rel')!='')
		{
			quick_add_str($(this).attr('rel'),$(this).html());
		}
	});
	function quick_add_str(strkind,strname){
		$('#savebutton').show();
		neworder=neworder+5;
		$('.addactiontr').before('<tr class="new_moudletr">'+$('#newmoudlehtml tr').html()+'</tr>');
		if (strkind>0)
		{
			$('.new_moudletr').eq(-2).find("input").eq(0).val(strname);
			$('.new_moudletr').eq(-2).find("option[value='"+strkind+"']").attr("selected",true);
		}
		$('.new_moudletr').eq(-2).find("input").eq(1).val(neworder);
	}
});
function del_moudletr(delbtn){
	$(delbtn).parent().parent().remove();
	if ($('.new_moudletr').length==1)
	{
		$('#savebutton').hide();
	}
}
</script>
<table id="newmoudlehtml" style="display:none">
<tr class="new_moudletr">
			<td><input name="strname[]" placeholder="变量名" value="" size="20" class="inputtext"></td>
			<td>
			<select name="inputkind[]"> 
			<?php
			foreach($inputkindarray as $val) {
				if($val['id']==1) {
					echo('<option value="'.$val['id'].'" selected>'.$val['name'].'</option>'."\r\n");
				}else {
					echo('<option value="'.$val['id'].'">'.$val['name'].'</option>'."\r\n");
				}
			}
			?>
			</select>
			</td>
			<td>
			<input name="strorder[]" value="" size="10" class="inputtext">
			</td>
			<td align=center>
				<a href="javascript:;" onclick="del_moudletr(this)">删除</a>
			</td>
		</tr>
</table>