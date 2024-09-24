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
	$query = $GLOBALS['db'] -> query("SELECT id,$mname,fid FROM $thisarticletable where cid='$cid' $thisorder limit 3000;");
	$strarray = $GLOBALS['db'] -> fetchall($query);
	echo('<SELECT id="'.$inputname.'" name="'.$inputname.'">');
	echo('<OPTION VALUE="0">├无</OPTION>');
	treeselect($strarray,$inputvalue);
	echo('</SELECT>');
}else {htmlinput_error($inputarray['from'],$inputarray['id']);}