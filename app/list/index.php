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
if(!isset($_GET['cid'])) {die('error');}
$cid=intval($_GET['cid']);
if($cid<1) {die('error');}
if(!power('s',$cid)) {die('error');}
if(isset($_GET['keyword']) && $_GET['keyword']<>'') {$keyword=$_GET['keyword'];}else {$keyword='';}
if(isset($_GET['articlemname'])) {
	$articlemname=dbstr(htmlspecialchars($_GET['articlemname']));
	if(isset($_GET['articlechoose'])) {
		$articlechoose=dbstr(htmlspecialchars($_GET['articlechoose']));
		$articleschooseuri='&articlechoose='.$articlechoose.'&articlemname='.$articlemname;
	}elseif(isset($_GET['articleschoose'])) {
		$articleschoose=dbstr(htmlspecialchars($_GET['articleschoose']));
		$articleschooseuri='&articleschoose='.$articleschoose.'&articlemname='.$articlemname;
	}elseif(isset($_GET['allarticleschoose'])) {
		$allarticleschoose=dbstr(htmlspecialchars($_GET['allarticleschoose']));
		$articleschooseuri='&allarticleschoose='.$allarticleschoose.'&articlemname='.$articlemname;
	}else {
		$articleschooseuri='';
	}
}else {
	$articleschooseuri='';
}
$link =adminchannel($cid);
if($link['ifshowadmin']==0) {adminmsg('','此栏目已经禁用');}
if($link['ckind']!=2) {
	adminmsg('','该栏目不是文章栏目');
}
if(!$link) {exit;}
$cname=$link['cname'];
$ifshowthischannel=$link['ifshow'];
$csetting=json_decode($link['csetting'],1);
//文章来源表,多表管理,GET传入articletable,可以管理其他表里面的数据,表结构必须与该栏目相同,cid也相同
if(isset($_GET['articletable']) && !empty($_GET['articletable'])) {
	$articletable=dbstr($_GET['articletable']);
	$articletableuri='&articletable='.$articletable;
}else {
	$articletable='';
	$articletableuri='';
}
if(!admintablecheck($articletable)) {adminmsg('','栏目表名有误');}
//后台排序方式
if(isset($csetting['temppage_order']) && strlen($csetting['temppage_order'])>5) {
	$ordersql=$csetting['temppage_order'];
}else {
	$ordersql='id desc';
}
//管理员字段
if(power('sadmin',0) || power('s',$cid,$power,5)) {
	$thissql='';
}else {
	$thissql=" and ifadmin<>'1'";
}
//默认显示父分类
if(!empty($keyword)) {
	unset($csetting['listfidshow']);
}
if(isset($csetting['listfidshow']) && $csetting['listfidshow']==1) {
	$fidmoudleinfo = $GLOBALS['db'] -> one("SELECT strarray FROM ".tableex('moudle')." where cid='$cid' and mname='fid'$thissql limit 1");
	if($fidmoudleinfo) {
		$fidmoudlestrarray=explode('|',$fidmoudleinfo['strarray']);
		if(!isset($fidmoudlestrarray[0]) || $fidmoudlestrarray[0]!=$cid) {
			unset($csetting['listfidshow']);
		}
	}else {
		unset($csetting['listfidshow']);
	}
}
//查询的字段
if(isset($_GET['moudleid']) && isset($_GET['fid'])) {
	$moudleid=dbstr(htmlspecialchars($_GET['moudleid']));
	$fid=intval($_GET['fid']);
	$ifhavemoudle = $GLOBALS['db'] -> fetchcount("SELECT id FROM ".tableex('moudle')." where cid='$cid' and mname='$moudleid'$thissql limit 1");
	if(!$ifhavemoudle) {//如果不存在字段
		unset($moudleid);
		unset($fid);
		$moudleiduri='';
	}else{
		$moudleiduri='&fid='.$fid.'&moudleid='.$moudleid;
	}
}else {
	$moudleiduri='';
}
//不是管理员则不要管理员字段
$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('moudle')." where hide<>'1' and cid='$cid' and ifcreated='1' and ifshow='1'$thissql order by morder asc");
$moudle = $GLOBALS['db'] -> fetchall($query);
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理
<?php echo(admin_nav($link));?>
<div class="list">
<?php
if($cid>0) {
	admin_nav_list($cid);
}
?>
</div>
<?php
$tablecreated=1;
if(power('sadmin',0) && count($moudle)==0) {
	echo('栏目字段尚未建立,请先<a style="color:#0000FF" href="?do=sadmin_aindex&cid='.$cid.'">建立栏目字段</a>');
	$csetting['articletable']='';
	$tablecreated=0;
}
?>

