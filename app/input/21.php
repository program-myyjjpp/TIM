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
}else {
	htmlinput_error($inputarray['from'],$inputarray['id']);
}
if($inputvalue>0) {
	$query = $GLOBALS['db'] -> query("SELECT id,$mname FROM $thisarticletable where id='$inputvalue' limit 1;");
	if($link = $GLOBALS['db'] -> fetchone($query)) {
		if(empty($link[$mname])) {
			$link[$mname]='无标题';
		}
		echo('<span id="'.$inputname.'" class="articlechoose"><a href="?do=list_edit&id='.$link['id'].'&cid='.$cid.'" target="_blank">'.$link[$mname].'</a><span></span></span>');
	}else {
		$inputvalue='';
		echo('<span id="'.$inputname.'" class="articlechoose"></span>');
	}
}else {
	echo('<span id="'.$inputname.'" class="articlechoose"></span>');
}
?>
<input type="hidden" name="<?php echo($inputname);?>" value="<?php echo($inputvalue);?>">
<input type="button" id="<?php echo($inputname);?>_articlechoose"  value="选择" style="margin-left:20px;width:55px;height:25px;font-size:12px">
<script type="text/javascript">
	$(document).ready(function(){
		$("#<?php echo($inputname);?>_articlechoose").click(function(){
			window.open("?do=list&cid=<?php echo($cid);?>&articlechoose=<?php echo($inputname);?>&articlemname=<?php echo($mname);?>");
		})
		$("#<?php echo($inputname);?>").on('click','span',function(){
			$(this).parent("span").html(''); 
			$('[name="<?php echo($inputname);?>"]').val('');
		})
	});
</script>