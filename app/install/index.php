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


if (!defined('admin')) {
	echo("<meta http-equiv=refresh content='0; url=../../install'>");
	exit();
}
if(power('alevel')!=3) {die('error');}
$cid=0;
$cname='站点变量';
//站点变量
$site_var=array(
array(1,'站点标题'),
array(1,'关键词'),
array(2,'描述'),
array(5,'logo图片'),
array(1,'备案号'),
array(2,'统计代码'),
);
channelrouter();
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>栏目配置</strong> </div>   <div id="mainBox">
    <h3>
	<a style="margin-left:10px" href="?do=sadmin" class="actionBtn">返回</a>
	<a style="margin-left:10px" href="?do=sadmin_cadd" class="actionBtn" target="_blank">增加栏目</a>
	<i>添加常用站点变量</i>
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
	if($linkbasic) {
		echo("<meta http-equiv=refresh content='0; url=?do=sadmin_sbasic'>");
	}
?>
<?php
$neworder=0;
foreach($site_var as $val) {
	$neworder+=5;
	?>
<tr class="new_moudletr">
	<td><input name="strname[]" value="<?php echo($val[1]);?>" size="20" class="inputtext"></td>
	<td>
	<select name="inputkind[]"> 
	<?php
	foreach($inputkindarray as $value) {
		if($value['id']==$val[0]) {
			echo('<option value="'.$value['id'].'" selected>'.$value['name'].'</option>');
		}else {
			echo('<option value="'.$value['id'].'">'.$value['name'].'</option>');
		}
	}
	?>
	</select>
	</td>
	<td>
	<input name="strorder[]" value="<?php echo($neworder);?>" size="10" class="inputtext">
	</td>
	<td align=center>
		<a href="javascript:;" onclick="del_moudletr(this)">删除</a>
	</td>
</tr>
	<?php
}
?>
		<tr  class="addactiontr">
			<td colspan="4">
				<input type="submit" value="保存"  class="btn"  style="float:right;margin-right:30px">
			</td>
		</tr>
		
		</table>
		</form>
	</div>
</div>
<script type="text/javascript">
function del_moudletr(delbtn){
	$(delbtn).parent().parent().remove();
}
</script>