</div>
<div id="mainBox">
	<h3>
		 <?php
			if(power('s',$cid,$power,4)) {
				if(power('s',$cid,$power,5)) {
					$cidstrcount = $GLOBALS['db'] -> fetchcount("SELECT count(id) FROM ".tableex('str')." where strcid='$cid';");
				}else {
					$cidstrcount = $GLOBALS['db'] -> fetchcount("SELECT count(id) FROM ".tableex('str')." where strcid='$cid' and ifadmin='0';");
				}
				if($cidstrcount>0) {
					echo('<a href="?do=str&cid='.$cid.'" class="actionBtn" style="margin-left:10px"><em>设置</em></a>');
				}
			}
			if((!isset($csetting['listnoadd']) || $csetting['listnoadd']==0) && power('s',$cid,$power,1) && $tablecreated) {
					echo('<a href="?do=list_add&cid='.$cid.$articletableuri.$articleschooseuri.$moudleiduri.'" class="actionBtn add"><em>增加</em></a>');
			}
			?>
		<a href="?do=list&cid=<?php echo($cid);?>"><?php echo($cname);?></a>
<?php
	$where['searchcolumn']=getlistsearchcolumn($cid);
	if(count($where['searchcolumn'])>1) {
?>
		<div class="searcharea">
					<form name="filter" action="?do=list" method="GET">
					<input type="hidden" name="do" value="list">
					<?php
						if(!empty($articletable)) {
							echo('<input type="hidden" name="articletable" value="'.$articletable.'">');
						}
						if(isset($articlechoose)) {
							echo('<input type="hidden" name="articlechoose" value="'.$articlechoose.'">');
						}
						if(isset($articleschoose)) {
							echo('<input type="hidden" name="articleschoose" value="'.$articleschoose.'">');
						}
						if(isset($allarticleschoose)) {
							echo('<input type="hidden" name="allarticleschoose" value="'.$allarticleschoose.'">');
						}
						if(isset($articlemname)) {
							echo('<input type="hidden" name="articlemname" value="'.$articlemname.'">');
						}
					?>
					<input type="hidden" name="cid" value="<?php echo($cid);?>">
					<input type="text" class="inputtext" style="width:180px" name="keyword" value="<?php if($keyword<>'') {echo(htmlspecialchars($_GET['keyword']));}?>" placeholder="">
					<?php
						run_admin_hook($cid,'listsearch');
					?>
					<input class="btnsearch" type="submit" value="搜索" />
					</form>
		</div>
<?php
	}
?>
			&nbsp;&nbsp;&nbsp;
		</h3>

	<div id="list">
	<?php
		run_admin_hook($cid,'index');
	?>
	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
	<tr>
	
	<?php
		if($tablecreated) {
			echo('<th width="22" align="center">选</th>');
		}
		foreach ($moudle as $value){
				echo('<th align="center">'.$value['minfo'].'</th>');
		}
	?>
	<?php
	if(isset($csetting['listfidshow']) && $csetting['listfidshow']==1) {
		echo('<th width="80" align="center">子分类');
		if(isset($fid) && $fid>0) {
			$fidwhere=array();
			if(!empty($articletable)) {$fidwhere['tablename']=$articletable;}
			$fidwhere['cid']=$cid;
			$fidwhere['where']['id']=$fid;
			$fidwhere['column']='fid';
			$fidinfo=a($fidwhere);
			if($fidinfo && $fidinfo['fid']>0) {
				echo('[<a href="?do=list&cid='.$cid.'&fid='.$fidinfo['fid'].'&moudleid='.$moudleid.$articletableuri.$articleschooseuri.'">返回</a>]');
			}else {
				echo('[<a href="?do=list&cid='.$cid.$articletableuri.$articleschooseuri.'">返回</a>]');
			}
		}
		echo('</th>');
	}
	?>
	<?php
	if(isset($csetting['listshowadminname']) && $csetting['listshowadminname']==1) {
		echo('<th width="100" align="center">作者</th>');
	}
	?>
	<th width="150" style="min-width:150px;" align="center" class="admin_list_action_td">操作</th>
	</tr>
<?php
if(isset($fid) && isset($moudleid)) {
	$where['where'][$moudleid]=intval($fid);
}else {
	//默认显示父分类
	if(isset($csetting['listfidshow']) && $csetting['listfidshow']==1) {
		$where['where']['fid']=0;
	}
}

$where['order']=$ordersql;
if (!isset($_GET['page'])){$where['page']=1;}else{$where['page']=intval($_GET['page']);}
$where['cid']=$cid;
$where['column']=getlistcolumn($cid,$csetting);
if (!empty($keyword) && count($where['searchcolumn'])>1){
	$where['keyword']=$keyword;
}
if(isset($_COOKIE['pagesize_'.$cid])) {
	$where['pagesize']=intval($_COOKIE['pagesize_'.$cid]);
	if($where['pagesize']>999) {$where['pagesize']=999;}
	if($where['pagesize']<1) {$where['pagesize']=1;}
}else {
	$where['pagesize']=15;
	if(isset($csetting['temppage_size']) && $csetting['temppage_size']>0) {
		$where['pagesize']=$csetting['temppage_size'];
	}
}

