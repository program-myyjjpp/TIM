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
$settingfile=0;
if(isset($_GET['cid'])) {
	$cid=intval($_GET['cid']);
	$fidchannel=getchannelcache($cid);
	if($fidchannel['ckind']==5) {
		$settingfile=1;
	}elseif($fidchannel['ckind']==1) {
		$settingfile=3;
	}elseif($fidchannel['ckind']==2) {
		$settingfile=3;
	}else {
		$settingfile=1;
	}
}else {
	$cid=0;
	$settingfile=1;
}

?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>栏目配置</strong> </div>   <div id="mainBox">
     <h3>
<a href="?do=sadmin" class="actionBtn" style="margin-left:10px"><em>返回</em></a>增加栏目
 </h3>
	<form id="form1" method="post" action="?do=sadmin_caddpost"  enctype="multipart/form-data">
	<input type="hidden" name="key" value="" id="key">
	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="">
<?php newtoken();?>
		<tr><td width="100" align="right">上级栏目</td>
				<td align="left">
<select name="fid">
<?php
channel_select($cid);
?>
</select>
				</td></tr>
			<tr><td width="100" align="right">栏目名</td>
				<td align="left">
				<input type="text" name="cname" id="cname" value="" class="inputtext">
				</td></tr>
			<tr><td width="100" align="right">栏目类型</td><td align="left">
			<label><input type="radio"  name="ckind"  value="1">单页栏目 </label>
			<label><input type="radio"  name="ckind"  value="2" checked>文章栏目</label>
			<label><input type="radio"  name="ckind"  value="5" class="settingfile0">过渡栏目</label>
			<label><input type="radio"  name="ckind"  value="3" class="settingfile0">前台链接</label>
			<label><input type="radio"  name="ckind"  value="4" class="settingfile0">后台链接</label>
				</td></tr>
		<tr><td width="100" align="right">栏目配置</td>
		<td align="left">
			<table border="0" cellpadding="8" cellspacing="0" class="noborder">
				<tr>
					<td><label><input type="radio" class="settingfile" id="settingfile0" name="settingfile" value='0'<?php if($settingfile==0) {echo(' checked');}?>>不导入</label></td>
					<td></td>
				</tr>
				<tr>
					<td><label><input type="radio" class="settingfile" name="settingfile" value='1'<?php if($settingfile==1) {echo(' checked');}?>>默认配置</label></td>
					<td></td>
				</tr>
				<tr>
					<td><label><input type="radio" class="settingfile" name="settingfile" id="settingfile3" value='3'<?php if($settingfile==3) {echo(' checked');}?>>复制其他栏目配置</label></td>
					<td>
						<select name="settingfile_copy" id="settingfile_copy">
						<?php
						channel_select($cid,0,0,1,'上级栏目');
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td><label><input type="radio" class="settingfile" name="settingfile" id="settingfile2" value='2'<?php if($settingfile==2) {echo(' checked');}?>>导入配置文件</label></td>
					<td><div id="file">
					<input type="file" name="txt" id="chosefile">
					</div></td>
				</tr>
			</table>
			</td>
		</tr>
      <tr>
       <td width="100"></td>
       <td>
        <input class="btn btn140" type="submit" value="提交" />
       </td>
      </tr>
     </table>
    </form>
       </div>
 </div>

<script>
	$(function(){
		$('#settingfile_copy').click(function(){
			$('#settingfile3').prop('checked',true);
		});
		$('#chosefile').click(function(){
			$('#settingfile2').prop('checked',true);
		});
		
	});
</script>