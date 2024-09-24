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
if($cid=='') {die();}
$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('channel')." where cid='$cid'");
$link = $GLOBALS['db'] -> fetchone($query);
if(!$link) {
	die('no channel');
}
$csetting=json_decode($link['csetting'],1);
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>栏目配置</strong> </div>   <div id="mainBox">
    <h3><a style="margin-left:10px" href="?do=sadmin" class="actionBtn">返回</a>
	<?php
	if($link['ckind']==1 || $link['ckind']==2) {
		echo('<a style="margin-left:10px" href="?do=sadmin_sbasic&cid='.$cid.'" class="actionBtn">栏目变量</a>');
	}
	if($link['ckind']==2) {
		echo('<a style="margin-left:10px" href="?do=sadmin_aindex&cid='.$cid.'" class="actionBtn">字段管理</a>');
	}
	?>
	<a href="?do=sadmin_cedit&cid=<?php echo($cid);?>" class="actionBtn">栏目配置</a>
	<?php echo($link['cname']);?> <i>栏目配置</i></h3>
	<form id="form1" method="post" action="?do=sadmin_ceditpost">
	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="">
<?php newtoken();?>
		<input type="hidden" name="cid" value="<?php echo($link['cid']);?>">
		<tr><td width="100" align="right">上级栏目</td>
				<td align="left">
<select name="fid">
<?php
channel_select($link['fid']);
?>
</select>
				</td></tr>
			<tr><td width="100" align="right">栏目名</td>
				<td align="left">
				<input type="text" name="cname" value="<?php echo(htmlspecialchars($link['cname']));?>" class="inputtext" size=40>
				</td></tr>
				<tr>
					<td width="100" align="right">栏目域名</td>
					<td align="left">
					<input class="inputtext inputshowtips" type="text" size="40" name="channeldomain" value="<?php if(isset($csetting['channel_domain'])) { echo($csetting['channel_domain']);}?>">
					<i class="ishowtips"><?php if(defined('SystemDomain') && SystemDomain==false) {echo('当前网站尚未绑定主域名,请先在站点配置文件中绑定主域名.');}?> 只需填写域名,不需要http://,多个域名使用 ; 分割,不需要绑定则留空.  </i>
					</td>
				</tr>
			<tr><td width="100" align="right">栏目备注</td>
				<td align="left">
				<input type="text" size="80" name="cnote" value="<?php if(isset($csetting['cnote'])) { echo($csetting['cnote']);}?>" class="inputtext">
				</td></tr>
			<tr><td width="100" align="right">栏目类型</td><td align="left">
			<label><input type="radio" onclick="javascript:showtable(1);" name="ckind"  value="1" <?php if($link['ckind']==1) {echo('checked');}?>>单页栏目 </label>
			<label><input type="radio" onclick="javascript:showtable(2);" name="ckind"  value="2" <?php if($link['ckind']==2) {echo('checked');}?>>文章栏目</label>
			<label><input type="radio" onclick="javascript:showtable(5);" name="ckind"  value="5" <?php if($link['ckind']==5) {echo('checked');}?>>过渡栏目</label>
			<label><input type="radio" onclick="javascript:showtable(3);" name="ckind"  value="3" <?php if($link['ckind']==3) {echo('checked');}?>>前台链接</label>
			<label><input type="radio" onclick="javascript:showtable(4);" name="ckind"  value="4" <?php if($link['ckind']==4) {echo('checked');}?>>后台链接</label>
				</td></tr>
<tr><td width="100" align="right">后台显示设置</td>
				<td align="left">
				<label><input type="checkbox" name="ifshowadmin" id="ifshowadmin"  value="0" <?php if($link['ifshowadmin']==1) {echo('checked');}?>>后台显示该栏目</label>
				<label><input type="checkbox" name="ifshowleft"  id="ifshowleft" value="0" <?php if($link['ifshowleft']==1) {echo('checked');}?>>后台左侧显示</label>
				<script type="text/javascript">
					$(function(){
						$('#ifshowadmin').change(function(){
							if ($('#ifshowadmin').prop('checked'))
							{
								$('#ifshowleft').prop('checked',true);
								$('#ifshowleft').prop('disabled',false);
							}else{
								$('#ifshowleft').prop('checked',false);
								$('#ifshowleft').prop('disabled',true);
							}
						});
					});
				</script>
				</td></tr>
				
				</table>
