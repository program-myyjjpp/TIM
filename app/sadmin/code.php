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
$id=intval($_GET['id']);
if($_GET['kind']==1) {
	$kind=1;
	$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('moudle')." where id='$id'");
	$link = $GLOBALS['db'] -> fetchone($query);
	$cid=$link['cid'];
	$codekind=$link['mkind'];
	$codename=replacetempcode($link['mname']);
	$strarray=explode('|',$link['strarray']);
	if(count($strarray)<2) {
		
	}
}else {
	$kind=0;
	$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('str')." where id='$id'");
	$link = $GLOBALS['db'] -> fetchone($query);
	$cid=$link['strcid'];
	$codename=replacetempcode($link['strname']);
	$codekind=$link['inputkind'];
	$strarray=explode('|',$link['strarray']);
	
}

function replacetempcode($codename) {
	$codename=str_replace('(','\(',$codename);
	$codename=str_replace(')','\)',$codename);
	$codename=str_replace('\'','\\\'',$codename);
	$codename=str_replace('=','\=',$codename);
	$codename=str_replace(',','\,',$codename);
	$codename=str_replace('|','\|',$codename);
	Return $codename;
}
$br="\r\n";
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>调用代码</strong> </div>   
<div id="mainBox">
    <h3>
	<a style="margin-left:10px" href="javascript:history.go(-1);" class="actionBtn">返回</a>
	<a href="//uuu.la/temphelper/" target="_blank" class="actionBtn" style="margin-left:10px">模板制作助手</a>
	
	调用代码
	</h3>
	<div>
