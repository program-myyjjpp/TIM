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
if(isset($_POST['saveurl'])) {
	checktoken();
	$newurl=array();
    if(!isset($_POST['diyurl'])) {
        $_POST['diyurl']=array();
    }
	foreach($_POST['diyurl'] as $key=>$val) {
		if(!empty($_POST['diyurl'][$key])) {
			$newurl[]=array('uri'=>postroutercheck($_POST['diyurl'][$key],1),'res'=>postroutercheck($_POST['diyurltemplate'][$key]),'cache'=>intval($_POST['diyurlcache'][$key]));
		}
	}
	$newurl=dbstr(json_encode($newurl));
	$allurl = $GLOBALS['db'] -> one("SELECT * FROM ".tableex('str')." where strname='diyurl' and inputkind=0 limit 1;");
	if(!$allurl) {
		$query = $GLOBALS['db'] -> query("INSERT INTO `".tableex('str')."` (`strname`,`strcid`,`strorder`,`inputkind`,`strvalue`,`ifadmin`) VALUES ('diyurl','0','0','0','$newurl','1');");
	}else {
		$query = $GLOBALS['db'] -> query("UPDATE ".tableex('str')." SET strvalue='$newurl' WHERE strname='diyurl' and inputkind=0;");
	}
	if($query) {
		channelrouter();
		adminmsg('?do=sadmin_url','保存成功',3);
	}else {
		adminmsg('?do=sadmin_url','保存失败',3);
	}
}
$allurl = $GLOBALS['db'] -> one("SELECT * FROM ".tableex('str')." where strname='diyurl' and inputkind=0 limit 1;");
if($allurl) {
	$allurl=json_decode($allurl['strvalue'],1);
}else {
	$allurl=array();
}
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>自定义页面</strong> </div>   <div id="mainBox">
    <h3>
	<a style="margin-left:10px" href="?do=sadmin" class="actionBtn">返回</a>
	自定义页面 
	</h3>

<form id="form1" method="post" action="?do=sadmin_url">
<?php newtoken();?><input type="hidden" name="saveurl">
		<table width="870px" border="0" cellpadding="8" cellspacing="0" class="tablerowtip" align=center>
		<?php
			foreach($allurl as $key=>$val) {
				?>
				<tr>
					<td>
					<label>页面地址: <input class="inputtext" type="text" size="35" name="diyurl[]" value="<?php echo($val['uri']);?>"></label>
				&nbsp;&nbsp;&nbsp;&nbsp;<label>页面缓存时间: <input class="inputtext" type="text" size="5" name="diyurlcache[]" value="<?php echo($val['cache']);?>"> <i>秒</i></label>
				<label>&nbsp;&nbsp;&nbsp;模板文件: <input class="inputtext" type="text" size="30" name="diyurltemplate[]" value="<?php echo($val['res']);?>"></label>
				<a href="javascript:;"  class="edittemplate" target="_blank">编辑</a>
				<a href="javascript:;"  class="chosetemplate">选择</a>
				<a href="javascript:;"  class="delthispage">删除</a>
					</td>
				</tr>
				<?php
			}
		?>


				<tr  class="addurltr">
					<td>
						<a href="javascript:;" class="add_urltr" style="color:#FF6600">[+]增加页面</a>
						<a style="margin-left:10px" href="//uuu.la/help/page.html" class="actionBtn" target="_blank">自定义页面帮助</a>
						

						<input type="submit" id="savebutton" value="保存"  class="btn"  style="float:right;margin-right:10px;">
					</td>
				</tr>

		</table>
		</form>
		
	</div>
</div>

<table id="newurlhtml" style="display:none">
<tr class="new_urltr">
	<td>
	<label>页面地址: <input class="inputtext" type="text" size="35" name="diyurl[]" value=""></label>
&nbsp;&nbsp;&nbsp;&nbsp;<label>页面缓存时间: <input class="inputtext" type="text" size="5" name="diyurlcache[]" value="0"> <i>秒</i></label>
<label>&nbsp;&nbsp;&nbsp;模板文件: <input class="inputtext" type="text" size="30" name="diyurltemplate[]" value=""></label>
<a href="javascript:;"  class="edittemplate" target="_blank">编辑</a>
<a href="javascript:;"  class="chosetemplate">选择</a>
<a href="javascript:;"  class="delthispage" target="_blank">删除</a>
	</td>
</tr>
</table>

<script type="text/javascript">
$(function(){
	$(function(){
		$('.add_urltr').click(quick_add_str);
		function quick_add_str(){
			$('.addurltr').before('<tr class="new_urltr">'+$('#newurlhtml tr').html()+'</tr>');
		}
	});
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


	
});
</script>