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
if(isset($_POST['cid'])) {
	$cid=intval($_POST['cid']);
	checktoken();
	if(isset($_POST['key']) && strlen($_POST['key'])>5) {
		echo('<script type="text/javascript">window.location.href = "?do=sadmin_cinedit&cid='.$cid.'&key='.htmlspecialchars($_POST['key']).'";</script>');
		die();
	}
	if(empty($_FILES['txt']['error']))
	{
		$str=file_get_contents($_FILES['txt']['tmp_name']);
		if($str) {
			$keyname='my_channel_in'.time().rand(100,999);
			$savestr=cacheset($keyname,$str,3600*12,'channel_in');
			if($savestr) {
				if(isset($_GET['cinkind'])) {
					$cinkind=intval($_GET['cinkind']);
				}else {
					$cinkind=0;
				}
				echo('<script type="text/javascript">window.location.href = "?do=sadmin_cinedit&cid='.$cid.'&key='.$keyname.'&cinkind='.$cinkind.'";</script>');
				exit();
			}else {
				$msg.=' 您关闭了缓存,不能导入栏目配置';
			}
		}else {
			$msg.=' 读取栏目配置文件失败';
		}

	}
}
if(isset($_GET['cid']) && $_GET['cid']>0) {
	$cid=intval($_GET['cid']);
	$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('channel')." where cid='$cid'");
	$link = $GLOBALS['db'] -> fetchone($query);
	if(!$link) {
		die('no channel');
	}
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
<a href="?do=sadmin" class="actionBtn" style="margin-left:10px"><em>返回</em></a>导入向导
 </h3>
	<form id="form1" method="post" action="" enctype="multipart/form-data">
	<input type="hidden" name="key" value="" id="key">
	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="">
<?php newtoken();?>
		<input type="hidden" name="cid" value="<?php echo($cid);?>">
			<tr><td width="100" align="right">栏目名</td>
				<td align="left">
				<?php echo($cname);?>
				</td></tr>
				<tr><td width="100" align="right">栏目配置文件</td><td align="left">
			<input type="file" name="txt">
				</td></tr>
				
      <tr>
       <td width="100"></td>
       <td>
        <input class="btn" type="submit" value="下一步" />
       </td>
      </tr>
     </table>
    </form>
       </div>
 </div>
