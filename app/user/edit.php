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
$mylevel=power('alevel');
if($mylevel<2) {
	adminmsg('','无权限',3);
}else {
	if($mylevel==3) {
		$alevel=3;
	}elseif($mylevel==2) {
		$alevel=1;
	}else {
		$alevel=0;
	}
}
if(isset($_GET['id'])) {
	$id=intval($_GET['id']);
}else {
	die();
}
$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('admin')." where id='$id' and alevel<='$alevel' limit 1");
$user = $GLOBALS['db'] -> fetchone($query);
if(!$user) {
	adminmsg('','用户不存在',3);
}
$thiuserpower=json_decode($user['power'],1);
?>

<script language="JavaScript" type="text/javascript">
	function check(){
		if(document.form1.nickname.value==""){
			alert("[昵称]不能为空！");
			document.form1.nickname.focus();
			return false;
		}
		
		if(document.form1.psd.value!=document.form1.psd1.value){
			alert("两次输入密码不一至！");
			document.form1.psd.focus();
			return false;
		}
	return true
	}
</script>
<script type="text/javascript">
$(document).ready(function(){
	if ($('#alevel1').prop('checked'))
	{
		$("#quantr").show();
	}else{
		$("#quantr").hide();
	}
	$("#alevel3").click(function(){
		$("#quantr").hide();
	});
	$("#alevel2").click(function(){
		$("#quantr").hide();
	});
	$("#alevel1").click(function(){
		$("#quantr").show();
	});
});
</script>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>修改账户信息</strong> </div>   <div id="mainBox">
    <h3><a href="?do=user" class="actionBtn">返回</a>修改账户信息</h3>