<textarea id="codearea" name="" style="width:98%;height:200px;font-size:14px;font-family: Fixedsys,Arial, Helvetica, sans-serif;  border: 2px solid rgb(204, 204, 204);line-height: 16px;padding: 5px;letter-spacing: 1px;"><?php
		if($cid>0) {
			$functionname='s';
		}else {
			$functionname='z';
		}
		if($codekind==1 || $codekind==2 || $codekind==3 || $codekind==4 || $codekind==5 || $codekind==7 || $codekind==16 || $codekind==30) {
			if($kind) {
				echo(TemplateStart.'$article[\''.$codename.'\']'.TemplateEnd);
			}else {
				echo(TemplateStart.''.$functionname.'('.$codename.')'.TemplateEnd);
			}
		}
		if($codekind==6) {
			if($kind) {
				echo(TemplateStart.'$pics=$article[\''.$codename.'\']|json_decode(1)'.TemplateEnd.$br);
			}else {
				echo(TemplateStart.'$pics='.$functionname.'('.$codename.')|json_decode(1)'.TemplateEnd.$br);
			}
			echo(TemplateStart.'if count($pics)>0'.TemplateEnd.$br);
			echo('    '.TemplateStart.'loop $pics as $pic'.TemplateEnd.$br);
			echo('        <img src="'.TemplateStart.'$pic'.TemplateEnd.'">'.$br);
			echo('    '.TemplateStart.'/loop'.TemplateEnd.$br);
			echo(TemplateStart.'/if'.TemplateEnd.$br);
		}
		if($codekind==9) {
			if($kind) {
				echo(TemplateStart.'$article[\''.$codename.'\']|date(\'Y-m-d H:i:s\',this)'.TemplateEnd);
			}else {
				echo(TemplateStart.''.$functionname.'('.$codename.')|date(\'Y-m-d H:i:s\',this)'.TemplateEnd);
			}
		}
		if($codekind==23) {
			if($kind) {
				echo(TemplateStart.'$map=$article[\''.$codename.'\']|explode(\'\\,\',this)'.TemplateEnd.$br);
			}else {
				echo(TemplateStart.'$map='.$functionname.'('.$codename.')|explode(\'\\,\',this)'.TemplateEnd.$br);
			}
			echo('经度:'.TemplateStart.'$map[0]'.TemplateEnd.',纬度'.TemplateStart.'$map[1]'.TemplateEnd.',缩放:'.TemplateStart.'$map[2]'.TemplateEnd.$br);
			echo('具体请参考百度地图API http://lbsyun.baidu.com/index.php?title=jspopular,或查看后台地图网页源代码');
		}
		if($codekind==24) {
			if($kind) {
				echo(TemplateStart.'class markdown'.TemplateEnd.$br);
				echo(TemplateStart.'$article[\''.$codename.'\']|markdown()'.TemplateEnd.$br);
			}else {
				echo(TemplateStart.'class markdown'.TemplateEnd.$br);
				echo(TemplateStart.''.$functionname.'('.$codename.')|markdown()'.TemplateEnd.$br);
			}
			echo(TemplateStart.'//详细帮助,请访问http://uuu.la/help/markdown.html'.TemplateEnd);
		}
		if($codekind==26) {
			if($kind) {
				echo(TemplateStart.'if $article[\''.$codename.'\']==1'.TemplateEnd.$br);
			}else {
				echo(TemplateStart.'$a='.$functionname.'('.$codename.')'.TemplateEnd.$br);
				echo(TemplateStart.'if $a==1'.TemplateEnd.$br);
			}
			echo('    勾选了'.$br);
			echo(TemplateStart.'else'.TemplateEnd.$br);
			echo('    没勾选'.$br);
			echo(TemplateStart.'/if'.TemplateEnd.$br);
		}
		if($codekind==18 || $codekind==19) {
			if($kind) {
				echo(TemplateStart.'$strs=$article[\''.$codename.'\']|json_decode(1)'.TemplateEnd.$br);
			}else {
				echo(TemplateStart.'$strs='.$functionname.'('.$codename.')|json_decode(1)'.TemplateEnd.$br);
			}
			echo(TemplateStart.'if count($strs)>0'.TemplateEnd.$br);
			echo('    '.TemplateStart.'loop $strs as $str'.TemplateEnd.$br);
			echo('        '.TemplateStart.'$str'.TemplateEnd.$br);
			echo('    '.TemplateStart.'/loop'.TemplateEnd.$br);
			echo(TemplateStart.'/if'.TemplateEnd.$br);
		}
		if($codekind==12 || $codekind==11 || $codekind==8 || $codekind==14 || $codekind==17 || $codekind==21) {
			if(count($strarray)<2) {
				echo('请先设置字段数据来源');
			}else {
				echo(TemplateStart.'$set=array()'.TemplateEnd.$br);
				echo(TemplateStart.'$set[\'cid\']=\''.$strarray[0].'\''.TemplateEnd.TemplateStart.'//变量来源栏目'.TemplateEnd.$br);
				if($kind) {
					echo(TemplateStart.'$set[\'where\'][\'id\']=$article[\''.$codename.'\']'.TemplateEnd.$br);
				}else {
					echo(TemplateStart.'$set[\'where\'][\'id\']='.$functionname.'('.$codename.')'.TemplateEnd.$br);
				}
				echo(TemplateStart.'$set[\'all\']=0'.TemplateEnd.$br);
				echo(TemplateStart.'$fromarticle=a($set)'.TemplateEnd.$br);
				echo(TemplateStart.'if $fromarticle'.TemplateEnd.$br);
				echo('    您选择了:'.TemplateStart.'$fromarticle[\''.$strarray[1].'\']'.TemplateEnd.$br);
				echo(TemplateStart.'else'.TemplateEnd.$br);
				echo('    文章不存在了'.$br);
				echo(TemplateStart.'/if'.TemplateEnd.$br);
			}
		}
		if($codekind==10 || $codekind==15 || $codekind==22 ) {
			if(count($strarray)<2) {
				echo('请先设置字段数据来源');
			}else {
				if($kind) {
					echo(TemplateStart.'$ids=$article[\''.$codename.'\']|json_decode(1)'.TemplateEnd.$br);
				}else {
					echo(TemplateStart.'$ids='.$functionname.'('.$codename.')|json_decode(1)'.TemplateEnd.$br);
				}
				echo(TemplateStart.'if count($ids)>0'.TemplateEnd.$br);
				echo('    '.TemplateStart.'loop $ids as $id'.TemplateEnd.$br);
				echo('        '.TemplateStart.'$set=array()'.TemplateEnd.$br);
				echo('        '.TemplateStart.'$set[\'cid\']=\''.$strarray[0].'\''.TemplateEnd.TemplateStart.'//变量来源栏目'.TemplateEnd.$br);
				echo('        '.TemplateStart.'$set[\'where\'][\'id\']=$id'.TemplateEnd.$br);
				echo('        '.TemplateStart.'$set[\'all\']=0'.TemplateEnd.$br);
				echo('        '.TemplateStart.'$fromarticle=a($set)'.TemplateEnd.$br);
				echo('        '.TemplateStart.'if $fromarticle'.TemplateEnd.$br);
				echo('        '.'    '.TemplateStart.'$fromarticle[\''.$strarray[1].'\']'.TemplateEnd.'<br>'.$br);
				echo('        '.TemplateStart.'else'.TemplateEnd.$br);
				echo('        '.'    文章不存在了<br>'.$br);
				echo('        '.TemplateStart.'/if'.TemplateEnd.$br);
				echo('        '.TemplateStart.'/loop'.TemplateEnd.$br);
				echo(TemplateStart.'/if'.TemplateEnd.$br);
			}
		}
		if($codekind==27 ) {
			if($kind) {
				echo(TemplateStart.'$ids=$article[\''.$codename.'\']|json_decode(1)'.TemplateEnd.$br);
			}else {
				echo(TemplateStart.'$ids='.$functionname.'('.$codename.')|json_decode(1)'.TemplateEnd.$br);
			}
			echo(TemplateStart.'if count($ids)>0'.TemplateEnd.$br);
			echo('    '.TemplateStart.'loop $ids as $id'.TemplateEnd.$br);
			echo('        '.TemplateStart.'$set=array()'.TemplateEnd.$br);
			echo('        '.TemplateStart.'$set[\'cid\']=$id[0]'.TemplateEnd.$br);
			echo('        '.TemplateStart.'$set[\'where\'][\'id\']=$id[1]'.TemplateEnd.$br);
			echo('        '.TemplateStart.'$set[\'all\']=0'.TemplateEnd.$br);
			echo('        '.TemplateStart.'$fromarticle=a($set)'.TemplateEnd.$br);
			echo('        '.TemplateStart.'if $fromarticle'.TemplateEnd.$br);
			echo('        '.'    <a href="'.TemplateStart.'$fromarticle[\'link\']'.TemplateEnd.'">'.TemplateStart.'$fromarticle[\'title\']'.TemplateEnd.'</a><br>'.$br);
			echo('        '.TemplateStart.'else'.TemplateEnd.$br);
			echo('        '.'    文章不存在了<br>'.$br);
			echo('        '.TemplateStart.'/if'.TemplateEnd.$br);
			echo('        '.TemplateStart.'/loop'.TemplateEnd.$br);
			echo(TemplateStart.'/if'.TemplateEnd.$br);
		}
		if($codekind==28) {
			if($kind) {
				echo('您选择的栏目的cid是:'.TemplateStart.'$article[\''.$codename.'\']'.TemplateEnd.$br);
				echo(TemplateStart.'$cid=$article[\''.$codename.'\']'.TemplateEnd.$br);
			}else {
				echo('您选择的栏目的cid是:'.TemplateStart.''.$functionname.'('.$codename.')'.TemplateEnd.$br);
				echo(TemplateStart.'$cid='.$functionname.'('.$codename.')'.TemplateEnd.$br);
			}
			echo(TemplateStart.'$channel_info=getchannelcache($cid)'.TemplateEnd.$br);
			echo(TemplateStart.'if $channel_info'.TemplateEnd.$br);
			echo('    栏目名:'.TemplateStart.'$channel_info[\'cname\']'.TemplateEnd.$br);
			echo('    栏目标题:'.TemplateStart.'s(栏目标题,$cid)'.TemplateEnd.$br);
			echo('    栏目内容:'.TemplateStart.'s(栏目内容,$cid)'.TemplateEnd.$br);
			echo('    也可根据$cid来获取该栏目下的文章'.$br);
			echo(TemplateStart.'/if'.TemplateEnd.$br);
		}
		if($codekind==29) {
			if($kind) {
				echo(TemplateStart.'$cids=$article[\''.$codename.'\']|json_decode(1)'.TemplateEnd.$br);
			}else {
				echo(TemplateStart.'$cids='.$functionname.'('.$codename.')|json_decode(1)'.TemplateEnd.$br);
			}
			echo(TemplateStart.'if count($cids)>0'.TemplateEnd.$br);
			echo('    '.TemplateStart.'loop $cids as $cid'.TemplateEnd.$br);
				echo('        '.TemplateStart.'$channel_info=getchannelcache($cid)'.TemplateEnd.$br);
				echo('        '.TemplateStart.'if $channel_info'.TemplateEnd.$br);
				echo('        栏目名:'.TemplateStart.'$channel_info[\'cname\']'.TemplateEnd.$br);
				echo('        栏目标题:'.TemplateStart.'s(栏目标题,$cid)'.TemplateEnd.$br);
				echo('        栏目内容:'.TemplateStart.'s(栏目内容,$cid)'.TemplateEnd.'<br>'.$br);
				echo('        '.TemplateStart.'/if'.TemplateEnd.$br);
			echo('    '.TemplateStart.'/loop'.TemplateEnd.$br);
			echo(TemplateStart.'/if'.TemplateEnd.$br);
		}
