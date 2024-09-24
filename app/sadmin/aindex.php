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
$cid=intval($_GET['cid']);
$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('channel')." where cid='$cid' limit 1");
$link = $GLOBALS['db'] -> fetchone($query);
if($link['ckind']!=2) {
	adminmsg('','该栏目不是文章栏目');
}
$cname=$link['cname'];
$csetting=json_decode($link['csetting'],1);
if(isset($csetting['articletable']) && $csetting['articletable']<>tableex('')) {
	$articletable=$csetting['articletable'];
}else {
	$articletable='尚未填写';
}
if($articletable=='尚未填写') {
	$articletablelist['sql']='';
}else {
	if($site_db['database']=='sqlitepdo') {
		$query = $GLOBALS['db'] -> query("SELECT * FROM sqlite_master WHERE type='table' and name='".$articletable."';");
		$articletablelist = $GLOBALS['db'] -> fetchone($query);
	}elseif($site_db['database']=='mysqlpdo' || $site_db['database']=='mysql') {
		$query = $GLOBALS['db'] -> query("select table_name from information_schema.tables where table_name='$articletable' and TABLE_SCHEMA='".$site_db['dbname']."';");
		$tablenames = $GLOBALS['db'] -> fetchone($query);
		if($tablenames) {
			$query = $GLOBALS['db'] -> query("show columns from `$articletable`");
			$tablecolumns= $GLOBALS['db'] -> fetchall($query);
			$articletablelist['sql']=' ';
			foreach ($tablecolumns as $value) 
			{    
				$articletablelist['sql'].=' '.$value['Field'].' ';
			}
		}else {
			$articletablelist['sql']='';
		}
	}else{
		die('database error');
	}
}
$someonenotadd=0;
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>栏目配置</strong> </div>   <div id="mainBox">
    <h3>
		<a style="margin-left:10px" href="?do=sadmin" class="actionBtn">返回</a>
	<?php
	if($link['ckind']==1 || $link['ckind']==2) {
		echo('<a style="margin-left:10px" href="?do=sadmin_sbasic&cid='.$cid.'" class="actionBtn">栏目变量</a>');
	}
	if($link['ckind']==2) {
		echo('<a style="margin-left:10px" href="?do=sadmin_aindex&cid='.$cid.'" class="actionBtn">字段管理</a>');
	}
	?>
		<a href="?do=sadmin_cedit&cid=<?php echo($cid);?>" class="actionBtn">栏目配置</a>
	<?php echo($cname);?> <i>字段管理</i></h3>

<form method="post" action="?do=sadmin_aaddpost" id="form1" name="form1">
<?php newtoken();?>
<input name="cid"  value="<?php echo($cid);?>" type="hidden">
<input name="createdtable" id="createdtable" value="0" type="hidden">
<table width="100%" border="0" cellpadding="8" cellspacing="0" class="tablerowtip">
<tr>
	<th width="120">字段名</th>
	<th>字段描述</th>
	<th>字段类型</th>
	<th width="80">字段排序</th>
	<th>字段</th>
	<th width="180">操作</th>
</tr>
<tr>
	<td>id</td>
	<td>编号</td>
	<td>系统字段</td>
	<td align=center>0</td>
	<td  align=center>
		<?php
		if($articletablelist['sql'] && (stripos($articletablelist['sql'],'[id]')>0 || stripos($articletablelist['sql'],' id ')>0 || stripos($articletablelist['sql'],'"id"')>0 || stripos($articletablelist['sql'],'"(id "')>0)) {
			echo('已建');
		}else {
			$someonenotadd=1;
			echo('<font color="#FF0000">未建</font>');
		}
		?>
		</td>
	<td align=center>无</td>
