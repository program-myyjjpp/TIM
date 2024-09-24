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
?>
<div id="UMain">
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>管理员列表</strong> </div>   <div id="mainBox">
<h3><a href="?do=user_add" class="actionBtn">添加管理员</a>后台帐户管理</h3>
<table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
<tr>
<th width="30" align="center">编号</th>
<th align="left">管理员名称</th>
<th align="left">管理员账号</th>
<th align="center">操作</th>
</tr>
<?php
$alluser = $GLOBALS['db'] -> all("SELECT * FROM ".tableex('admin')." where alevel<='$alevel'");
foreach($alluser as $link) {
	?>
<tr>
<td align="center"><?php echo($link['id']);?></td>
<td>
<?php echo(htmlspecialchars($link['nickname']));?>
</td>
<td align="left">
<?php echo($link['username']);?>
<?php
if($alevel==3) {
	if($link['alevel']==1) {
		echo(' (后台用户)');
	}elseif($link['alevel']==2) {
		echo(' (管理员)');
	}elseif($link['alevel']==3) {
		echo(' <font color="#FF0000">(超级管理员)</font>');
	}
}
?>
</td>
<td align="center">
<a href="?do=user_edit&id=<?php echo($link['id']);?>">修改</a> | 
<a href="?do=user_del&id=<?php echo($link['id']);?>&<?php echo(newtoken(2));?>"  onclick="javascript:if (confirm('确认删除？')){ return true}else{ return false}">删除</a></td>
</tr>
<?php
}	
?>

</table>
</div>
</div>