<!-- 单页 -->
	<div style="display:none" id="table1">
	 <table width="100%" border="0" cellpadding="8" cellspacing="0" class="" style="border-top:0px;border-bottom:0px;">
		<tr><td width="100" align="right">前台设置</td>
			<td align="left">
			<label><input type="checkbox" class="disable_tips1" name="ifshow1"<?php if(isset($link['ifshow']) && $link['ifshow']==0) { echo(' checked');}?>>禁用该栏目</label>
			<label><input type="checkbox" class="disable_tips11" name="ifshownav1"<?php if(isset($link['ifshownav']) && $link['ifshownav']==1) { echo(' checked');}?>>导航栏显示</label>
			<label><input type="checkbox" name="newwindow1"<?php if(isset($link['newwindow']) && $link['newwindow']==1) { echo(' checked');}?>>新窗口中打开</label>
			</td>
		</tr>
	<tr>
		<td width="100" align="right">
			栏目页面[<a href="http://uuu.la/help/page.html" target="_blank">帮助</a>]
		</td>
		<td align="left">
			<label>栏目地址: <input class="inputtext" type="text" size="35" name="channel_url1" value="<?php if(isset($csetting['channel_url'])) { echo($csetting['channel_url']);}?>"></label>
			<label>&nbsp;&nbsp;&nbsp;&nbsp;页面缓存时间: <input class="inputtext" type="text" size="5" name="channel_urlcache1" value="<?php if(isset($csetting['channel_urlcache'])) { echo($csetting['channel_urlcache']);}else{echo('0');}?>"> <i>秒</i></label>
			<label>&nbsp;&nbsp;&nbsp;模板文件: <input class="inputtext" type="text" size="30" id="template1" name="template1" value="<?php if(isset($csetting['template'])) { echo($csetting['template']);}?>"></label>
			<a href="javascript:;" rel="template1" class="edittemplate">编辑</a> <a href="javascript:;" class="chosetemplate">选择</a>
		</td>
	</tr>
	</table>
</div>
<!-- 文章 -->
	<div style="display:none" id="table2">
 <table width="100%" border="0" cellpadding="8" cellspacing="0" class="" style="border-top:0px;border-bottom:0px;">
	<tr><td width="100" align="right">栏目数据库表</td>
				<td align="left">
				<label><input class="inputtext inputshowtips" type="text" size="25" name="articletable" value="<?php if(isset($csetting['articletable'])) { echo($csetting['articletable']);}else{echo(tableex(''));}?>">
				<i class="ishowtips">
					<?php
					if(isset($csetting['articletable']) && strlen($csetting['articletable'])>0) {
						echo('默认文章表的字段尽量保持一致,不同类型的栏目请使用不同的表');
					}elseif(isset($csetting['articletable']) && $csetting['articletable']==tableex('')){
						echo('请填写该栏目在数据库中的表名(只限英文或英文+数字组合)');
					}else {
						echo('请填写该栏目在数据库中的表名(只限英文或英文+数字组合)');
					}
					?>
				</i></label>

				</td></tr>