if(isset($csetting['articletable'])) {$where['tablename']=$csetting['articletable'];}else {die('栏目尚未配置完成');}
if(!empty($articletable)) {$where['tablename']=$articletable;}
if(power('sadmin',0) || power('s',$cid,$power,5)) {}else {if(isset($csetting['listadminuid']) && $csetting['listadminuid']==1) {$where['where']['adminuid']=$myadminuid;}}//普通用户只能编辑自己的文章
run_admin_hook($cid,'list');
$where['all']=0;
if($tablecreated) {
	$articles=alist($where);
}else {
	$articles=array('list'=>array(),'pagecount'=>0,'pagesize'=>1,'page'=>1,);
}

$thismoudlearray=array();
			foreach ($articles['list'] as $article)
			{
				run_admin_hook($cid,'listrow');
				?>
            <tr>
              <td align="center" class="article_checkbox"><input name="delpost" class="delpost" type="checkbox" value="<?php echo($article['id']);?>" title='<?php echo($article['id']);?>'/>
             </td>
			 <?php
					
				foreach ($moudle as $thismoudle) 
				{
					if($thismoudle['mname']=='title' && empty($thismoudle['ifshowtemp']) && isset($article['link']) && strlen(trim($article['link']))>1 && $ifshowthischannel && $thismoudle['mkind']<3) {
						$thismoudle['ifshowtemp']='<a href="{link}" target="_blank">{title}</a>';
					}
					if(strlen($thismoudle['ifshowtemp'])>3) {
						$thistemp=$thismoudle['ifshowtemp'];
						foreach ($article as  $key => $articleziduan){
							$thistemp=str_replace('{'.$key.'}',htmlspecialchars(@$article[$key]),$thistemp);
						}
						echo('<td align="left">'.$thistemp.'</td>');
					}else {
						if($thismoudle['mkind']==5) {
							if(strlen($article[$thismoudle['mname']])>5) {
								echo('<td align="center" ><img class="pic" src="'.@htmlspecialchars($article[$thismoudle['mname']]).'"></td>');
							}else {
								echo('<td align="center" >无</td>');
							}
						}elseif($thismoudle['mkind']==6){
							if(strlen(@$article[$thismoudle['mname']])>10) {
								echo('<td align="center" >');
								$thispics=json_decode($article[$thismoudle['mname']],1);
								foreach($thispics as $thispic) {
									echo('<img class="pic" src="'.@htmlspecialchars($thispic).'">');
								}
								echo('</td>');
							}else {
								echo('<td align="center" >无</td>');
							}
						}elseif($thismoudle['mkind']==9)
						 {
							if(is_numeric(@$article[$thismoudle['mname']])) {
								$thisyear=strtotime(date('Y-01-01'));
								if(@$article[$thismoudle['mname']]>=$thisyear) {
									echo('<td width="150px" align="center">'.@date("m-d H:i",@$article[$thismoudle['mname']]).'</td>');
								}else {
									echo('<td width="150px" align="center">'.@date("Y-m-d H:i",@$article[$thismoudle['mname']]).'</td>');
								}
							}else {
								echo('<td width="150px" align="center">'.@$article[$thismoudle['mname']].'</td>');
							}
							
						}elseif($thismoudle['mkind']==26)
						 {
							echo('<td width="150px" align="center">');
							if((!isset($csetting['listnoedit']) || $csetting['listnoedit']==0) && power('s',$cid,$power,2)) {
								$listcheckboxchange=true;
								if(isset($article[$thismoudle['mname']]) && $article[$thismoudle['mname']]==1) {
									echo('<input type="checkbox" id="listcheckboxchange'.$thismoudle['mname'].$article['id'].'" class="listcheckboxchange" checked rel="'.$thismoudle['mname'].'" cid="'.$article['cid'].'" articleid="'.$article['id'].'">');
								}else {
									echo('<input type="checkbox" id="listcheckboxchange'.$thismoudle['mname'].$article['id'].'" class="listcheckboxchange" rel="'.$thismoudle['mname'].'"  cid="'.$article['cid'].'" articleid="'.$article['id'].'">');
								}
							}else {
								if(isset($article[$thismoudle['mname']]) && $article[$thismoudle['mname']]==1) {
									echo('<input type="checkbox" checked disabled=1">');
								}else {
									echo('<input type="checkbox"  disabled=1">');
								}
							}
							echo('</td>');
						}
						elseif($thismoudle['mkind']==20)
						 {
							$thisarray=json_decode($article[$thismoudle['mname']],1);
							echo('<td align="center">');
							if(is_array($thisarray)) {
								foreach($thisarray as $value) {
									echo(implode(";",$value));
									echo('<br>');
								}
							}
							echo('</td>');
						}
						elseif($thismoudle['mkind']==21)
						 {
							if(!isset($strarray[$thismoudle['mname']])) {
								$thismoudlesetting=explode('|',$thismoudle['strarray']);
								if(count($thismoudlesetting)<>2) {
									echo('<td>');
									htmlinput_error('list',$thismoudle['id']);
								}
								$strarray[$thismoudle['mname']]['cid']=$thismoudlesetting[0];
								$strarray[$thismoudle['mname']]['mname']=$thismoudlesetting[1];
								$thiscid=$strarray[$thismoudle['mname']]['cid'];
								if(!power('s',$thiscid,$power,2)) {
									$strarray[$thismoudle['mname']]['power']=false;
								}else {
									$strarray[$thismoudle['mname']]['power']=true;
								}
								$thischannel=adminchannelcache($thiscid);
								if($thischannel) {
									$strarray[$thismoudle['mname']]['tablename']=$thischannel['csetting']['articletable'];
								}else {
									echo('<td>');
									htmlinput_error('list',$thismoudle['id']);
								}
							}else {
								$thiscid=$strarray[$thismoudle['mname']]['cid'];
							}
							echo('<td align="center">');
							if($article[$thismoudle['mname']]>0) {
								if(!isset($strarray[$thismoudle['mname']]['list'][$article[$thismoudle['mname']]])) {
									$query = $GLOBALS['db'] -> query("SELECT id,".$strarray[$thismoudle['mname']]['mname']." FROM ".$strarray[$thismoudle['mname']]['tablename']." where id='".$article[$thismoudle['mname']]."' limit 1;");
									if($thislink = $GLOBALS['db'] -> fetchone($query)) {
										if(empty($thislink[$strarray[$thismoudle['mname']]['mname']])) {
											$thislink[$strarray[$thismoudle['mname']]['mname']]='无标题';
										}
										$strarray[$thismoudle['mname']]['list'][$article[$thismoudle['mname']]]=$thislink[$strarray[$thismoudle['mname']]['mname']];
										
									}else {
										$strarray[$thismoudle['mname']]['list'][$article[$thismoudle['mname']]]='<em class="warning">已删除</em>';
									}
								}
								if($strarray[$thismoudle['mname']]['power']) {
									echo('<a href="?do=list_edit&cid='.$thiscid.'&id='.$article[$thismoudle['mname']].'" target="_blank">'.$strarray[$thismoudle['mname']]['list'][$article[$thismoudle['mname']]].'</a>');
								}else {
									echo($strarray[$thismoudle['mname']]['list'][$article[$thismoudle['mname']]]);
								}
							}
							echo('</td>');
						}
						elseif($thismoudle['mkind']==22)
						 {
							if(!isset($strarray[$thismoudle['mname']])) {
								$thismoudlesetting=explode('|',$thismoudle['strarray']);
								if(count($thismoudlesetting)<>2) {
									echo('<td>');
									htmlinput_error('list',$thismoudle['id']);
								}
								$strarray[$thismoudle['mname']]['cid']=$thismoudlesetting[0];
								$strarray[$thismoudle['mname']]['mname']=$thismoudlesetting[1];
								$thiscid=$strarray[$thismoudle['mname']]['cid'];
								if(!power('s',$thiscid,$power,2)) {
									$strarray[$thismoudle['mname']]['power']=false;
								}else {
									$strarray[$thismoudle['mname']]['power']=true;
								}
								$thischannel=adminchannelcache($thiscid);
								if($thischannel) {
									$strarray[$thismoudle['mname']]['tablename']=$thischannel['csetting']['articletable'];
								}else {
									echo('<td>');
									htmlinput_error('list',$thismoudle['id']);
								}
							}else {
								$thiscid=$strarray[$thismoudle['mname']]['cid'];
							}
							echo('<td align="center">');
							$thisstrarray=json_decode(@$article[$thismoudle['mname']],1);
							if(is_array($thisstrarray) && count($thisstrarray)>0) {
								foreach($thisstrarray as $thisvalue) {
									if(!isset($strarray[$thismoudle['mname']]['list'][$thisvalue])) {
										$query = $GLOBALS['db'] -> query("SELECT id,".$strarray[$thismoudle['mname']]['mname']." FROM ".$strarray[$thismoudle['mname']]['tablename']." where id='$thisvalue' limit 1;");
										if($thislink = $GLOBALS['db'] -> fetchone($query)) {
											if(empty($thislink[$strarray[$thismoudle['mname']]['mname']])) {
												$thislink[$strarray[$thismoudle['mname']]['mname']]='无标题';
											}
											$strarray[$thismoudle['mname']]['list'][$thisvalue]=$thislink[$strarray[$thismoudle['mname']]['mname']].'<br>';
										}else {
											$strarray[$thismoudle['mname']]['list'][$thisvalue]='<em class="warning">已删除</em><br>';
										}
										
									}
									if($strarray[$thismoudle['mname']]['power']) {
										echo('<span class="allarticleschose_adminlist"><a href="?do=list_edit&cid='.$thiscid.'&id='.$thisvalue.'" target="_blank">'.$strarray[$thismoudle['mname']]['list'][$thisvalue].'</a></span>');
									}else {
										echo($strarray[$thismoudle['mname']]['list'][$thisvalue]);
									}
								}
							}
							echo('</td>');
						}elseif($thismoudle['mkind']==27){
							echo('<td align="center">');
							$thisstrarray=json_decode(@$article[$thismoudle['mname']],1);
							if(count($thisstrarray)>0) {
								foreach($thisstrarray as $thisvalue) {
									$thisstrarrayset=array();
									$thisstrarrayset['cid']=$thisvalue[0];
									$thisstrarrayset['column']='id,title';
									$thisstrarrayset['where']['id']=$thisvalue[1];
									$thisstrarrayarticle=a($thisstrarrayset);
									if($thisstrarrayarticle) {
										if(empty($thisstrarrayarticle['title'])) {
											$thisstrarrayarticle['title']='无标题';
										}
										echo('<span class="allarticleschose_adminlist"><a href="?do=list_edit&cid='.$thisvalue[0].'&id='.$thisvalue[1].'" target="_blank">'.$thisstrarrayarticle['title'].'</a></span>');
									}else {
										echo('<span class="allarticleschose_adminlist"><em class="warning">已删除</em></span>');
									}
								}
							}
							echo('</td>');
						}
						elseif($thismoudle['mkind']==16)
						{
							echo('<td width="150px" align="center" style="color:'.$article[$thismoudle['mname']].'">'.$article[$thismoudle['mname']].'</td>');
						}elseif($thismoudle['mkind']==18 || $thismoudle['mkind']==19) {
							$thisarray=json_decode($article[$thismoudle['mname']],1);
							echo('<td align="center">');
							if(is_array($thisarray)) {
								echo(implode(";",$thisarray));
							}
							echo('</td>');
						}elseif($thismoudle['mkind']==11 ||$thismoudle['mkind']==12 || $thismoudle['mkind']==14 || $thismoudle['mkind']==8  || $thismoudle['mkind']==17)
						{
							if(!isset($strarray[$thismoudle['mname']])) {
								$thismoudlesetting=explode('|',$thismoudle['strarray']);
								if(count($thismoudlesetting)<>2) {
									echo('<td>');
									htmlinput_error('list',$thismoudle['id']);
								}
								$strarray[$thismoudle['mname']]['cid']=$thismoudlesetting[0];
								$strarray[$thismoudle['mname']]['mname']=$thismoudlesetting[1];
								$thiscid=$strarray[$thismoudle['mname']]['cid'];
								$thischannel=adminchannelcache($thiscid);
								if($thischannel) {
									$strarray[$thismoudle['mname']]['tablename']=$thischannel['csetting']['articletable'];
								}else {
									echo('<td>');
									htmlinput_error('list',$thismoudle['id']);
								}
							}

							$article[$thismoudle['mname']]=intval($article[$thismoudle['mname']]);
							$thisfid=0;
							if(empty($article[$thismoudle['mname']])) {
								$article[$thismoudle['mname']]='未选';
							}else {
								if(isset($strarray[$thismoudle['mname']]['list'][$article[$thismoudle['mname']]])) {
									$thisfid=$article[$thismoudle['mname']];
									$article[$thismoudle['mname']]=$strarray[$thismoudle['mname']]['list'][$article[$thismoudle['mname']]];
								}else {
									$query = $GLOBALS['db'] -> one("SELECT id,".$strarray[$thismoudle['mname']]['mname']." FROM ".$strarray[$thismoudle['mname']]['tablename']." where id='".$article[$thismoudle['mname']]."' limit 1;");
									if($query) {
										$strarray[$thismoudle['mname']]['list'][$article[$thismoudle['mname']]]=$query[$strarray[$thismoudle['mname']]['mname']];
										$thisfid=$article[$thismoudle['mname']];
										$article[$thismoudle['mname']]=$query[$strarray[$thismoudle['mname']]['mname']];
									}else {
										$article[$thismoudle['mname']]='<em class="warning">已删除</em>';
										$strarray[$thismoudle['mname']]['list'][$article[$thismoudle['mname']]]=$article[$thismoudle['mname']];
									}
								}
							}
							if($thisfid>0) {
								echo('<td width="150px" align="center"><a href="?do=list&cid='.$cid.'&fid='.$thisfid.'&moudleid='.$thismoudle['mname'].'">'.$article[$thismoudle['mname']].'</a></td>');
							}else {
								echo('<td width="150px" align="center">'.$article[$thismoudle['mname']].'</td>');
							}
							
						}
						elseif($thismoudle['mkind']==10 || $thismoudle['mkind']==15)
						{//复选框
							if(!isset($strarray[$thismoudle['mname']])) {
								$thismoudlesetting=explode('|',$thismoudle['strarray']);
								if(count($thismoudlesetting)<>2) {
									echo('<td>');
									htmlinput_error('list',$thismoudle['id']);
								}
								$strarray[$thismoudle['mname']]['cid']=$thismoudlesetting[0];
								$strarray[$thismoudle['mname']]['mname']=$thismoudlesetting[1];
								$thiscid=$strarray[$thismoudle['mname']]['cid'];
								$thischannel=adminchannelcache($thiscid);
								if($thischannel) {
									$strarray[$thismoudle['mname']]['tablename']=$thischannel['csetting']['articletable'];
								}else {
									echo('<td>');
									htmlinput_error('list',$thismoudle['id']);
								}
							}
							echo('<td align="center" >');
							$inputvalues=json_decode(@$article[$thismoudle['mname']],1);
							if(count($inputvalues)>0) {
								foreach($inputvalues as $val) {
									$val=intval($val);
									if(isset($strarray[$thismoudle['mname']]['list'][$val])) {
										echo($strarray[$thismoudle['mname']]['list'][$val].'<br>');
									}else {
										$query = $GLOBALS['db'] -> one("SELECT id,".$strarray[$thismoudle['mname']]['mname']." FROM ".$strarray[$thismoudle['mname']]['tablename']." where id='$val' limit 1;");
										if($query) {
											$strarray[$thismoudle['mname']]['list'][$val]=$query[$strarray[$thismoudle['mname']]['mname']];
											echo($query[$strarray[$thismoudle['mname']]['mname']].'<br>');
										}
									}
								}
							}
							echo('</td>');
						}elseif($thismoudle['mkind']==1){
							echo('<td align="center" >'.@($article[$thismoudle['mname']]).'</td>');
						}elseif($thismoudle['mkind']==28){
							if(is_numeric(@$article[$thismoudle['mname']]) && @$article[$thismoudle['mname']]>0) {
								$thischannel=adminchannelcache($article[$thismoudle['mname']]);
								if($thischannel) {
									$article[$thismoudle['mname']]=$thischannel['cname'];
								}
							}elseif($article[$thismoudle['mname']]==0)
							 {
								$article[$thismoudle['mname']]='未选';
							}
							echo('<td align="center" >'.($article[$thismoudle['mname']]).'</td>');
						}elseif($thismoudle['mkind']==29){
							$thisvalues=json_decode(@$article[$thismoudle['mname']],1);
							echo('<td align="center" >');
							if(count($thisvalues)>0) {
								foreach($thisvalues as $key=>$val) {
									$thischannel=adminchannelcache($val);
									if($thischannel) {
										echo($thischannel['cname'].'<br>');
									}
								}
								
							}else {
								echo('未选');
							}
							echo('</td>');
						}elseif($thismoudle['mkind']==30){
							echo('<td align="center" >');
								$functionname=$thismoudle['strarray'];
								if(function_exists($functionname)) {
									$showvalue=$functionname('show',$thismoudle['mname'],@$article[$thismoudle['mname']]);
									if($showvalue) {
										echo($showvalue);
									}else {
										echo(@htmlspecialchars($article[$thismoudle['mname']]));
									}
								}else {
									echo(@htmlspecialchars($article[$thismoudle['mname']]));
								}
							echo('</td>');
						}else {
							echo('<td align="center" >'.@htmlspecialchars($article[$thismoudle['mname']]).'</td>');
						}
					}
				}	
				?>
				<?php
				if(isset($csetting['listfidshow']) && $csetting['listfidshow']==1) {
					echo('<td  align="center"><a href="?do=list&cid='.$cid.$articletableuri.$articleschooseuri.'&fid='.$article['id'].'&moudleid=fid">查看</a></td>');
				}
				?>
				<?php
				if(isset($csetting['listshowadminname']) && $csetting['listshowadminname']==1) {
					echo('<td width="100" align="center">');
					if(isset($article['adminuid'])) {
						if(!isset($strarray['adminuid'][$article['adminuid']])) {
							$strarray['adminuid'][$article['adminuid']]= $GLOBALS['db'] -> fetchcount("SELECT nickname FROM ".tableex('admin')." where id='".$article['adminuid']."';");
						}
						if(!$strarray['adminuid'][$article['adminuid']]) {
							$strarray['adminuid'][$article['adminuid']]='未知';
						}
						echo(htmlspecialchars($strarray['adminuid'][$article['adminuid']]));
					}else {
						echo('无');
					}
					echo('</td>');
				}
				?>
			<td align="center" class="nocolor admin_list_action_td"><?php
				if(isset($articlechoose)) {
					$targetid=@$article['id'];
					$targettitle=@$article[$articlemname];
					echo('<a href="javascript:;"onclick="articlechoose(\''.$articlechoose.'\',\''.$targetid.'\',\''.$targettitle.'\');" style="color:#0000FF" class="articlechoosetip" rel="'.$targetid.'">选择</a> &nbsp;');
				}
				if(isset($articleschoose)) {
					$targetid=@$article['id'];
					$targettitle=@$article[$articlemname];
					echo('<a href="javascript:;"onclick="this.style.color=\'#ccc\';articleschoose(\''.$articleschoose.'\',\''.$targetid.'\',\''.$targettitle.'\');" class="articleschoosetip" style="color:#0000FF" rel="'.$targetid.'">选择</a> &nbsp;');
				}
				if(isset($allarticleschoose)) {
					$targetid=@$article['id'];
					$targettitle=@$article[$articlemname];
					echo('<a href="javascript:;"onclick="this.style.color=\'#ccc\';allarticleschoose(\''.$allarticleschoose.'\',\''.$targetid.'\',\''.$targettitle.'\');" class="allarticleschoosetip" style="color:#0000FF" rel="'.$targetid.'_'.$cid.'">选择</a> &nbsp;');
				}
				run_admin_hook($cid,'listrowaction');
				if((!isset($csetting['listnoedit']) || $csetting['listnoedit']==0) && power('s',$cid,$power,2)) {
					echo('<a href="?do=list_edit&id='.$article['id'].'&cid='.$cid.$articletableuri.$articleschooseuri.$moudleiduri.'">编辑</a> &nbsp;&nbsp;');
				}
				if((!isset($csetting['listnoadd']) || $csetting['listnoadd']==0) && power('s',$cid,$power,1)) {
					if(isset($csetting['listcopy']) && $csetting['listcopy']==1) {
						echo('<a href="?do=list_add&cid='.$cid.'&id='.$article['id'].$articletableuri.$articleschooseuri.$moudleiduri.'"><em>复制</em></a>&nbsp;&nbsp;');
					}
				}
				if((!isset($csetting['listnodel']) || $csetting['listnodel']==0) && power('s',$cid,$power,3)) {
					echo('<a href="javascript:;" onclick="javascript:confirmurl(\'?do=list_del&'.newtoken(3).'&id='.$article['id'].$articletableuri.'&cid='.$cid.'\',\'确定删除此条信息吗？\');">删除</a>');
				}
			?></td>
		</tr>
				<?php
unset($article);
			}
		 ?>
		</table>
	<div class="action">
		已选 <a class="chose_article_count">&nbsp;&nbsp;0&nbsp;&nbsp;</a> 项
		<a href="javascript:select_article('all')">全选</a>
		<a href="javascript:select_article('no')">反选</a> 
	<?php
		if((!isset($csetting['listnoedit']) || $csetting['listnoedit']==0) && isset($csetting['listarticlemove']) && $csetting['listarticlemove']==1 && power('s',$cid,$power,2)) {
	?>
		<a href="javascript:;" class="articleMove" rel=0>转移文章</a>
		<select id="aritclemovechannel" rel=0>
			<option value="0" selected>栏目载入中</option>
		</select>
	<?php
		}
	?>

	<?php
		run_admin_hook($cid,'listaction');
	?>

    <?php
		if((!isset($csetting['listnodel']) || $csetting['listnodel']==0) && power('s',$cid,$power,3)) {
	?>
			<a href="javascript:select_article_submit('?do=list_del<?php echo($articletableuri);?>&<?php echo(newtoken(2));?>&cid=<?php echo($cid);?>','确认删除?')">删除</a>
	<?php
		}
	?>
	</div>

	<div class="pager">
	总计 <?php echo($articles['pagecount']);?> 个记录，
	每页 <input type="text" name="pagesize" id="pagesize" value="<?php echo($where['pagesize']);?>" autocomplete="off"> 条
	当前第 <?php echo($articles['page']);?> 页 |
	<?php
	$pageurl='?page={page}';
	foreach($_GET as $key=>$val) {
		if($key<>'page') {
			$pageurl.='&'.$key.'='.urlencode($val);
		}
	}
	adminpagelist($articles['pagecount'],$articles['pagesize'],$articles['page'],3,$pageurl);
	?>
