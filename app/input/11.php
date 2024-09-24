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
$thisselected=false;
echo('<select name="'.$inputname.'">');
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
		if($value['id']==$inputvalue) {
			$thisselected=true;
			echo('<option value="'.$value['id'].'" selected>'.$value[$mname].'</option>');
		}else {
			echo('<option value="'.$value['id'].'">'.$value[$mname].'</option>');
		}
	}
}else {echo('</select>');htmlinput_error($inputarray['from'],$inputarray['id']);}
if($thisselected==false) {
	echo('<option value="0" selected>未选</option>');
}else {
	echo('<option value="0">未选</option>');
}
echo('</select>');
?>