<tr><td width="100" align="right">编辑设置[<a href="http://uuu.la/help/editset.html" target="_blank">帮助</a>]</td>
	<td align="left">
	<label><input type="checkbox" name="listnoadd"<?php if(isset($csetting['listnoadd']) && $csetting['listnoadd']==1) { echo(' checked');}?>>禁止添加</label>
	<label><input type="checkbox" name="listnoedit"<?php if(isset($csetting['listnoedit']) && $csetting['listnoedit']==1) { echo(' checked');}?>>禁止编辑</label> 
	<label><input type="checkbox" name="listnodel"<?php if(isset($csetting['listnodel']) && $csetting['listnodel']==1) { echo(' checked');}?>>禁止删除</label>
	<label><input type="checkbox" name="listarticlemove"<?php if(isset($csetting['listarticlemove']) && $csetting['listarticlemove']==1) { echo(' checked');}?>>文章转移</label>
	<label><input type="checkbox" name="listadminuid"<?php if(isset($csetting['listadminuid']) && $csetting['listadminuid']==1) { echo(' checked');}?>>文章限制</label>
	<label><input type="checkbox" name="listcopy"<?php if(isset($csetting['listcopy']) && $csetting['listcopy']==1) { echo(' checked');}?>>显示复制按钮</label>
	<label><input type="checkbox" name="listshowadminname"<?php if(isset($csetting['listshowadminname']) && $csetting['listshowadminname']==1) { echo(' checked');}?>>显示文章作者</label>
	<label><input type="checkbox" name="listfidshow"<?php if(isset($csetting['listfidshow']) && $csetting['listfidshow']==1) { echo(' checked');}?>>默认显示父分类</label>
</td></tr>
<tr><td width="100" align="right">前台设置</td>
<td align="left">
<label><input type="checkbox" class="disable_tips2" name="ifshow2"<?php if(isset($link['ifshow']) && $link['ifshow']==0) { echo(' checked');}?>>禁用该栏目</label>
<label><input type="checkbox" class="disable_tips22" name="ifshownav2"<?php if(isset($link['ifshownav']) && $link['ifshownav']==1) { echo(' checked');}?>>导航栏显示</label>
<label><input type="checkbox" name="newwindow2"<?php if(isset($link['newwindow']) && $link['newwindow']==1) { echo(' checked');}?>>新窗口中打开</label>
</td></tr>

<tr><td width="100" align="right">文章列表显示</td>
<td align="left">
默认显示数量:
<input class="inputtext" type="text" size="5" name="temppage_size" value="<?php if(isset($csetting['temppage_size'])) { echo($csetting['temppage_size']);}else{echo('');}?>">
&nbsp;&nbsp;&nbsp;默认排序方式:
<input class="inputtext inputshowtips" type="text" size="30" name="temppage_order" value="<?php if(isset($csetting['temppage_order'])) { echo($csetting['temppage_order']);}else{echo('');}?>"> <i class="ishowtips">如: id desc</i>
</td></tr>



<tr><td width="100" align="right">栏目页面[<a href="http://uuu.la/help/page.html" target="_blank">帮助</a>]</td>
<td align="left">

<label>栏目地址: <input class="inputtext" type="text" size="35" name="channel_url2" value="<?php if(isset($csetting['channel_url'])) { echo($csetting['channel_url']);}?>"></label>
&nbsp;&nbsp;&nbsp;&nbsp;<label>页面缓存时间: <input class="inputtext" type="text" size="5" name="channel_urlcache2" value="<?php if(isset($csetting['channel_urlcache'])) { echo($csetting['channel_urlcache']);}else{echo('0');}?>"> <i>秒</i></label>
<label>&nbsp;&nbsp;&nbsp;模板文件: <input class="inputtext" type="text" size="30"  id="template2" name="template2" value="<?php if(isset($csetting['template'])) { echo($csetting['template']);}?>"></label>
<a href="javascript:;" rel="template2" class="edittemplate">编辑</a>  <a href="javascript:;" class="chosetemplate">选择</a>
<br><br>
<label>分页地址: <input class="inputtext" type="text" size="35" name="channel_pageurl" value="<?php if(isset($csetting['channel_pageurl'])) { echo($csetting['channel_pageurl']);}?>"></label>
&nbsp;&nbsp;&nbsp;&nbsp;<label>页面缓存时间: <input class="inputtext" type="text" size="5" name="channel_pageurlcache" value="<?php if(isset($csetting['channel_pageurlcache'])) { echo($csetting['channel_pageurlcache']);}else{echo('0');}?>"> <i>秒</i></label>
<label>&nbsp;&nbsp;&nbsp;模板文件: <input class="inputtext" type="text" size="30" id="templatelist" name="templatelist" value="<?php if(isset($csetting['templatelist'])) { echo($csetting['templatelist']);}?>"></label>
<a href="javascript:;" rel="templatelist" class="edittemplate">编辑</a>  <a href="javascript:;" class="chosetemplate">选择</a>