</div>
    </form>
    </div>
</div>
</div>
<script type="text/javascript">
list_chose_article();
$(function(){
	if ($(".admin_list_action_td:last").html().length<10)
	{
		$(".admin_list_action_td").hide();
	}
	$('#pagesize').change(function(){
		setCookie('pagesize_<?php echo($cid);?>',$(this).val());
	});
	$('#pagesize').keydown(function(event){
		if(event.which == 13){
			setCookie('pagesize_<?php echo($cid);?>',$(this).val());
			window.location.reload();
		}
	});
	<?php
		if((!isset($csetting['listnoedit']) || $csetting['listnoedit']==0) && isset($csetting['listarticlemove']) && $csetting['listarticlemove']==1 && power('s',$cid,$power,2)) {
	?>
	$('.articleMove').click(function(){
		if ($(this).attr("rel")==0)
		{
			$('#aritclemovechannel').show();
			$(this).text("取消转移");
			if ($('#aritclemovechannel').attr("rel")==0)
			{
				$.post("ajax.php?do=aritclemovechannel",
				{
					cid:<?php echo($cid);?>
				},
				function(data,httpstatus){
					$('#aritclemovechannel').html(data);
					$('#aritclemovechannel').attr("rel",1);
				});
			}
			$(this).attr("rel",1);
		}else{
			$('#aritclemovechannel').hide();
			$(this).attr("rel",0);
			$(this).text("转移文章");
		}
	});
	$('#aritclemovechannel').change(function(){
		if ($(this).val()>0 && $(this).val()!=<?php echo($cid);?>)
		{
			a=select_article_submit('?do=list_move&cid=<?php echo($cid);?>&targetcid='+$(this).val()+'&<?php echo($articletableuri);?>&<?php echo(newtoken(2));?>','转移选中的文章至目标栏目?');
			if (a==false)
			{
				$('.articleMove').click();
				$('#aritclemovechannel').attr("rel",0).html('<option value="0" selected>栏目载入中</option>');
			}
		}
	});
<?php
	}
?>
});
</script>
<?php
if(isset($listcheckboxchange) && $listcheckboxchange) {
?>
<script type="text/javascript">
$(function(){
	$('.listcheckboxchange').change(function(){
		$(this).parent().find('img').remove();
		$(this).parent().append("<img src='img/loading.gif' width='12px'  height='12px'>");
		var cid=$(this).attr('cid');
		var field=$(this).attr('rel');
		var articleid=$(this).attr('articleid');
		if ($(this).prop('checked'))
		{
			var status=1;
		}else{
			var status=0;
		}
		$.post("ajax.php?do=listcheckboxchange",
		  {
			cid:cid,
			field:field,
			articletable:'<?php echo($articletable);?>',
			articleid:articleid,
			status:status
		  },
		  function(data,httpstatus){
			$("#listcheckboxchange"+field+articleid).parent().find('img').remove();
			if (data.length>3)
			{
				if (status==1)
				{
					$("#listcheckboxchange"+field+articleid).prop('checked',false);
				}else{
					$("#listcheckboxchange"+field+articleid).prop('checked',true);
				}
				alert(data);
			}
		  });

	});
});
</script>
<?php
}
?>
<?php
if(isset($articlechoose)) {
?>
<script type="text/javascript">
function articlechoose(htmlid,id,title){
	$('[name="'+htmlid+'"]',window.opener.document).val(id);
	$('#'+htmlid,window.opener.document).html('<a href="?do=list_edit&id='+id+'&cid=<?php echo($cid);?>&articlechoose=<?php echo($articlechoose);?>&articlemname=<?php echo($articlemname);?>" target="_blank">'+title+'</a><span></span>');
	window.close();
}
$(function(){
	<?php echo($articlechoose);?>_chosed=$('[name="<?php echo($articlechoose);?>"]',window.opener.document).val();
	$("#list .articlechoosetip[rel='"+<?php echo($articlechoose);?>_chosed+"']").text('已选');
	$("#list .articlechoosetip[rel='"+<?php echo($articlechoose);?>_chosed+"']").css('color','#ccc');
});
</script>
<?php
}
if(isset($articleschoose)) {
?>
<script type="text/javascript">
function articleschoose(htmlid,id,title){
	var ifin=0;

	$('#'+htmlid+' li',window.opener.document).each(function(){
		if (id==$(this).children('input').val())
		{
			ifin=1;
		}
	});
	if (ifin==0)
	{
		$('#'+htmlid,window.opener.document).append('<li><a href="?do=list_edit&id='+id+'&cid=<?php echo($cid);?>&articleschoose=<?php echo($articleschoose);?>&articlemname=<?php echo($articlemname);?>" target="_blank">'+title+'</a><div class="articleschose_action"><p class="up"></p><p class="down"></p><p class="del"></p></div><input type="hidden" name="'+htmlid+'[]" value="'+id+'"></li>');
	}
}
$(function(){
	$('#<?php echo($articleschoose);?> li',window.opener.document).each(function(){
		thisvar=$(this).children('input').val();
		$("#list .articleschoosetip[rel='"+thisvar+"']").text('已选');
		$("#list .articleschoosetip[rel='"+thisvar+"']").css('color','#ccc');
	});
});
</script>
<?php
}
?>
<?php
if(isset($allarticleschoose)) {
?>
<script type="text/javascript">
function allarticleschoose(htmlid,id,title){
	var ifin=0;
	$('#allarticleschose_'+htmlid+'_list li',window.opener.document).each(function(){
		if (id==$(this).children('a').attr('rel') && <?php echo($cid);?>==$(this).children('a').attr('rev'))
		{
			ifin=1;
		}
	});
	if (ifin==0)
	{
		$('#allarticleschose_'+htmlid+'_list',window.opener.document).append('<li><a rel="'+id+'" rev="<?php echo($cid);?>" href="?do=list_edit&id='+id+'&cid=<?php echo($cid);?>&allarticleschoose='+htmlid+'&articlemname=<?php echo($articlemname);?>" target="_blank">'+title+'</a><div class="articleschose_action"><p class="up"></p><p class="down"></p><p class="del"></p></div><input type="hidden" name="'+htmlid+'[]" value="'+id+'"><input type="hidden" name="'+htmlid+'-channel[]" value="<?php echo($cid);?>"></li>');
	}
}
$(function(){
	$('#allarticleschose_<?php echo($allarticleschoose);?>_list li',window.opener.document).each(function(){
		thisvar=$(this).children('a').attr('rel');
		$("#list .allarticleschoosetip[rel='"+thisvar+"_<?php echo($cid);?>']").text('已选');
		$("#list .allarticleschoosetip[rel='"+thisvar+"_<?php echo($cid);?>']").css('color','#ccc');
	});
});
</script>
<?php
}
?>