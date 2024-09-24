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


if (!function_exists('a')) {exit();}
if(!isset($GLOBALS['db'])) {$GLOBALS['db'] = new db();$GLOBALS['db'] -> connect($site_db);}
$admin_hooks=array();
include('admin_config.php');
if (!defined('loginpage')) {
	$ucms_admin=getadminname();
	$ucms_psw=$_COOKIE['psw_'.cookiehash];
	$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('admin')." where username='".$ucms_admin."' limit 1");
	$mjjinfo = $GLOBALS['db'] -> fetchone($query);
	if($ucms_psw!=md5($mjjinfo['psd'].SiteHash)) {
		admin_error();
	}
	$power=json_decode($mjjinfo['power'],1);
	$mynickname=$mjjinfo['nickname'];
	$myadminuid=$mjjinfo['id'];
	if(!power('b',1)) {
		admin_error('该账户已禁止登录');
	}
}
function newtoken($input=1) {
	if(isset($_COOKIE['token_'.cookiehash])) {
		$token=$_COOKIE['token_'.cookiehash];
	}else {
		$token=substr(md5(time().rand(1004,1989)),0,8);
		$_COOKIE['token_'.cookiehash]=$token;
		setadmintoken($token);
	}
	if($input==1) {
		echo('<input type="hidden" name="uuu_token" value="'.$token.'">');
	}elseif($input==2) {
		echo('uuu_token='.$token);
	}elseif($input==3)  {
		Return 'uuu_token='.$token;
	}elseif($input==10) {
		Return true;
	}else{
		Return $token;
	}
}
function checktoken() {
	if(isset($_POST['uuu_token'])) {
		$token=$_POST['uuu_token'];
	}elseif(isset($_GET['uuu_token'])) {
		$token=$_GET['uuu_token'];
	}else {
		adminmsg('','非法提交,请联系管理员',3);
	}
	if(isset($_COOKIE['token_'.cookiehash]) && $_COOKIE['token_'.cookiehash]==$token) {
		Return true;
	}else {
		if(defined('loginpage')) {die('no token');}
		adminmsg('','非法提交,请联系管理员',3);
	}
}
function getadminname() {
	if (isset($_COOKIE['admin_'.cookiehash]) && !empty($_COOKIE['admin_'.cookiehash])){
		$username=trim($_COOKIE['admin_'.cookiehash]);
		if(!preg_match("/^[a-zA-Z0-9_]+$/",$username)){
			admin_error();
		}
		Return trim($username);
	}else {
		admin_error();
	}
}
function setadminname($value) {
	setcookie('admin_'.cookiehash, $value, time()+604800,null,null,null,true);
}
function setadminpsd($value) {
	if(!empty($value)) {
		$value=md5($value.SiteHash);
	}
	setcookie('psw_'.cookiehash,$value,time()+604800,null,null,null,true);
}
function setadmintoken($value) {
	setcookie('token_'.cookiehash,$value, time()+604800);
}
function admin_error($info='登录信息有误,请重新登录') {
	echo('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">');
	echo("<meta http-equiv=refresh content='0; url=login.php'>");
	exit();
}
function power($kind,$id='',$powers=0,$action='') {
	if($powers==0) {
		global $power;
	}else {
		$power=$powers;
	}
	if($kind=='alevel') {
		if(isset($power['alevel'])) {Return $power['alevel'];}else {Return 0;}
	}
	if($kind=='b') {
		if(isset($power[$kind][$id]) && $power[$kind][$id]==1) {
			Return true;
		}else {
			Return false;
		}
	}
	if(isset($power['alevel']) && $power['alevel']>1) {
		Return true;
	}
	if(!isset($power[$kind])) {
		Return false;
	}elseif($kind=='s' && !isset($power[$kind][$id][0]) && !empty($action)){
		Return false;
	}else {
		if(isset($power[$kind][$id]) && $action=='') {
			Return true;
		}else {
			if(isset($power[$kind][$id][$action]) && $power[$kind][$id][$action]==1) {
				Return true;
			}else {
				Return false;
			}
		}
	}
	Return false;
}
$inputkindarray=array(
array('id'=>'1',	'name'=>'文本框',				'kind'=>'varchar',		'setting'=>0),
array('id'=>'2',	'name'=>'多行文本',				'kind'=>'text',			'setting'=>0),
array('id'=>'3',	'name'=>'编辑框(简单)',			'kind'=>'text',			'setting'=>0),
array('id'=>'4',	'name'=>'编辑框(全功能)',		'kind'=>'text',			'setting'=>0),
array('id'=>'24',	'name'=>'编辑框(MarkDown)',		'kind'=>'text',			'setting'=>0),
array('id'=>'5',	'name'=>'文件/图片上传',		'kind'=>'varchar',		'setting'=>0),
array('id'=>'6',	'name'=>'多图上传',				'kind'=>'text',			'setting'=>0),
array('id'=>'7',	'name'=>'数字/排序',			'kind'=>'int',			'setting'=>0),
array('id'=>'9',	'name'=>'时间',					'kind'=>'int',			'setting'=>0),
array('id'=>'26',	'name'=>'勾选框(是否)',			'kind'=>'int',			'setting'=>0),
array('id'=>'12',	'name'=>'单选框',				'kind'=>'int',			'setting'=>1,	'strfrom'=>1,	'tips'=>'字段数据来源'),
array('id'=>'10',	'name'=>'多选框',				'kind'=>'varchar',		'setting'=>1,	'strfrom'=>1,	'tips'=>'字段数据来源'),
array('id'=>'15',	'name'=>'多选框(搜索)',			'kind'=>'varchar',		'setting'=>1,	'strfrom'=>1,	'tips'=>'字段数据来源'),
array('id'=>'11',	'name'=>'列表框',				'kind'=>'int',			'setting'=>1,	'strfrom'=>1,	'tips'=>'字段数据来源'),
array('id'=>'8',	'name'=>'列表框(树形)',			'kind'=>'int',			'setting'=>1,	'strfrom'=>1,	'tips'=>'字段数据来源,来源栏目下必须有fid字段'),
array('id'=>'14',	'name'=>'列表框(搜索)',			'kind'=>'int',			'setting'=>1,	'strfrom'=>1,	'tips'=>'字段数据来源'),
array('id'=>'17',	'name'=>'列表框(联动)',			'kind'=>'int',			'setting'=>1,	'strfrom'=>1,	'tips'=>'字段数据来源,来源栏目下必须有fid字段'),
array('id'=>'21',	'name'=>'文章单选',				'kind'=>'int',			'setting'=>1,	'strfrom'=>1,	'tips'=>'字段数据来源'),
array('id'=>'22',	'name'=>'文章多选',				'kind'=>'varchar',		'setting'=>1,	'strfrom'=>1,	'tips'=>'字段数据来源'),
array('id'=>'27',	'name'=>'文章多选(全站)',		'kind'=>'varchar',		'setting'=>0),
array('id'=>'28',	'name'=>'栏目单选',				'kind'=>'int',			'setting'=>0),
array('id'=>'29',	'name'=>'栏目多选',				'kind'=>'varchar',		'setting'=>0),
array('id'=>'16',	'name'=>'颜色选择器',			'kind'=>'varchar',		'setting'=>0),
array('id'=>'18',	'name'=>'TAGS(竖)',				'kind'=>'text',			'setting'=>0),
array('id'=>'19',	'name'=>'TAGS(横)',				'kind'=>'text',			'setting'=>0),
array('id'=>'23',	'name'=>'地图坐标',				'kind'=>'varchar',		'setting'=>0),
array('id'=>'30',	'name'=>'自定义',				'kind'=>'varchar',		'setting'=>1,	'strfrom'=>2,	'tips'=>'自定义函数名 帮助:http://uuu.la/help/diyinput.html'),
);
$notallowfield=array('id','posttime','cid','adminuid','rowstyle','stepstyle','rowurl','link','refererurl','articletable','like','add','all','alter','as','and','asc'
,'before','between','bigint','binary','blob','both','by','call','cascade','case','change','char','check','column','create'
,'cross','cursor','databases','database','dec','delete','default','desc','div','double','drop','each','else','elseif','exists'
,'exit','explain','false','float','for','force','from','foreign','goto','group','if','in','index','inner','inout'
,'insert','int','integer','into','is','join','key','kill','keys','left','limit','lines','load','lock','loop','long','mod','not'
,'null','on','option','or','order','out','outer','outfile','primary','range','read','reads','real','set','show','sql'
,'ssl','starting','then','table','to','undo','true','union','unlock','update','using','values','varchar'
,'when','where','while','with','write');