<br><br>

<label>文章地址: <input class="inputtext" type="text" size="35" name="channel_articleurl" value="<?php if(isset($csetting['channel_articleurl'])) { echo($csetting['channel_articleurl']);}else{echo('');}?>"></label>
&nbsp;&nbsp;&nbsp;&nbsp;<label>页面缓存时间: <input class="inputtext" type="text" size="5" name="channel_articleurlcache" value="<?php if(isset($csetting['channel_articleurlcache'])) { echo($csetting['channel_articleurlcache']);}else{echo('0');}?>"> <i>秒</i></label>
<label>&nbsp;&nbsp;&nbsp;模板文件: <input class="inputtext" type="text" size="30" id="templatearticle" name="templatearticle" value="<?php if(isset($csetting['templatearticle'])) { echo($csetting['templatearticle']);}?>"></label>
<a href="javascript:;" rel="templatearticle" class="edittemplate">编辑</a>  <a href="javascript:;" class="chosetemplate">选择</a>

				
				</td></tr>
				</table>
				</div>
<!-- 过渡栏目 -->
	<div style="display:none" id="table5">
 <table width="100%" border="0" cellpadding="8" cellspacing="0" class="" style="border-top:0px;border-bottom:0px;">
	<tr><td width="100" align="right">前台设置</td>
				<td align="left">
<label><input type="checkbox" class="disable_tips" name="ifshow5"<?php if(isset($link['ifshow']) && $link['ifshow']==0) { echo(' checked');}?>>禁用该栏目</label>
<label><input type="checkbox" name="ifshownav5"<?php if(isset($link['ifshownav']) && $link['ifshownav']==1) { echo(' checked');}?>>导航栏显示</label>
<label><input type="checkbox" name="newwindow5"<?php if(isset($link['newwindow']) && $link['newwindow']==1) { echo(' checked');}?>>新窗口中打开</label>

				</td></tr>
				</table>
</div>

<!-- 前台链接 -->
	<div style="display:none" id="table3">
 <table width="100%" border="0" cellpadding="8" cellspacing="0" class="" style="border-top:0px;border-bottom:0px;">
	<tr><td width="100" align="right">前台设置</td>
				<td align="left">
链接地址:&nbsp;<input type="text" class="inputtext" name="cvalue" size="50" value="<?php if(strlen($link['cvalue'])<50) {echo($link['cvalue']);}?>">
<label><input type="checkbox" class="disable_tips" name="ifshow3"<?php if(isset($link['ifshow']) && $link['ifshow']==0) { echo(' checked');}?>>禁用该栏目</label>
<label><input type="checkbox" name="ifshownav3"<?php if(isset($link['ifshownav']) && $link['ifshownav']==1) { echo(' checked');}?>>导航栏显示</label>
<label><input type="checkbox" name="newwindow3"<?php if(isset($link['newwindow']) && $link['newwindow']==1) { echo(' checked');}?>>新窗口中打开</label>

				</td></tr>
				</table>
</div>

<!-- 后台链接 -->
	<div style="display:none" id="table4">
<table width="100%" border="0" cellpadding="8" cellspacing="0" class="" style="border-top:0px;border-bottom:0px;">
	<tr><td width="100" align="right">链接地址</td>
				<td align="left">
<input type="text" class="inputtext" name="cvalue1" size="50" value="<?php if(strlen($link['cvalue'])<50) {echo($link['cvalue']);}?>">
<label><input type="checkbox" name="newwindow4"<?php if(isset($link['newwindow']) && $link['newwindow']==1) { echo(' checked');}?>>新窗口中打开</label>
				</td></tr>
				</table>
</div>

 <table width="100%" border="0" cellpadding="8" cellspacing="0" class="" style="border-top:0px;border-bottom:0px;">
 <tr><td width="100" align="right" valign="top">其他页面[<a href="javascript:;" class="addotherpage">增加</a>]</td>
