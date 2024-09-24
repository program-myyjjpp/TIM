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


adminchannelscache();
?>
<div id="UWrap">
 <div id="UHead">
 <div id="head">
  <div class="logo"><a href="index.php"></a></div>
  <div class="nav">
   <ul class="navRight">
	<li class="onRight"><a href="<?php echo(gethomeurl());?>" target="_blank">首页</a></li>
	<?php
	if(power('b',2)) {
		echo('<li class="onRight"><a href="?do=user_my">个人中心</a></li>');
	}
	?>
	<?php
	if(power('alevel')>1) {
		echo('<li class="onRight"><a href="?do=user">帐户管理</a></li>');
	}
	if(power('alevel')==3) {
		echo('<li class="onRight"><a href="?do=sadmin">站点管理</a></li>');
		if(AdminFileedit) {
			echo('<li class="onRight"><a href="?do=sadmin_file">文件管理</a></li>');
		}
		echo('<li class="onRight"><a href="?do=str_cache&'.newtoken(3).'">清空缓存</a></li>');
	}
	?>
    <li class="onRight"><a href="login.php?do=out&<?php echo(newtoken(2));?>">退出</a></li>
   </ul>
  </div>
 </div>
</div>
<div id="ULeft">
<div id="menu">
<?php if(power('s',0)) {?>
<ul>
<li<?php if((!isset($_GET['cid']) || $_GET['cid']==0) && isset($thisdo[0]) && $thisdo[0]=='str') {echo(' class="on"');}?>><a href="?do=str">站点设置</a></li>
</ul>
<?php }?>
<?php
if(isset($_GET['cid'])) {
	$cid=intval($_GET['cid']);
}else {
	$cid=0;
}
function getleftlist($cdaddy=0,$times=0){
	Global $channels;
	Global $power,$cid;
	$times++;
	$mynav=array();
	foreach($channels as $value){
		if ($value['fid']==$cdaddy && $times<5){
			if($value['ifshowleft']==1 && $value['ifshowadmin']==1 && power('s',$value['cid'],$power)) {
				if($cid==$value['cid']) {$thisstr=' class="on"';}else {$thisstr='';}
				if($value['ckind']==1) {
					$mynav[]=array('url'=>'?do=str&cid='.$value['cid'],'title'=>$value['cname'],'cid'=>$value['cid'],'fid'=>$value['fid'],'blank'=>'');
				}elseif($value['ckind']==2) {
					$mynav[]=array('url'=>'?do=list&cid='.$value['cid'],'title'=>$value['cname'],'cid'=>$value['cid'],'fid'=>$value['fid'],'blank'=>'');
				}elseif($value['ckind']==3) {
					$mynav[]=array('url'=>'?do=str&cid='.$value['cid'],'title'=>$value['cname'],'cid'=>$value['cid'],'fid'=>$value['fid'],'blank'=>'');
				}elseif($value['ckind']==4) {
					if($value['newwindow']==1) {
						$mynav[]=array('url'=>$value['cvalue'],'title'=>$value['cname'],'cid'=>$value['cid'],'fid'=>$value['fid'],'blank'=>'target="_blank"');
					}else {
						$mynav[]=array('url'=>$value['cvalue'],'title'=>$value['cname'],'cid'=>$value['cid'],'fid'=>$value['fid'],'blank'=>'');
					}
				}elseif($value['ckind']==5) {
					$mynav[]=array('url'=>get_transit_channel($value['cid'],2),'title'=>$value['cname'],'cid'=>$value['cid'],'fid'=>$value['fid'],'blank'=>'');
				}
			}
		}
	}
	if(count($mynav)>0) {
		foreach($mynav as $thisnav) {
			if($thisnav['fid']==0) {
				echo('<ul rel="'.$thisnav['cid'].'">');
			}
			$style='';
			if($times>2) {
				$style.='text-indent:'.(($times-1)*10).'px;';
			}
			if($cid==$thisnav['cid']) {
				$ifon=1;
				echo('<li class="on" rel="'.$thisnav['cid'].'" style="'.$style.'"><a href="'.$thisnav['url'].'"'.$thisnav['blank'].'>'.$thisnav['title'].'</a>');
				run_admin_hook($thisnav['cid'],'leftnav');
				echo('</li>'."\r\n");
			}
			else {
				echo('<li rel="'.$thisnav['cid'].'" style="'.$style.'"><a href="'.$thisnav['url'].'"'.$thisnav['blank'].'>'.$thisnav['title'].'</a>');
				run_admin_hook($thisnav['cid'],'leftnav');
				echo('</li>'."\r\n");
			}
			getleftlist($thisnav['cid'],$times);
			if($thisnav['fid']==0) {
				echo('</ul>');
			}
		}
	}
	Return count($mynav);
}
getleftlist();
?>

</div></div>
<script type="text/javascript">
$(document).keydown(function(event){
	var ctrlc = event.which;
	if(ctrlc == 13 && event.ctrlKey){
		$('#form1').submit();
	}
	if(event.altKey){
		<?php
		if (isset($_GET['cid']) && $_GET['cid']>0)
		{
			if (power('s',intval($_GET['cid']),$power,1))
			{
				echo('if(ctrlc == 65){window.location.href = "?do=list_add&cid='.intval($_GET['cid']).'";}');
			}
			if (power('s',intval($_GET['cid']),$power,4))
			{
				echo('if(ctrlc == 83){window.location.href = "?do=str&cid='.intval($_GET['cid']).'";}');
			}
			if (power('s',intval($_GET['cid'])))
			{
				echo('if(ctrlc == 86){window.location.href = "?do=list&cid='.intval($_GET['cid']).'";}');
			}
			if (power('alevel')==3)
			{
				echo('if(ctrlc == 90){window.location.href = "?do=sadmin_cedit&cid='.intval($_GET['cid']).'";}');
				echo('if(ctrlc == 88){window.location.href = "?do=sadmin_aindex&cid='.intval($_GET['cid']).'";}');
				echo('if(ctrlc == 67){window.location.href = "?do=sadmin_sbasic&cid='.intval($_GET['cid']).'";}');
			}
		}elseif(!isset($_GET['cid']) && power('alevel')==3){
				echo('if(ctrlc == 67){window.location.href = "?do=sadmin_sbasic";}');
				echo('if(ctrlc == 90){window.location.href = "?do=sadmin";}');
		}
		if (AdminFileedit && power('alevel')==3)
		{
			echo('if(ctrlc == 70){window.location.href = "?do=sadmin_file";}');
		}
		?>
		if(ctrlc == 72){
			window.open ('<?php echo(SystemDir);?>');
		}
	}
});
$(function(){
	$('#form1').find("table").eq(0).find("tr").eq(0).find('input[type!=hidden]').eq(0).focus();
	$('#form1').find("table").eq(0).find("tr").eq(0).find('textarea').eq(0).focus();
	$('#form1').find("table").eq(0).find("tr").eq(0).find('select').eq(0).focus();
});
</script>