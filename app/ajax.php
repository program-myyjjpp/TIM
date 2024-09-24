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

?>
<?php require('../config/database.php');?>
<?php require('chk.php');?>
<?php
if(!isset($_GET['do'])) {
	die();
}

if($_GET['do']=='amoudleselect') {
	if(!isset($_POST['moudleid'])) {echo('no moudleid error');die();}
	if(!isset($_POST['from'])) {echo('no from error');die();}
	$moudleid=intval($_POST['moudleid']);
	if($_POST['from']=='str') {
		$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('str')." where id='$moudleid';");
	}else {
		$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('moudle')." where id='$moudleid';");
	}
	$link = $GLOBALS['db'] -> fetchone($query);
	if(!$link) {
		die('error');
	}else {
		//权限判断
		if($_POST['from']=='str') {
			$thiscid=$link['strcid'];
			if(!power('s',$thiscid,$power)) {
				die('error');
			}
			if($link['ifadmin']==1 && !power('s',$thiscid,$power,5)) {
				die('error');
			}
			if($thiscid>0 && !power('s',$thiscid,$power,4)) {
				 die('error');
			}
		}else {
			$thiscid=$link['cid'];
			if(!power('s',$thiscid,$power)) {
				die('error');
			}
			if($link['ifadmin']==1) {//管理员字段
				if(!power('s',$thiscid,$power,5)) {
					die('error');
				}
			}
		}
	}
	$strarray=explode('|',$link['strarray']);
	$cid=$strarray[0];
	$mname=$strarray[1];
	$channel=adminchannelcache($cid);
	if($channel) {
		$thisarticletable=$channel['csetting']['articletable'];
		$thisorder=$channel['csetting']['temppage_order'];
	}else {die('数据来源栏目不存在');}

	echo('<script language="javascript" type="text/javascript">');
		$keyword=dbstr($_POST['keyword']);
		$query = $GLOBALS['db'] -> query("SELECT id,$mname FROM $thisarticletable where cid='$cid' and $mname like '%$keyword%' $thisorder limit 100;");
		$link = $GLOBALS['db'] -> fetchall($query);
		$thisarray=array();
		foreach ($link as $value) {
			if($value[$mname]==$_POST['keyword']) {
			?>
				$("#<?php echo($_POST['name']);?>").append( "<option value=\"<?php echo($value['id']);?>\" selected=\"true\"><?php echo($value[$mname]);?></option>" );
			<?php
			}else {
			?>
				$("#<?php echo($_POST['name']);?>").append( "<option value=\"<?php echo($value['id']);?>\"><?php echo($value[$mname]);?></option>" );
			<?php
			}
		}
		?>
		<?php
		echo('</script>');
}
if($_GET['do']=='amoudlecheckbox') {
	if(!isset($_POST['moudleid'])) {echo('no moudleid error');die();}
	if(!isset($_POST['from'])) {echo('no from error');die();}
	$moudleid=intval($_POST['moudleid']);
	if($_POST['from']=='str') {
		$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('str')." where id='$moudleid';");
	}else {
		$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('moudle')." where id='$moudleid';");
	}
	$link = $GLOBALS['db'] -> fetchone($query);
	if(!$link) {
		die('error');
	}else {
		//权限判断
		if($_POST['from']=='str') {
			$thiscid=$link['strcid'];
			if(!power('s',$thiscid,$power)) {
				die('error');
			}
			if($link['ifadmin']==1 && !power('s',$thiscid,$power,5)) {
				die('error');
			}
			if($thiscid>0 && !power('s',$thiscid,$power,4)) {
				 die('error');
			}
		}else {
			$thiscid=$link['cid'];
			if(!power('s',$thiscid,$power)) {
				die('error');
			}
			if($link['ifadmin']==1) {//管理员字段
				if(!power('s',$thiscid,$power,5)) {
					die('error');
				}
			}
		}
	}
	$strarray=explode('|',$link['strarray']);
	$cid=$strarray[0];
	$mname=$strarray[1];
	$channel=adminchannelcache($cid);
	if($channel) {
		$thisarticletable=$channel['csetting']['articletable'];
		$thisorder=$channel['csetting']['temppage_order'];
	}else {die('数据来源栏目不存在');}

	$keyword=dbstr($_POST['keyword']);
	$query = $GLOBALS['db'] -> query("SELECT id,$mname FROM $thisarticletable where cid='$cid' and $mname like '%$keyword%' $thisorder limit 100;");
	$link = $GLOBALS['db'] -> fetchall($query);
	$thisarray=array();
	foreach ($link as $value) {
		echo('<label><input type="checkbox" value="'.$value['id'].'" name="'.$_POST['name'].'[]">'.$value[$mname].'</label>'."\r\n");
	}

}
if($_GET['do']=='amoudleajaxkind') {
	if(!isset($_POST['moudleid'])) {
		die('no moudleid error');
	}
	$moudleid=intval($_POST['moudleid']);
	if($_POST['from']=='str') {
		$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('str')." where id='$moudleid';");
	}else {
		$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('moudle')." where id='$moudleid';");
	}
	$link = $GLOBALS['db'] -> fetchone($query);
	if(!$link) {
		die('error');
	}else {
		//权限判断
		if($_POST['from']=='str') {
			$thiscid=$link['strcid'];
			if(!power('s',$thiscid,$power)) {
				die('error');
			}
			if($link['ifadmin']==1 && !power('s',$thiscid,$power,5)) {
				die('error');
			}
			if($thiscid>0 && !power('s',$thiscid,$power,4)) {
				 die('error');
			}
		}else {
			$thiscid=$link['cid'];
			if(!power('s',$thiscid,$power)) {
				die('error');
			}
			if($link['ifadmin']==1) {//管理员字段
				if(!power('s',$thiscid,$power,5)) {
					die('error');
				}
			}
		}
	}
	$strarray=explode('|',$link['strarray']);
	$cid=$strarray[0];
	$mname=$strarray[1];
	$channel=adminchannelcache($cid);
	if($channel) {
		$thisarticletable=$channel['csetting']['articletable'];
		$thisorder=$channel['csetting']['temppage_order'];
	}else {die('数据来源栏目不存在');}
	$inputvalue=intval($_POST['fid']);
	$selectstr='';
	$iflive=$GLOBALS['db'] -> fetchcount("SELECT id FROM $thisarticletable where cid='$cid' and id='$inputvalue' limit 1;");//判断是否存在
	if($iflive) {}else {
		$inputvalue=0;
	}
	$fid=$GLOBALS['db'] -> fetchcount("SELECT fid FROM $thisarticletable where cid='$cid' and id='$inputvalue' limit 1;");
	if($fid) {}else {
		$fid=0;
	}
	if($inputvalue>0) {
		$ifson=$GLOBALS['db'] -> fetchcount("SELECT count(id) FROM $thisarticletable where cid='$cid' and fid='$inputvalue' limit 1;");//判断该id下是否有子分类
		if($ifson>0) {
			$selectstr.='<select name=""><option value="'.$inputvalue.'" selected>无</option>'."\r\n";
			$query = $GLOBALS['db'] -> query("SELECT id,$mname,fid FROM $thisarticletable where cid='$cid' and fid='$inputvalue' $thisorder limit 3000;");
			$strarray = $GLOBALS['db'] -> fetchall($query);
			foreach ($strarray as $value) 
			{
					$selectstr.='<option value="'.$value['id'].'">'.$value[$mname].'</option>'."\r\n";
			}
			$selectstr.='</select>'."\r\n";
		}
	}
	$times=1;
	$thisselectstr='';
	$upfid=$fid;
	$oldfid=$inputvalue;
	while($times<20) {
		$times++;
		if($upfid===null) {
			break;
		}
		$thisselectstr='<select name=""><option value="'.$upfid.'">无</option>'."\r\n";
		$query = $GLOBALS['db'] -> query("SELECT id,$mname,fid FROM $thisarticletable where cid='$cid' and fid='$upfid' $thisorder limit 3000;");
		$strarray = $GLOBALS['db'] -> fetchall($query);
		if(count($strarray)==0) {
			break;
		}
		foreach ($strarray as $value) 
		{
			if($value['id']==$oldfid) {
				$thisselectstr.='<option value="'.$value['id'].'" selected>'.$value[$mname].'</option>'."\r\n";
			}else {
				$thisselectstr.='<option value="'.$value['id'].'">'.$value[$mname].'</option>'."\r\n";
			}
		}
		$thisselectstr.='</select>'."\r\n";
		$selectstr=$thisselectstr.$selectstr;
		$oldfid=$upfid;
		$upfid=$GLOBALS['db'] -> fetchcount("SELECT fid FROM $thisarticletable where cid='$cid' and id='$upfid' limit 1;");
	}
	echo($selectstr);
	echo('<input type="hidden" name="'.$_POST['inputname'].'" value="'.$inputvalue.'">');
}
if($_GET['do']=='strarraylist') {
	if(power('alevel')!=3) {die('error');}
	$cid=intval($_POST['cid']);
	if(empty($_POST['strdefault'])) {
		$_POST['strdefault']='title';
	}
	$select=0;
	$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('moudle')." where cid='$cid' and hide<>'1' order by morder asc");
	$links = $GLOBALS['db'] -> fetchall($query);
	if(count($links)==0) {
		echo('<option value="">该栏目下无可用字段</option>');
	}
	foreach($links as $link) {
		if($_POST['strdefault']==$link['mname']) {
			echo('<option value="'.$link['mname'].'" selected>'.$link['mname'].'['.$link['minfo'].']</option>');
			$select=1;
		}else {
			echo('<option value="'.$link['mname'].'">'.$link['mname'].'['.$link['minfo'].']</option>');
		}
	}
	if($cid>0 && $select==0 && !empty($_POST['strdefault'])) {
		echo('<option value="'.$_POST['strdefault'].'" selected>'.$_POST['strdefault'].'[字段不存在!]</option>');
	}

}
if($_GET['do']=='listcheckboxchange') {
	$cid=intval($_POST['cid']);
	$articleid=intval($_POST['articleid']);
	$articletable=dbstr($_POST['articletable']);
	$status=intval($_POST['status']);
	$field=dbstr($_POST['field']);
	if(!admintablecheck($articletable)) {die('栏目表名有误');}
	$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('channel')." where cid='$cid' limit 1");
	$link = $GLOBALS['db'] -> fetchone($query);
	if($link['ifshowadmin']==0) {die('channel error');}
	$csetting=json_decode($link['csetting'],1);
	if(isset($csetting['listnoedit']) && $csetting['listnoedit']==1) {die('no edit');}
	if(empty($articletable)) {
		$articletable=$csetting['articletable'];
	}
	if(!power('s',$cid,$power,2)) {die('power error');}
	$delsql='';//如果栏目开通了普通用户只能管理自己的文章
	if(power('sadmin',0) || power('s',$cid,$power,5)) {}else {if(isset($csetting['listadminuid']) && $csetting['listadminuid']==1) {$delsql=" and adminuid='$myadminuid'";}}
	$query = $GLOBALS['db'] -> query("SELECT * FROM $articletable where id='$articleid' and cid='$cid'$delsql limit 1");
	$link = $GLOBALS['db'] -> fetchone($query);
	if(!$link) {die('article not exist');}
	
	if(power('sadmin',0) || power('s',$cid,$power,5)) {$thissql='';}else {$thissql=" and ifadmin<>'1'";}
	$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('moudle')." where hide<>'1' and ifcreated='1' and mname='$field' and cid='$cid'$thissql limit 1");
	$moudle = $GLOBALS['db'] -> fetchone($query);
	if($moudle) {
		$query = $GLOBALS['db'] -> query("UPDATE $articletable SET $field='$status' WHERE id='$articleid' and cid='$cid'");
	}else {
		die('column not exist');
	}
	
}
if($_GET['do']=='aritclemovechannel') {
	$channels  =adminchannelscache();
	$cid=intval($_POST['cid']);
	$thischannel=adminchannel($cid);
	$csetting=json_decode($thischannel['csetting'],1);
	if(!isset($csetting['articletable']) || empty($csetting['articletable']) || $thischannel['ckind']<>2) {
		die();
	}
	$listchannel=channel_select($cid,0,0,0);
	$prevnoshow=0;
	$ifnoshow=0;
	$disabled='';
	$selected='';
	foreach($listchannel as $key=>$val) {
		if($val['ifshowadmin']) {
			if($cid==$val['cid']) {$selected='selected';}else {$selected='';}
			if($val['ckind']==2) {
				if(power('s',$val['cid'],$power)) {
					if(power('s',$val['cid'],$power,1)) {
						$thiscsetting=json_decode($val['csetting'],1);
						if(isset($thiscsetting['articletable']) && $thiscsetting['articletable']==$csetting['articletable']) {
							if(!isset($thiscsetting['listarticlemove']) || $thiscsetting['listarticlemove']==0) {
								$disabled='disabled';
							}else {
								if(isset($targetcsetting['listnoadd']) && $targetcsetting['listnoadd']==1) {
									$disabled='disabled';
								}else {
									$disabled='';
								}
							}
						}else {
							$disabled='disabled';
						}
						$ifnoshow=0;
					}else {
						$disabled='disabled';
					}
				}else {
					if($prevnoshow==0) {
						echo('<option value="0" disabled></option>');
						$prevnoshow=1;
						$ifnoshow=1;
					}
				}
			}else {
				if(power('s',$val['cid'],$power)) {
					$disabled='disabled';
					$ifnoshow=0;
				}else {
					if($prevnoshow==0) {
						echo('<option value="0" disabled></option>');
						$prevnoshow=1;
						$ifnoshow=1;
					}
				}
			}
			if($ifnoshow==0) {
				echo('<option value="'.$val['cid'].'" '.$disabled.' '.$selected.'>'.$val['ext'].''.$val['cname'].'</option>');
				$prevnoshow=0;
			}
		}else {
			if($prevnoshow==0) {
				echo('<option value="0" disabled></option>');
				$prevnoshow=1;
			}
		}
		
	}
}
?>