<td align="left" id="otherpage">
<?php
$otherpagearray=array();
if(isset($csetting['otherpage'])) {
	$otherpagearray=json_decode($csetting['otherpage'],1);
}
foreach($otherpagearray as $key=>$val) {
	echo('<div>
<label>页面地址: <input class="inputtext" type="text" size="35" name="otherpageurl[]" value="'.$val['uri'].'"></label>
&nbsp;&nbsp;&nbsp;&nbsp;<label>页面缓存时间: <input class="inputtext" type="text" size="5" name="otherpagecache[]" value="'.$val['cache'].'"> <i>秒</i></label>
<label>&nbsp;&nbsp;&nbsp;模板文件: <input class="inputtext" type="text" size="30" name="otherpagetemplate[]" value="'.$val['res'].'"></label>
<a href="javascript:;"  class="edittemplate">编辑</a>
<a href="javascript:;"  class="chosetemplate">选择</a>
<a href="javascript:;"  class="delthispage">删除</a><br><br>
</div>');
}
?>
</td></tr>
			<tr><td width="100" align="right">栏目排序</td>
				<td align="left">
				<input  class="inputtext" type="text" name="corder" size="10" value="<?php echo($link['corder']);?>">
				</td></tr>
			</table>
</td></tr>
 <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic"  style="border-top:0px;border-bottom:0px;">
      <tr>
       <td width="100"></td>
       <td>
        <input class="btn btn140" type="submit" value="提交" style="width:120px;"/>&nbsp;&nbsp;
<a href="?do=sadmin_cin&cid=<?php echo($cid);?>&cinkind=1" class="actionBtn">导入栏目配置</a>
       </td>
      </tr>
     </table>
    </form>
       </div>
 </div>



<script type="text/javascript">
showtable(<?php echo($link['ckind'])?>);
function showtable(id){
document.getElementById('table1').style.display = "none";
document.getElementById('table2').style.display = "none";
document.getElementById('table3').style.display = "none";
document.getElementById('table4').style.display = "none";
document.getElementById('table5').style.display = "none";
document.getElementById('table'+id).style.display = "";
}

$(function(){
	$(document).on('click', '.edittemplate', function() {
		var filepath=$(this).prev().find('input').val();
		if (filepath.length>0)
		{
			if (filepath.indexOf('.')<0)
			{
				filepath=filepath+'.php';
			}
			window.open ('?do=sadmin_fileedit&dir=<?php echo(SystemDir.TemplateDir);?>/&file='+filepath);
		}else{
			alert("请先填写模板文件路径");
		}
	});
	$(document).on('click', '.chosetemplate', function() {
		document.nowinputclickdom=$(this);
		window.open ('?do=sadmin_file&chosetemplate=1&dir=<?php echo(SystemDir.TemplateDir);?>');
	});
	$('.addotherpage').click(function(){
		$('#otherpage').append($('#newotherpage').html());
	});

	$(document).on('click', '.delthispage', function() {
		$(this).parent().remove();
	});
	$('.disable_tips1').change(function(){
		if($(this).prop('checked')){
			alert('禁用该栏目后,导航栏中不会显示该栏目,栏目页面与其他页面将无法访问');
		}
	});
	$('.disable_tips2').change(function(){
		if($(this).prop('checked')){
			alert('禁用该栏目后,导航栏中不会显示该栏目,栏目页面与其他页面将无法访问');
		}
	});
	$('.inputshowtips').focus(function(){
		$(this).next().show();
	});
	$('.inputshowtips').blur(function(){
		$(this).next().hide();
	});

	
});
</script>

<div id="newotherpage" style="display:none">
<div>
<label>页面地址: <input class="inputtext" type="text" size="35" name="otherpageurl[]" value=""></label>
&nbsp;&nbsp;&nbsp;&nbsp;<label>页面缓存时间: <input class="inputtext" type="text" size="5" name="otherpagecache[]" value="0"> <i>秒</i></label>
<label>&nbsp;&nbsp;&nbsp;模板文件: <input class="inputtext" type="text" size="30" name="otherpagetemplate[]" value=""></label>
<a href="javascript:;"  class="edittemplate" target="_blank">编辑</a>
<a href="javascript:;"  class="chosetemplate">选择</a>
<a href="javascript:;"  class="delthispage" target="_blank">删除</a><br><br>
</div>
</div>