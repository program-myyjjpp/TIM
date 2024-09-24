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


$inputvalues=json_decode($inputvalue,1);
if(count($strarray)!=2) {htmlinput_error($inputarray['from'],$inputarray['id']);}
?>
<input type="hidden" name="<?php echo($inputname);?>[]" value="array">
<?php
$cid=$strarray[0];
$mname=$strarray[1];
$channel=adminchannelcache($cid);
if($channel) {
	$thisarticletable=$channel['csetting']['articletable'];
	$thisorder=$channel['csetting']['temppage_order'];
	$query = $GLOBALS['db'] -> query("SELECT id,$mname FROM $thisarticletable where cid='$cid' $thisorder limit 1000;");
	$strarray = $GLOBALS['db'] -> fetchall($query);
	foreach ($strarray as $value) 
	{    
		if(is_array($inputvalues) && in_array($value[0],$inputvalues)) {
			echo('<label><input name="'.$inputname.'[]" type="checkbox"  value="'.$value['id'].'" checked>'.$value[$mname].'</label>');
	   }else {
			echo('<label><input name="'.$inputname.'[]" type="checkbox"  value="'.$value['id'].'">'.$value[$mname].'</label>');
	   }
	}
}else {htmlinput_error($inputarray['from'],$inputarray['id']);}
?>