function htmlinput($inputarray) {
	global $power;
	$kind=$inputarray['kind'];
	$inputname=$inputarray['inputname'];
	$inputvalue=$inputarray['inputvalue'];
	if(isset($inputarray['pictips'])) {$pictips=$inputarray['pictips'];}else {$pictips='';}
	if(isset($inputarray['strarray'])) {$strarray=$inputarray['strarray'];}
	if(isset($inputarray['style'])) {$style=$inputarray['style'];}else {$style='';}
	global $editorarray;
	if(!is_numeric($kind)) {Return false;}
	if(strlen($style)>5) {$style=' style="'.$style.'"';}
	require('input/'.$kind.'.php');
	Return true;
}
require('input/kses.php');
function filterhtml($html,$filterhtml) {
	if(power('alevel')==3 && ($filterhtml==1 || $filterhtml==2)) {
		$filterhtml=0;
	}
	if($filterhtml==0) {
		Return $html;
	}
	if($filterhtml==1) {
		Return kses($html);
	}
	if($filterhtml==2) {
		Return htmlspecialchars($html);
	}
	if($filterhtml==4) {
		Return intval($html);
	}
	Return $html;
}
function htmlinput_error($from,$id) {
	if(isset($_GET['cid'])) {$cid='&cid='.intval($_GET['cid']);}else {$cid='';}
	if(power('alevel')==3) {
		if($from=='list') {
			echo('字段数据来源配置有误 <a target="_blank" href="?do=sadmin_aedit'.$cid.'&id='.$id.'">请配置</a>');
		}elseif($from=='str') {
			echo('变量数据来源配置有误 <a target="_blank" href="?do=sadmin_sbasicedit'.$cid.'&id='.$id.'">请配置</a>');
		}
	}
	exit;
}
function inputvalue($moudle) {
	$kind=$moudle['mkind'];
	$inputname=$moudle['mname'];
	global $_POST;
	$othersetting=json_decode($moudle['msetting'],1);
	if(!isset($othersetting['filterhtml'])) {
		$filterhtml=1;//默认过滤危险html代码
	}else {
		$filterhtml=$othersetting['filterhtml'];
	}
	if(!is_numeric($kind)) {Return false;}
	switch ($kind)
	{
	case 1:
		Return isset($_POST[$inputname]) ?  filterhtml(htmlspecialchars_decode($_POST[$inputname]),$filterhtml) : '';
	break;
	case 2:
		Return isset($_POST[$inputname]) ?  filterhtml(htmlspecialchars_decode($_POST[$inputname]),$filterhtml) : '';
	break;
	case 3:
		Return isset($_POST[$inputname]) ?  filterhtml($_POST[$inputname],$filterhtml) : '';
	break;
	case 4:
		Return isset($_POST[$inputname]) ?  filterhtml($_POST[$inputname],$filterhtml) : '';
	break;
	case 5:
		Return isset($_POST[$inputname]) ?  filterhtml($_POST[$inputname],$filterhtml) : '';
	break;
	case 6:
		$newarray=array();
		if(isset($_POST[$inputname])) {
			unset($_POST[$inputname][0]);
			foreach($_POST[$inputname] as $key=>$val) {
				$newarray[]=filterhtml($val,$filterhtml);
			}
		}
		Return (json_encode($newarray));
	break;
	case 7:
		Return isset($_POST[$inputname]) ?  filterhtml($_POST[$inputname],4) : 1;
	break;
	case 8:
		Return isset($_POST[$inputname]) ?  filterhtml($_POST[$inputname],4) : 0;
	break;
	case 9:
		if($time=strtotime($_POST[$inputname])) {
			Return $time;
		}
		Return 0;
	break;
	case 26:
		Return isset($_POST[$inputname]) && $_POST[$inputname]==1 ?  1 : 0;
	break;
	case 10:
		$newarray=array();
		if(isset($_POST[$inputname])) {
			unset($_POST[$inputname][0]);
			foreach($_POST[$inputname] as $key=>$val) {
				$newarray[]=filterhtml($val,4);
			}
		}
		Return (json_encode($newarray));
	break;
	case 11:
		Return isset($_POST[$inputname]) ?  filterhtml($_POST[$inputname],4) : 0;
	break;
	case 17:
		Return isset($_POST[$inputname]) ?  filterhtml($_POST[$inputname],4) : 0;
	break;
	case 12:
		Return isset($_POST[$inputname]) ?  filterhtml($_POST[$inputname],4) : 0;
	break;
	case 14:
		Return isset($_POST[$inputname]) ?  filterhtml($_POST[$inputname],4) : 0;
	break;
	case 15:
		$newarray=array();
		if(isset($_POST[$inputname])) {
			unset($_POST[$inputname][0]);
			foreach($_POST[$inputname] as $key=>$val) {
				$newarray[]=filterhtml($val,4);
			}
			$newarray=array_unique($newarray);
		}
		Return (json_encode($newarray));
	case 21:
		Return isset($_POST[$inputname]) ?  filterhtml($_POST[$inputname],4) : 0;
	case 22:
		$newarray=array();
		if(isset($_POST[$inputname])) {
			unset($_POST[$inputname][0]);
			foreach($_POST[$inputname] as $key=>$val) {
				$newarray[]=filterhtml($val,4);
			}
		}
		Return (json_encode($newarray));
	case 27:
		$newarray=array();
		if(isset($_POST[$inputname])) {
			foreach($_POST[$inputname] as $key=>$val) {
				if(isset($_POST[$inputname.'-channel'][$key]) && power('s',intval($_POST[$inputname.'-channel'][$key]))) {
					$newarray[]=array(intval($_POST[$inputname.'-channel'][$key]),intval($val));
				}
			}
		}
		Return (json_encode($newarray));
	case 18:
		$newarray=array();
		if(isset($_POST[$inputname])) {
			unset($_POST[$inputname][0]);
			foreach($_POST[$inputname] as $key=>$val) {
					$newarray[]=filterhtml(htmlspecialchars_decode($val),$filterhtml);
			}
		}
		Return (json_encode($newarray));
	break;
	case 19:
		$newarray=array();
		if(isset($_POST[$inputname])) {
			unset($_POST[$inputname][0]);
			foreach($_POST[$inputname] as $key=>$val) {
					$newarray[]=filterhtml(htmlspecialchars_decode($val),$filterhtml);
			}
		}
		Return (json_encode($newarray));
	break;
	case 24:
		Return isset($_POST['editormd'.$inputname.'-markdown-doc']) ?  filterhtml($_POST['editormd'.$inputname.'-markdown-doc'],$filterhtml) : '';
	break;
	case 28:
		Return isset($_POST[$inputname]) && $_POST[$inputname]>0 ?  filterhtml($_POST[$inputname],4) : 0;
	break;
	case 29:
		$newarray=array();
		if(isset($_POST[$inputname])) {
			foreach($_POST[$inputname] as $key=>$val) {
				if($val>0) {
					$newarray[]=filterhtml($val,4);
				}
			}
		}
		Return (json_encode($newarray));
	break;
	case 30:
		$functionname=$moudle['strarray'];
		if(function_exists($functionname)) {
			$inputvalue=$functionname('input',$inputname,'');
			Return filterhtml($inputvalue,$filterhtml);
		}
		Return '';
	break;
	default:
		Return isset($_POST[$inputname]) ?  filterhtml($_POST[$inputname],$filterhtml) : '';
	}
}
function inputkindinfo($id) {
	global $inputkindarray;
	foreach($inputkindarray as $val) {
		if($id==$val['id']) {
			if(!isset($val['strfrom'])) {$val['strfrom']='';}
			Return $val;
		}
	}
	Return false;
}
function adminpagelist($recordcount,$pagesize,$curpage,$pages,$url)
{
	$totalpage = max(ceil($recordcount/$pagesize),1);
	if($curpage<0 || $curpage>$totalpage) {$curpage=1;}
	$outhtml = "";
	$pageno = $curpage;
	if($pageno<0 || $pageno>$totalpage) {$pageno=1;}
	if($pageno>2) {
		$outhtml.="<a href='".str_replace('{page}','1',$url)."'>&lt;&lt;</a>";
	}
	if($pages>$totalpage){
		$startpage=1;
		$endpage=min($startpage+$pages,$totalpage);
	}else{
		$startpage=max($totalpage-$pages,1);
		$startpage=min($startpage,$curpage);
		$endpage=min($startpage+$pages,$totalpage);
	}
	if($pageno>1) {
		$outhtml.="<a href='".str_replace('{page}',$pageno-1,$url)."'>&lt;</a>";
	}
	for($i=$startpage;$i<=$endpage;$i++)
	{
		if($curpage==$i){
			$outhtml.="<a class=\"current\">$i</a>";
		}else{
			$outhtml.="<a href='".str_replace('{page}',$i,$url)."'>$i</a>";
		}
	}
	if($pageno<$totalpage){
		$outhtml.="<a href='".str_replace('{page}',$pageno+1,$url)."'>&gt;</a>";
		$outhtml.="<a href='".str_replace('{page}',$totalpage,$url)."'>&gt;&gt;</a>";
	}
	echo $outhtml;
}
function admin_nav($cidarray) {
	global $cid;
	$str='<b>&gt;</b><strong>'.$cidarray['cname'].'</strong>';
	$i=0;
	while($cidarray['fid']<>0) {
		$cidarray=adminchannel($cidarray['fid']);
		if($cidarray['ckind']==1) {
			$str='<b>&gt;</b><strong><a href="?do=str&cid='.$cidarray['cid'].'">'.$cidarray['cname'].'</a></strong>'.$str;
		}elseif($cidarray['ckind']==2) {
			$str='<b>&gt;</b><strong><a href="?do=list&cid='.$cidarray['cid'].'">'.$cidarray['cname'].'</a></strong>'.$str;
		}elseif($cidarray['ckind']==3){
			$str='<b>&gt;</b><strong><a href="?do=str&cid='.$cidarray['cid'].'">'.$cidarray['cname'].'</a></strong>'.$str;
		}elseif($cidarray['ckind']==4) {
			$str='<b>&gt;</b><strong><a href="'.$cidarray['cvalue'].'">'.$cidarray['cname'].'</a></strong>'.$str;
		}elseif($cidarray['ckind']==5) {
			$str='<b>&gt;</b><strong><a href="'.get_transit_channel($cidarray['cid'],2).'">'.$cidarray['cname'].'</a></strong>'.$str;
		}
		$i++;
		if($i>66) {
			Return $str;
		}
	}
	Return $str;
	
}
function admin_nav_list($cid,$son=0) {
	global $channels,$power;
	$fid=0;
	$count=0;
	foreach($channels as $value){
		if($cid==$value['cid']) {
			$fid=$value['fid'];
		}
		if ($value['fid']==$cid && power('s',$value['cid'],$power)){
			if($value['ifshowadmin']==1) {
				$count++;
				$zzssqqw=1;
				if($son==$value['cid']) {
					$style=' class="on"';
				}else {
					$style='';
				}
				if($value['ckind']==1) {
					echo('<a'.$style.' href="?do=str&cid='.$value['cid'].'">'.$value['cname'].'</a>');
				}elseif($value['ckind']==2) {
					echo('<a'.$style.' href="?do=list&cid='.$value['cid'].'">'.$value['cname'].'</a>');
				}elseif($value['ckind']==3){
					echo('<a'.$style.' href="?do=str&cid='.$value['cid'].'">'.$value['cname'].'</a>');
				}elseif($value['ckind']==4) {
					if($value['newwindow']==1) {
						echo('<a'.$style.' href="'.$value['cvalue'].'" target="_blank">'.$value['cname'].'</a>');
					}else {
						echo('<a'.$style.' href="'.$value['cvalue'].'">'.$value['cname'].'</a>');
					}
				}elseif($value['ckind']==5) {
					echo('<a'.$style.' href="'.get_transit_channel($value['cid'],2).'">'.$value['cname'].'</a>');
				}
			}
		}
	}
	if(!isset($zzssqqw) && $fid>0) {
		admin_nav_list($fid,$cid);
	}
	if($count==1) {
		echo('<script type="text/javascript">$(function(){$("#urHere a.on").hide();});</script>');
	}
}
function adminmsg($url,$msg,$s=3,$pagename='列表页') {
	if(isset($_GET['nohtml']) && $_GET['nohtml']) {
		echo('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">');
		echo($msg);
		if(!empty($url)) {
			jump($url,$s);
		}
		exit;
	}
	echo('<script>$(function(){$(document).keydown(function(event){var ctrlc = event.which;var key=ctrlc-48;if (key>0 && key<10){keygourl=$(\'.AdminMsg\').find(\'a\').eq(key-1).attr(\'href\');if (keygourl.length>3){window.location.href=keygourl;}}});});</script>');
	if($url=='') {
		echo('<div id="UMain"><div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>信息提示</strong> </div> <div id="mainBox"><h3>信息提示</h3><div class="AdminMsg"><h2>'.$msg.'</h2><dl><dt>请<a href="javascript:history.go(-1);">返回</a>。</dt><dd><a href="javascript:history.go(-1);">返回上一页</a></dd></dl></div></div></div>');
	}else {
		$jsurl=str_replace("\\","\\\\",$url);
		echo('<div id="UMain"><div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>信息提示</strong> </div> <div id="mainBox"><h3>信息提示</h3><div class="AdminMsg"><h2>'.$msg.'</h2><dl><dt>如果您不做出选择，将在 '.$s.' 秒后跳转到'.$pagename.' (按Enter键直接跳转)。</dt><dd><a href="javascript:history.go(-1);">返回上一页</a></dd></dl></div></div></div><script type="text/javascript">$(document).keydown(function(event){var ctrlc = event.which; if(ctrlc == 13 || ctrlc ==32){window.location.href = "'.$jsurl.'";}});</script>');
		jump($url,$s);
	}
	exit;
}
function clink($count){
	$str='';
	for($i=0;$i<$count-1;$i++){
		$str.='──';
	}
	return $str;
}
function admin_hook($cid,$action,$funcname) {
	global $admin_hooks;
	if(is_array($cid)) {
		foreach($cid as $key=>$val) {
			$admin_hooks[]=array('cid'=>$val,'action'=>$action,'funcname'=>$funcname);
		}
	}else {
		$admin_hooks[]=array('cid'=>$cid,'action'=>$action,'funcname'=>$funcname);
	}
	Return true;
}
function run_admin_hook($cid,$action) {
	global $admin_hooks;
	foreach($admin_hooks as $thishook) {
		if($cid==$thishook['cid']){
			$thishook_actions=explode(';',$thishook['action']);
			foreach($thishook_actions as $thishook_action) {
				if($action==$thishook_action) {
					runfunc($thishook['funcname']);
				}
			}
		}
	}
}
function runfunc($func) {
	if(function_exists($func)) {
		$func();
	}else {
		Return false;
	}
}
function adminchannelscache() {
	global $channels;
	if(!is_array($channels)) {
		$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('channel')." order by corder asc");
		$channels  =$GLOBALS['db'] -> fetchall($query);
	}
	Return $channels;
}
function adminchannel($cid) {
	global $channels;
	if(!isset($channels) || count($channels)==0) {
		Return false;
	}
	foreach($channels as $key=>$val) {
		if($val['cid']==$cid) {
			Return $val;
		}
	}
	Return false;
}
function channel_select($selectid=0,$fid=0,$i=0,$returnstr=1,$topname='--顶级栏目--') {
	$i=$i+1;
	global $channels;
	$Returnarray=array();
	if($fid==0) {
		if($returnstr) {
			echo('<option value="0">'.$topname.'</option>');
		}
	}
	if(is_array($channels)) {
		foreach($channels as $channel) {
			if($channel['fid']==$fid) {
				if($returnstr) {
					if($selectid==$channel['cid']) {
						echo('<option value="'.$channel['cid'].'" selected>├'.clink($i).$channel['cname'].'</option>');
					}else {
						echo('<option value="'.$channel['cid'].'">├'.clink($i).$channel['cname'].'</option>');
					}
				}else {
					$Returnarray[]=array('cname'=>$channel['cname'],'ext'=>'├'.clink($i*2),'cid'=>$channel['cid'],'fid'=>$channel['fid'],'ifshowadmin'=>$channel['ifshowadmin'],'ckind'=>$channel['ckind'],'corder'=>$channel['corder'],'cvalue'=>$channel['cvalue'],'ifshow'=>$channel['ifshow'],'csetting'=>$channel['csetting']);
				}
				$nextchannel=channel_select($selectid,$channel['cid'],$i,$returnstr);
				if(is_array($nextchannel) && count($nextchannel)>0) {
					foreach($nextchannel as $val) {
						$Returnarray[]=$val;
					}
				}
			}
		}
	}
	if(!$returnstr) {
		Return $Returnarray;
	}
}
function treeselect($category,$inputvalue,$thisdaddy=0,$i=0){
	$i=$i+1;
	if(isset($category[0])) {
		foreach($category[0] as $key=>$val) {
			if($key<>'id' && $key<>'fid' && !is_numeric($key)) {
				$mname=$key;
			}
		}
	}
	foreach($category as $value){
		
		if ($value['fid']==$thisdaddy){
			if($value['id']==$inputvalue) {
					echo('<option value="'.$value['id'].'" selected>├'.clink($i).$value[$mname].'</option>');
			}else {
					echo('<option value="'.$value['id'].'">├'.clink($i).$value[$mname].'</option>');
			}
			treeselect($category,$inputvalue,$value['id'],$i);
		}
	}
}
function getlistcolumn($cid,$setting=array()) {
	$columnssql=array();
	$columnssql[]='id';
	$columnssql[]='cid';
	$columnssql[]='posttime';
	$columnssql[]='adminuid';
	$columns = $GLOBALS['db'] -> all("SELECT cid,ifshowtemp,hide,mname,ifshow FROM ".tableex('moudle')." where  cid='$cid' and ifcreated='1' order by morder asc");
	foreach($columns as $key=>$val) {
		if($val['hide']<>1 && $val['ifshow']==1) {
			if(!in_array($val['mname'],$columnssql)) {
				$columnssql[]=$val['mname'];
			}
			
		}
		if(strlen($val['ifshowtemp'])>2) {
			$pattern="/[{|\[|(](.*)[}|\]|)]/U";
			preg_match_all($pattern,$val['ifshowtemp'],$match);
			if(isset($match[1])) {
				foreach($match[1] as $matchval) {
					if(!in_array($matchval,$columnssql)) {
						$ifin=0;
						foreach($columns as $columnsval) {
							if($columnsval['mname']==$matchval) {
								$ifin=1;
							}
						}
						if($ifin==1) {
							$columnssql[]=$matchval;
						}
					}
				}
			}
		}

	}
	if(in_array('title',$columnssql) && isset($setting['channel_articleurl'])) {
		$pattern="/[{|\[|(](.*)[}|\]|)]/U";
		preg_match_all($pattern,$setting['channel_articleurl'],$match);
		if(isset($match[1])) {
			foreach($match[1] as $matchval) {
				if(!in_array($matchval,$columnssql)) {
					$ifin=0;
					foreach($columns as $columnsval) {
						if($columnsval['mname']==$matchval) {
							$ifin=1;
						}
					}
					if($ifin==1) {
						$columnssql[]=$matchval;
					}
				}
			}
		}
	}
	Return implode(',',$columnssql);
}
function getlistsearchcolumn($cid) {
	$columnsarray=array();
	$columnsarray[]='id';
	$columns = $GLOBALS['db'] -> all("SELECT mname,msetting FROM ".tableex('moudle')." where  cid='$cid' and ifcreated='1' and hide<>1 order by morder asc");
	foreach($columns as $key=>$val) {
		$msetting=json_decode($val['msetting'],1);
		if(isset($msetting['adminsearch'])) {
			$columnsarray[]=$val['mname'];
		}
	}
	Return $columnsarray;
}
function admintablecheck($tablename) {
	if(empty($tablename)) {Return true;}
	Return preg_match("/^[A-Za-z0-9_]+$/",$tablename);
}
function adminchannelcache($cid) {
	$channel=getchannelcache($cid);
	if(!$channel) {
		Return false;
	}
	if(!isset($channel['csetting']['articletable']) || empty($channel['csetting']['articletable'])) {Return false;}
	if(isset($channel['csetting']['temppage_order']) && strlen($channel['csetting']['temppage_order'])>3) {
		$channel['csetting']['temppage_order']='order by '.$channel['csetting']['temppage_order'];
	}else {
		$channel['csetting']['temppage_order']='order by id desc';
	}
	Return $channel;
}
function channeltable($cid,$articletable) {
	global $site_db,$inputkindarray;
	//创建表
	if($site_db['database']=='sqlitepdo') {
		$query = $GLOBALS['db'] -> query("CREATE TABLE if not exists [".$articletable."] ([id] INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT,[posttime] INTEGER  NULL,[cid] INTEGER NOT NULL,[adminuid] INTEGER  NULL)");
	}elseif($site_db['database']=='mysqlpdo' || $site_db['database']=='mysql') {
		if (defined('MysqlEngine') && strtolower(MysqlEngine)=='myisam') {$tableMysqlEngine='MyISAM';}else {$tableMysqlEngine='InnoDB';}
		$query = $GLOBALS['db'] -> query("CREATE TABLE if not exists `".$articletable."` (`id` int(8) NOT NULL auto_increment,`posttime` int(10) default 0,`cid` int(8) default 0,`adminuid` int(8) default 0,PRIMARY KEY  (`id`)) ENGINE=".$tableMysqlEngine." DEFAULT CHARSET=utf8;");
	}else{
		echo('database error');
		Return false;
	}
	if($site_db['database']=='sqlitepdo') {
		$query = $GLOBALS['db'] -> query("SELECT * FROM sqlite_master WHERE type='table' and name='".$articletable."';");
		$articletablelist = $GLOBALS['db'] -> fetchone($query);
	}elseif($site_db['database']=='mysqlpdo' || $site_db['database']=='mysql') {
		$query = $GLOBALS['db'] -> query("show columns from `$articletable`");
		$link = $GLOBALS['db'] -> fetchall($query);
		$articletablelist['sql']='';
		foreach ($link as $value) 
		{    
			$articletablelist['sql'].=' '.$value['Field'].' ';
		}
	}else{
		echo('database error');
		Return false;
	}

	$neworder=1;
	$quickadd=0;
	$links = $GLOBALS['db'] -> all("SELECT * FROM ".tableex('moudle')." where cid='$cid' and hide<>'1' order by morder asc");
	$countmoudle=0;
	foreach($links as $link) {	
		if(stripos($articletablelist['sql'],'['.$link['mname'].']')>0 || stripos($articletablelist['sql'],' '.$link['mname'].' ')>0) {
		
		}else {
			$countmoudle++;
			$mkind=$link['mkind'];
			$mname=$link['mname'];
			$val=inputkindinfo($mkind);
			if($val) {
				if(isset($val['kind']) && $val['kind']=='int') {
					$query = $GLOBALS['db'] -> query("alter table $articletable add $mname INTEGER NULL;");
				}elseif(isset($val['kind']) && $val['kind']=='varchar') {
					$query = $GLOBALS['db'] -> query("alter table $articletable add $mname VARCHAR(250) NULL;");
				}elseif(isset($val['kind']) && $val['kind']=='text') {
					$query = $GLOBALS['db'] -> query("alter table $articletable add $mname TEXT NULL;");
				}elseif(isset($val['kind'])){
					$query = $GLOBALS['db'] -> query("alter table $articletable add $mname ".$val['kind']." NULL;");
				}else {
					$query = $GLOBALS['db'] -> query("alter table $articletable add $mname VARCHAR(250) NULL;");
				}
			}
		}
	}
	if($countmoudle>0) {
		Return true;
	}else {
		Return 'no';
	}
}
function postroutercheck($str,$ifurl=0) {
	$str=str_replace("；",';',$str);
	$str=str_replace("（",'(',$str);
	$str=str_replace("）",')',$str);
	$str=str_replace("。",'.',$str);
	if($ifurl==1) {
		$strs=explode(';',$str);
		foreach($strs as $key=>$val) {
			if(!empty($val)) {
				$strs[$key]='/'.ltrim($val,'/');
			}else {
				unset($strs[$key]);
			}
		}
		$str=implode(';',$strs);
	}
	$str=str_replace("'",'',$str);
	$str=str_replace('"','',$str);
	$str=str_replace("\\",'/',$str);
	Return trim($str);
}
function channelrouter() {
	$allurl=array();
	$allurl[]=array('uri'=>'/','res'=>'index','domain'=>SystemDomain,'cache'=>IndexCache,'cid'=>0);
	$diyurl = $GLOBALS['db'] -> one("SELECT * FROM ".tableex('str')." where strname='diyurl' and inputkind=0 limit 1;");
	if($diyurl) {
		$diyurl=json_decode($diyurl['strvalue'],1);
		foreach($diyurl as $val) {
			$allurl[]=array('uri'=>$val['uri'],'res'=>$val['res'],'domain'=>SystemDomain,'cache'=>$val['cache'],'cid'=>0);
		}
	}
	$channels = $GLOBALS['db'] -> all("SELECT * FROM ".tableex('channel')." order by cid asc");
	foreach($channels as $key=>$val) {
		$csetting=json_decode($val['csetting'],1);
		if($val['ifshow']>0) {
			if(!isset($csetting['channel_domain'])) {$csetting['channel_domain']='';}
			if($val['ckind']==1) {
				if(isset($csetting['channel_url']) && isset($csetting['template']) && isset($csetting['channel_urlcache']) && strlen($csetting['channel_url'])>0 && !empty($csetting['template'])) {
					$csetting['channel_url']=str_replace("(cid)",$val['cid'],$csetting['channel_url']);
					$csetting['template']=str_replace("(cid)",$val['cid'],$csetting['template']);
					$allurl[]=array('uri'=>$csetting['channel_url'],'res'=>$csetting['template'],'cache'=>$csetting['channel_urlcache'],'cid'=>$val['cid'],'domain'=>$csetting['channel_domain']);
				}
			}elseif($val['ckind']==2) {
				if(isset($csetting['channel_url']) && isset($csetting['template']) && isset($csetting['channel_urlcache']) && substr($csetting['channel_url'],0,1)!=='!' && strlen($csetting['channel_url'])>0 && !empty($csetting['template'])) {
					$csetting['channel_url']=str_replace("(cid)",$val['cid'],$csetting['channel_url']);
					$csetting['template']=str_replace("(cid)",$val['cid'],$csetting['template']);
					$allurl[]=array('uri'=>$csetting['channel_url'],'res'=>$csetting['template'],'cache'=>$csetting['channel_urlcache'],'cid'=>$val['cid'],'domain'=>$csetting['channel_domain']);
				}
				if(isset($csetting['channel_pageurl']) && isset($csetting['templatelist']) && isset($csetting['channel_pageurlcache']) && strlen($csetting['channel_pageurl'])>0 && !empty($csetting['templatelist'])) {
					$csetting['channel_pageurl']=str_replace("(cid)",$val['cid'],$csetting['channel_pageurl']);
					$csetting['templatelist']=str_replace("(cid)",$val['cid'],$csetting['templatelist']);
					$allurl[]=array('uri'=>$csetting['channel_pageurl'],'res'=>$csetting['templatelist'],'cache'=>$csetting['channel_urlcache'],'cid'=>$val['cid'],'domain'=>$csetting['channel_domain']);
				}
				if(isset($csetting['channel_articleurl']) && isset($csetting['templatearticle']) && isset($csetting['channel_articleurlcache']) && strlen($csetting['channel_articleurl'])>0 && !empty($csetting['templatearticle'])) {
					$csetting['channel_articleurl']=str_replace("(cid)",$val['cid'],$csetting['channel_articleurl']);
					$csetting['templatearticle']=str_replace("(cid)",$val['cid'],$csetting['templatearticle']);
					$allurl[]=array('uri'=>$csetting['channel_articleurl'],'res'=>$csetting['templatearticle'],'cache'=>$csetting['channel_articleurlcache'],'cid'=>$val['cid'],'domain'=>$csetting['channel_domain']);
				}
			}
			if(isset($csetting['otherpage'])) {
				$otherpagearray=json_decode($csetting['otherpage'],1);
				foreach($otherpagearray as $otherpage) {
					if(isset($otherpage['uri']) && isset($otherpage['res']) && !empty($otherpage['res']) && isset($otherpage['cache'])) {
						$otherpage['uri']=str_replace("(cid)",$val['cid'],$otherpage['uri']);
						$otherpage['res']=str_replace("(cid)",$val['cid'],$otherpage['res']);
						$allurl[]=array('uri'=>$otherpage['uri'],'res'=>$otherpage['res'],'cache'=>$otherpage['cache'],'cid'=>$val['cid'],'domain'=>$csetting['channel_domain']);
					}
				}
			}
		}
	}
	$allurl=dbstr(json_encode($allurl));
	$routerquery = $GLOBALS['db'] -> one("SELECT strvalue FROM ".tableex('str')." where strname='router' and inputkind=0 limit 1;");
	if(!$routerquery) {
		$query = $GLOBALS['db'] -> query("INSERT INTO `".tableex('str')."` (`strname`,`strcid`,`strorder`,`inputkind`,`strvalue`,`ifadmin`) VALUES ('router','0','0','0','$allurl','1');");
	}else {
		$query = $GLOBALS['db'] -> query("UPDATE ".tableex('str')." SET strvalue='$allurl' WHERE strname='router' and inputkind=0;");
		cachedel('router','str');
	}
	if($query) {
		Return true;
	}else {
		Return false;
	}
}
function get_transit_channel($cid,$kind=1) {
	$cid=intval($cid);
	global $channels,$power;
	if($kind==1) {
		foreach($channels as $key=>$val ) {
			if($val['fid']==$cid && $val['ifshow']==1) {
				if($val['ckind']==5) {
					Return get_transit_channel($val['cid']);
				}else {
					Return getchannelurl($val['cid']);
				}
			}
		}
		
	}
	if($kind==2) {
		foreach($channels as $key=>$val ) {
			if($val['fid']==$cid && $val['ifshowadmin']==1  && power('s',$val['cid'],$power)) {
				if($val['ckind']==5) {
					Return get_transit_channel($val['cid'],2);
				}elseif($val['ckind']==1 || $val['ckind']==3) {
					Return "?do=str&cid=".$val['cid'];
				}elseif($val['ckind']==2) {
					Return "?do=list&cid=".$val['cid'];
				}elseif($val['ckind']==4) {
					Return $val['cvalue'];
				}
			}
		}
	}
	Return '#';
}
function transit_channel_cache() {
	global $channels;
	foreach($channels as $key=>$val ) {
		if($val['ckind']==5) {
			$value=dbstr(get_transit_channel($val['cid']));
			$query = $GLOBALS['db'] -> query("UPDATE ".tableex('channel')." SET cvalue='$value' WHERE cid='".$val['cid']."'");
			if(!$query) {Return false;}
		}
	}
	Return true;
}
?>