?></textarea>
		<div style="margin-top:20px;font-size:14px;color:#FF6600">
		<?php
		if($cid>0 && $kind) {
			echo('以上代码只在内容页使用,如需在文章列表循环中调用,请注意变量名是否正确.<br>');
			echo(TemplateStart.'$set=array()'.TemplateEnd.'<br>'.$br);
			echo(TemplateStart.'$test=alist($set)'.TemplateEnd.'<br>'.$br);
			echo(TemplateStart.'loop $test[\'list\'] as $a'.TemplateEnd.'<br>'.$br);
			echo('&nbsp;&nbsp;&nbsp;&nbsp;如需在此循环中调用此字段,则需将调用代码中的$article[\''.$codename.'\']替换为 $a[\''.$codename.'\']'.'<br>'.$br);
			echo(TemplateStart.'/loop'.TemplateEnd.'<br>'.$br);
		}
		if($cid>0 && !$kind) {
			$channelinfo =adminchannel($cid);
			echo($br.$br.$br.'如需在首页或其他栏目调用本变量,请将 s('.$codename.') 替换为 ');
			if(isset($channelinfo['cname']) && !empty($channelinfo['cname'])) {
				echo('s('.$codename.','.$channelinfo['cname'].') 或 ');
			}
			echo('s('.$codename.','.$cid.') &nbsp;&nbsp;&nbsp;&nbsp;'.$cid.' 代表栏目的cid ');
		}
		?>
		</div>
	</div>

	</div>
</div>
<script>
$(function(){
	$("#codearea").focus();
});
</script>