</tr>
<?php
$neworder=0;
$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('moudle')." where cid='$cid' order by morder asc");
$links = $GLOBALS['db'] -> fetchall($query);
foreach($links as $link) {
	$neworder=$link['morder'];
	$thissetting=explode('|',$link['strarray']);
	$msetting=json_decode($link['msetting'],1);
?>
<tr>
	<td>
	<?php echo($link['mname']);?>
	</td>
	<td >
	<?php echo($link['minfo']);?>
	<?php if($link['ifadmin']==1) {echo('<a style="color:#FF0000" title="管理员字段">管</a>');} ?>
	<?php if($link['hide']==1) {echo('<a style="color:#FF0000" title="已禁用此字段">禁</a>');} ?>
	<?php if($link['ifshow']==1){echo('<a style="color:#33CC00" title="后台列表页显示">列</a>');};?>
	<?php if(isset($msetting['adminsearch'])){echo('<a style="color:#33CC00" title="后台列表页搜索字段">搜</a>');};?>
	<?php if($link['ifonly']==1) {echo('<a style="color:#33CC00" title="数据唯一">唯</a>');} ?>
	<?php if($link['ifmore']==1) {echo('<a style="color:#33CC00" title="默认隐藏">隐</a>');} ?>
	<?php if(!empty($link['fid'])) { echo('<a style="color:#33CC00" title="上级字段:'.$link['fid'].'">二</a>'); } ?>
	<?php
		$val=inputkindinfo($link['mkind']);
		if($val && $val['strfrom']==1) {
			if(count($thissetting)<2) {
				echo(' <a href="?do=sadmin_aedit&cid='.$link['cid'].'&id='.$link['id'].'" style="color:#FF0000">尚未配置</a>');
			}else{
				$query = $GLOBALS['db'] -> one("SELECT id FROM ".tableex('moudle')." where cid='".$thissetting[0]."' and mname='".$thissetting[1]."' and hide<>'1' limit 1");
				if(!$query) {
					echo(' <a href="?do=sadmin_aedit&cid='.$link['cid'].'&id='.$link['id'].'" style="color:#FF0000">配置有误</a>');
				}
			}
		}elseif($val && $val['id']==30) {
			if(empty($link['strarray'])) {
				echo(' <a href="?do=sadmin_aedit&cid='.$link['cid'].'&id='.$link['id'].'" style="color:#FF0000">尚未配置</a>');
			}elseif(!function_exists($link['strarray'])) {
				echo(' <a href="?do=sadmin_aedit&cid='.$link['cid'].'&id='.$link['id'].'" style="color:#FF0000">函数不存在</a>');
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
	<?php echo($link['morder']);?>
	</td>
	<td align=center>
	<?php
	if(stripos($articletablelist['sql'],'['.$link['mname'].']')>0 || stripos($articletablelist['sql'],' '.$link['mname'].' ')>0  || stripos($articletablelist['sql'],'"'.$link['mname'].'"')>0  || stripos($articletablelist['sql'],'"('.$link['mname'].' "')>0) {
		echo('已建');
		if($link['ifcreated']==0) {
			$query = $GLOBALS['db'] -> query("UPDATE ".tableex('moudle')." SET ifcreated='1' WHERE id='".$link['id']."'");
		}
	}else {
		$someonenotadd=1;
		echo('<font color="#FF0000">未建</font>');
		if($link['ifcreated']==1) {
			$query = $GLOBALS['db'] -> query("UPDATE ".tableex('moudle')." SET ifcreated='0' WHERE id='".$link['id']."'");
		}
	}
?>
	</td>
	<td align=center>
		<a href="?do=sadmin_aedit&cid=<?php echo($link['cid']);?>&id=<?php echo($link['id']);?>">配置</a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="?do=sadmin_code&cid=<?php echo($link['cid']);?>&id=<?php echo($link['id']);?>&kind=1">调用</a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="javascript:;"  onclick="javascript:confirmurl('?do=sadmin_adel&id=<?php echo($link['id']);?>&<?php newtoken(2);?>','确定删除[<?php echo($link['mname']);?>]吗？\r\n系统并不会在数据库中删除该字段\r\n请手动在数据库中删除');">删除</a>
	</td>
</tr>
<?php
}
?>


<tr class="addactiontr">
<td colspan="6" align="left">
<a href="javascript:;" class="add_moudletr" style="color:#FF6600">[+]增加字段</a>
<a style="margin-left:10px" href="?do=sadmin_cin&cid=<?php echo($cid);?>&cinkind=2" >导入字段</a>
<a style="margin-left:10px" href="?do=list_add&cid=<?php echo($cid);?>&test=1" >批量添加测试文章</a>
<a style="margin-left:10px"  href="//uuu.la/temphelper/?page=3"  target="_blank">文章调用帮助</a>
<input type="button" id="savebutton1" value="创建至数据库"  class="btn add_table"  style="float:right;<?php if($someonenotadd==0){echo('display:none');}?>">
<input type="submit" id="savebutton" value="保存"  class="btn"  style="float:right;margin-right:10px;display:none">
</td></tr>
<?php
if(isset($common_moudle) && count($common_moudle)>0) {
	?>
	<tr class="quick_moudle">
<td colspan="6" align="left">
<span>常用字段:</span> 
<?php
foreach($common_moudle as $val) {
	echo('<a href="javascript:;" rel="'.$val[0].'" title="'.$val[1].'">'.$val[2].'</a>');
}
?>
</td></tr>
	<?php
}
?>
<script>
$(function(){
	$('.quick_moudle a[rel=16]').hover(function(){
		var c = '#'; 
		var cArray = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F']; 
		for(var i = 0; i < 6;i++) 
		{ 
		var cIndex = Math.round(Math.random()*15); 
		c += cArray[cIndex]; 
		} 
		$(this).css('color',c);
	},function(){
		$(this).delay(300).css('color','#ccc');
	});
});
</script>
</table>
</form>
		</div>
 </div>
<script type="text/javascript">
var neworder=<?php echo($neworder);?>;
$(function(){
	$('.add_moudletr').click(quick_add_moudle);
	$('.quick_moudle a').click(function(){
		if ($(this).attr('rel')!='')
		{
			quick_add_moudle($(this).attr('rel'),$(this).attr('title'),$(this).html());
		}
	});
	function quick_add_moudle(mkind,mname,minfo){
		$('#savebutton1').val('保存并创建至数据库');
		$('#savebutton').show();
		$('#savebutton1').show();
		neworder=neworder+5;
		$('.addactiontr').before('<tr class="new_moudletr">'+$('#newmoudlehtml tr').html()+'</tr>');
		if (mkind>0)
		{
			$('.new_moudletr').eq(-2).find("input").eq(0).val(mname);
			$('.new_moudletr').eq(-2).find("input").eq(1).val(minfo);
			$('.new_moudletr').eq(-2).find("option[value='"+mkind+"']").attr("selected",true);
		}
		$('.new_moudletr').eq(-2).find("input").eq(2).val(neworder);
	}
	$('.add_table').click(function(){
		if ( window.confirm('此操作将新增数据库表(如果已存在则不会新建) \r\n模型内的字段将会新建到数据库表中'))
		{
			$('#createdtable').val('1');
			$('#form1').submit();
		}
		$('#createdtable').val('0');
	});
});
function del_moudletr(delbtn){
	$(delbtn).parent().parent().remove();
	if ($('.new_moudletr').length==1)
	{
		$('#savebutton').hide();
		$('#savebutton1').hide();
	}
}
</script>
<table id="newmoudlehtml" style="display:none">
<tr class="new_moudletr">
<td><input style="width:110px" name="mname[]"  value="" size="30" placeholder="字段名"  class="inputtext"> </td>
<td>
<input name="minfo[]" style="width:140px" value="" size="30" placeholder="字段描述" class="inputtext">
</td>
<td><select name="mkind[]">
<?php
foreach($inputkindarray as $val) {
	if($val['id']==1) {
		echo('<option value="'.$val['id'].'" selected>'.$val['name'].'</option>'."\r\n");
	}else {
		echo('<option value="'.$val['id'].'">'.$val['name'].'</option>'."\r\n");
	}
}
?>
</select></td>
<td><input name="morder[]" size="10"  value="" size="10" class="inputtext moudlemorder"></td>

<td></td>
<td align=center>
<a href="javascript:;" onclick="del_moudletr(this)">删除</a>
</td>
</tr>
</table>
