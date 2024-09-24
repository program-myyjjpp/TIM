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


if(count($strarray)!=2) {htmlinput_error($inputarray['from'],$inputarray['id']);}
$cid=$strarray[0];
$mname=$strarray[1];
$channel=adminchannelcache($cid);
if($channel) {
	$thisarticletable=$channel['csetting']['articletable'];
	$thisorder=$channel['csetting']['temppage_order'];
}else {htmlinput_error($inputarray['from'],$inputarray['id']);}
//值为空的时候
if(empty($inputvalue)) {
	$inputvalue=0;
	//取出最小fid
	echo('<span id="'.$inputname.'_ajax">');
	echo('<select name="">');
	echo('<option value="0">无</option>');
	$query = $GLOBALS['db'] -> query("SELECT id,$mname,fid FROM $thisarticletable where cid='$cid' and fid=0 $thisorder limit 10000;");
	$strarray = $GLOBALS['db'] -> fetchall($query);
	foreach ($strarray as $value){
			echo('<option value="'.$value['id'].'">'.$value[$mname].'</option>');
	}
	echo('</select>');
	echo('<input type="hidden" name="'.$inputname.'" value="'.$inputvalue.'">');
	echo('</span>');
}else {
	echo('<span id="'.$inputname.'_ajax">');
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
			$query = $GLOBALS['db'] -> query("SELECT id,$mname,fid FROM $thisarticletable where cid='$cid' and fid='$inputvalue' $thisorder limit 10000;");
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
		$query = $GLOBALS['db'] -> query("SELECT id,$mname,fid FROM $thisarticletable where cid='$cid' and fid='$upfid' $thisorder limit 10000;");
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
	echo('<input type="hidden" name="'.$inputname.'" value="'.$inputvalue.'">');
	echo('</span>');
}
?>

<script language="javascript" type="text/javascript">
$(document).ready(function(){
    $("#<?php echo($inputname);?>_ajax").on('change','select',function(){
		var <?php echo($inputname);?>_thisval=$(this).val();
		$("#<?php echo($inputname);?>_ajax").html('<img src="img/loading.gif">');
		$.post("ajax.php?do=amoudleajaxkind",
		  {
			fid:<?php echo($inputname);?>_thisval,
			inputname:"<?php echo($inputname);?>",
			moudleid:"<?php echo($inputarray['id']);?>",
			from:"<?php echo(@$inputarray['from']);?>",
		  },
		  function(data,status){
			 $("#<?php echo($inputname);?>_ajax").html(data);
		  });
    });
});
</script>