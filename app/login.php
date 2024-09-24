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


ob_start();
define('loginpage',1);
require('../config/database.php');
require('chk.php');
ob_clean();
if(isset($_GET['do'])=='out') {
	checktoken();
	setadminname('');
	setadminpsd('');
	setadmintoken('');
	echo("<meta http-equiv=refresh content='0; url=login.php'>");
	die();
}
$login_cachekey='login_'.ip();
$try_time=20;//15分钟内允许尝试的次数
$login_error_time=cacheget($login_cachekey,900,'ucmslogin');
if($login_error_time==false) {$login_error_time=0;}
if(isset($_GET['code']) && !empty($_GET['code']) && AdminOpenid) {
	if($login_error_time<=$try_time) {
		$code=dbstr($_GET['code']);
		$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('admin')." where ucmsid='$code' and ucmsid<>'' limit 1;");
		$link = $GLOBALS['db'] -> fetchone($query);
		if($link) {
			$power=json_decode($link['power'],1);
			if(!power('b',1,$power)) {
					$errormsg='该账户已禁用';
			}else {
				setadminname($link['username']);
				setadminpsd($link['psd']);
				cachedel($login_cachekey,'ucmslogin');
				echo("<meta http-equiv=refresh content='0; url=index.php'>");
				exit();
			}
		}else {
			$errormsg='尚未绑定该账号,请使用账号密码登录';
			cacheset($login_cachekey,$login_error_time+1,900,'ucmslogin');
		}
	}else {
		$errormsg='登录过于频繁,请稍后再试';
		cacheset($login_cachekey,$login_error_time+1,900,'ucmslogin');
	}
}
if(isset($_POST['uuu_username'])) {
	if($login_error_time<=$try_time) {
		$username=trim(dbstr($_POST['uuu_username']));
		$password=password_md5(trim($_POST['uuu_password']));
		$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('admin')." where username='$username' and psd='$password'");
		$link = $GLOBALS['db'] -> fetchone($query);
		if($link && $password==$link['psd']) {
			$power=json_decode($link['power'],1);
			if(!power('b',1,$power)) {
					$errormsg='该账户已禁用';
			}else {
				setadminname($link['username']);
				setadminpsd($link['psd']);
				cachedel($login_cachekey,'ucmslogin');
				echo("<meta http-equiv=refresh content='0; url=index.php'>");
				exit();
			}
		}else {
			$errormsg='您填写的账户信息有误';
			cacheset($login_cachekey,$login_error_time+1,900,'ucmslogin');
		}
	}else {
		$errormsg='登录过于频繁,请稍后再试';
		cacheset($login_cachekey,$login_error_time+1,900,'ucmslogin');
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>后台管理登录</title>
<meta name="robots" content="noindex,nofollow,nosnippet,noarchive">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
<link rel="shortcut icon" href="img/ico.ico" >
<meta name="renderer" content="webkit">
<script type="text/javascript">cmsversion='<?php echo(version);?>';</script>
<style>
*{margin:0;padding:0;}
body{font:14px/1.5 '微软雅黑';background:#eee;font-family:Microsoft Yahei, \5FAE\8F6F\96C5\9ED1, \5B8B\4F53, Arial, Verdana, sans-serif;}
a{color:#00007F;text-decoration:none;}
a:hover{color:#bd0a01;text-decoration:underline;}
.admin_login_wrap{margin:140px auto 0;width:312px;}
.admin_login_wrap h1{font-family:'微软雅黑';font-weight: normal;font-size:20px;margin-bottom:15px;}
.adming_login_border{box-shadow:1px 2px 3px #ccc;border:1px solid #eee;background:#fff;padding:0 5px 15px;overflow:hidden;}
.admin_input{margin:15px auto 0;width:260px;}
.admin_input tr{height:50px;}
.admin_input label{display:inline;margin-bottom:5px;}
.admin_input_style{border:1px solid #e6e6e6;background:#fff;padding:3px;height:30px;line-height:30px;font-family:Arial;color:#666;border-radius:5px;transition-duration:0.3s;}
.admin_input_style:focus{border-color: rgba(82, 168, 236, 0.8);box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);background:#f8f8f8;}
.submitbtn{width:100%; display:inline-block; padding:8px 12px; margin-bottom:0; font-size:14px;line-height:20px;text-align:center;vertical-align:middle; cursor:pointer;background-color:#0080DD; border:1px solid #0065B0; border-color:#e6e6e6 #e6e6e6 #bfbfbf; border-bottom-color:#a2a2a2; border-radius:4px; color:#ffffff; }
.admin_copyright{color:#585858;margin-top:10px;font-family:Arial;text-align:center;}
.admin_copyright a:link,.admin_copyright a:visited{color:#0993d3;}
.admin_copyright a:hover{color:#0993d3;}
#uuu_username{width:180px;}
#uuu_password{width:180px;}
.qqlogin{float:left;margin-top:3px;margin-right:5px;display:inline-block;cursor:pointer;background:url(img/bgico.png) no-repeat;background-position:-24px -32px;width:63px;height:24px;}
</style>
<script language="javascript" type="text/javascript"> 
function checkuser(){
	if (document.getElementById("uuu_username").value==''){alert('请填写您的用户名');document.getElementById("uuu_username").focus();return false;}
	if (document.getElementById("uuu_password").value=='') { alert('请填写密码'); document.getElementById("uuu_password").focus(); return false; } 
	return true;
}
</script>
<script src="img/jquery.min.js"></script>
<?php
if(isset($errormsg)) {
	echo("<script type=\"text/javascript\">alert('".$errormsg."')</script>");
}
?>
</head>
<body>
<div class="admin_login_wrap">
	<div class="adming_login_border">
		<div class="admin_input">
			<form name="form1" method="post" action="" onSubmit="return checkuser();">
			<table>
			<tr>
				<td align="center">用户名：</td>
				<td><input type="text" tabindex="1" name="uuu_username" value="" id="uuu_username"  class="admin_input_style" autocomplete="off"/></td>
			</tr>
			<tr>
				<td align="center">密&nbsp;&nbsp;&nbsp;&nbsp;码：</td>
				<td><input type="password" tabindex="2" name="uuu_password" value="" id="uuu_password" class="admin_input_style" /></td>
			</tr>
			<tr>
				<?php
				if(AdminOpenid) {
				?>
				<td>
				<div id="uuulogin">
				<p class="ucms3login qqlogin" rel="qq"></p>
				</div>
				</td>
				<?php
					echo('<td colspan=1>');
				}else {
					echo('<td colspan=2>');
				}
				?>
				<input type="submit" tabindex="4" value="登录" class="submitbtn" />
				</td>
			</tr>
			
			</table>
			</form>
		</div>
	</div>
	<p class="admin_copyright"><a tabindex="5" href="<?php echo(gethomeurl());?>" >返回首页</a> 
	&copy; <?php echo(date('Y'));?> Powered by <a href="http://uuu.la/" target="_blank">UCMS</a></p>
<?php
if(AdminOpenid) {
?>
	<script>
	loaded=0;
	uuu_token='';
	</script>
	<script src="//uuu.la/loginapi/"></script>
	<script>
		if (loaded==0){document.write("<script src='//login.uuu.la/loginapi/'><\/script>");}
	</script>
<?php
}
?>
</div>
</body>
</html>