<form id="form1" name="form1" method="post" action="?do=user_editpost" onsubmit="return check()">
<?php newtoken();?>
<input type="hidden" name="id" value="<?php echo($id);?>">
 <table width="100%" border="0" cellpadding="8" cellspacing="0">

		<tr>
		<td width="100" height="24" align="right">昵&nbsp;&nbsp;&nbsp;&nbsp;称：</td>
		<td height="24" align="left"><input name="nickname" type="text" id="nickname"  class="inputtext" value="<?php echo($user['nickname']);?>"/></td>
		</tr>
		<tr>
		<td height="24" align="right">用 户 名：</td>
		<td height="24" align="left"><input name="username" type="text" id="username"  class="inputtext" size="20" value="<?php echo($user['username']);?>" disabled/>  <i>用户名无法修改</i></td>
		</tr>
		<tr>
		<td height="25" align="right">密&nbsp;&nbsp;&nbsp;&nbsp;码：</td>
		<td height="25" align="left"><input name="psd" type="password" id="psd" size="40" class="inputtext" value="" onfocus="document.getElementById('psdshow').style.display = '';"/> 不修改则留空</td>
		</tr>
		<tr style="display:none" id="psdshow">
		<td height="25" align="right">确认密码：</td>
		<td height="25" align="left"><input name="psd1" type="password" class="inputtext" id="psd1" size="40" /></td>
		</tr>
		<?php
		if(AdminOpenid) {
		?>
		<tr>
			<td height="25" align="right">第三方登录：</td>
			<td height="25" align="left">
		<?php
			if($user['ucmsid']>0) {
				echo('已绑定&nbsp;&nbsp;<label><input type="checkbox" name="ucmsid">取消绑定</label>');
			}else {
				echo('未绑定');
			}
			?>
		</td>
		</tr>
		<?php 
		}
		?>
		<tr>
			<td width="100" height="25" align="right">用户设置：</td>
			<td height="25" align="left">
				<label><input type="checkbox" name="b[]" value="1" <?php if(power('b',1,$thiuserpower)) {echo(' checked');}?>>启用账户</label>
				<label><input type="checkbox" name="b[]" value="2" <?php if(power('b',2,$thiuserpower)) {echo(' checked');}?>>允许修改个人信息</label>
			</td>
		</tr>
		<?php
		if($alevel==3) {
		?>
		<tr>
			<td width="100" height="25" align="right">用户类型：</td>
			<td height="25" align="left">
				<label><input type="radio" name="alevel" id='alevel3' value="3"<?php if(power('alevel',0,$thiuserpower)==3) {echo(' checked');}?>>超级管理员</label>
				<label><input type="radio" name="alevel" id='alevel2' value="2"<?php if(power('alevel',0,$thiuserpower)==2) {echo(' checked');}?>>管理员</label>
				<label><input type="radio" name="alevel" id='alevel1' value="1"<?php if(power('alevel',0,$thiuserpower)==1) {echo(' checked');}?>>后台用户</label>
				<br><br>
				<i>超级管理员:可以配置栏目,文件管理,清空缓存,添加修改任意用户权限</i><br>
				<i>管理员:拥有所有栏目与编辑普通后台用户的权限</i>
			</td>
		</tr>
		<?php
		}else {
		?>
			<label style="display:none"><input type="radio" name="alevel" id='alevel1' value="1" checked>后台用户</label>
		<?php
		}
		?>
		<tr id="quantr">
			<td width="100" height="25" align="right">栏目权限</td>
			<td  align="left">
				<div id="quan" style="margin-top:20px">
					[<a href="javascript:;" class="checkall_quan">全选</a>]
					[<a href="javascript:;" class="checkall_quan_change">反选</a>]
					<br>
					<i>权限说明:栏目管理员可管理该栏目下其他用户的文章,并拥有管理员字段的权限</i><br><br>
					├──<label><input type="checkbox" name="s[]" id="s_0" value="0"<?php if(power('s',0,$thiuserpower)) {echo(' checked');}?>>站点设置</label><input type="checkbox" name="s_0[]" value="4" checked style="display:none">
					<?php
					$allc=channel_select(0,0,0,0);
					foreach($allc as $value) {
						if($value['ifshowadmin']==1) {
					?>
					<div class="user_quan_list">
					<?php echo($value['ext']);?><label><input class="channel_quan_one" type="checkbox" name="s[]" value="<?php echo($value['cid']);?>" id="s_<?php echo($value['cid']);?>"  <?php if(power('s',$value['cid'],$thiuserpower)) {echo(' checked');}?>>
					<input type="checkbox" name="s_<?php echo($value['cid']);?>[]" value="0" checked style="display:none">
					<?php echo($value['cname']);?>
					</label>
					<?php
					if($value['ckind']==2) {
					?>
						<label><input type="checkbox" class="channel_quan_son" name="s_<?php echo($value['cid']);?>[]" value="1" <?php if(power('s',$value['cid'],$thiuserpower,1)) {echo(' checked');}?>>增加</label>
						<label><input type="checkbox" class="channel_quan_son" name="s_<?php echo($value['cid']);?>[]" value="2" <?php if(power('s',$value['cid'],$thiuserpower,2)) {echo(' checked');}?>>编辑</label>
						<label><input type="checkbox" class="channel_quan_son" name="s_<?php echo($value['cid']);?>[]" value="3" <?php if(power('s',$value['cid'],$thiuserpower,3)) {echo(' checked');}?>>删除</label>
						<label><input type="checkbox" class="channel_quan_son" name="s_<?php echo($value['cid']);?>[]" value="4" <?php if(power('s',$value['cid'],$thiuserpower,4)) {echo(' checked');}?>>变量修改</label>
						<label><input type="checkbox" class="channel_quan_son" name="s_<?php echo($value['cid']);?>[]" value="5" <?php if(power('s',$value['cid'],$thiuserpower,5)) {echo(' checked');}?>>栏目管理员</label>
					<?php
					}elseif($value['ckind']==1 || $value['ckind']==3) {
					?>
						<label><input type="checkbox" name="s_<?php echo($value['cid']);?>[]" value="4" <?php if(power('s',$value['cid'],$thiuserpower,4)) {echo(' checked');}?>>变量修改</label>
					<?php
					}
					?>
					</div>
					<br>
						<?php
						}
					}
					?>
				</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input class="btn" type="submit" style="width:140px;" value="提交" />
			</td>
		</tr>
	</table>
	</form>
	</div>
</div>
<script type="text/javascript">
$(function(){
	$('.channel_quan_one').change(function(){
		if ($(this).prop('checked'))
		{
			$(this).parent().parent().find("input").prop('checked',true);
			if ($(this).parent().parent().find("input:last").prop('checked')==false)
			{
				$(this).parent().parent().find("input:last").prop('checked',false);
			}
		}else{
			$(this).parent().parent().find("input").prop('checked',false);
		}
	});
	$('.channel_quan_son').change(function(){
		if ($(this).prop('checked'))
		{
			$(this).parent().parent().find("input:first").prop('checked',true);
		}else{
			var onechecked=0;
			$(this).parent().parent().find("input").each(function(){
				if ($(this).prop('checked'))
				{
					onechecked=onechecked+1;
				}
			});
			if (onechecked==2)
			{
				//$(this).parent().parent().find("input:first").prop('checked',false);
			}
		}
	});
	$('.checkall_quan').click(function(){
		$('#quan input').prop('checked',true);
	});
	$('.checkall_quan_change').click(function(){
		$("#quan input").each(function(){
			if ($(this).prop('checked'))
			{
				$(this).prop('checked',false);
			}else{
				$(this).prop('checked',true);
			}
		});
	});
});
</script>