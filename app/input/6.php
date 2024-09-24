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


preg_match_all('|(\d+)\*(\d+)|',$pictips,$picvalue);
if(isset($picvalue[1][0]) && isset($picvalue[2][0])) {
	$pictips=$picvalue[1][0].'_'.$picvalue[2][0];
}else {
	$pictips='';
}
$sbie=0;
if(isset($_SERVER['HTTP_USER_AGENT']) && (stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 5') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 6') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 7') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 8') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 9') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 10'))) {
	$sbie=1;
}
?> 
<input type="hidden" name="<?php echo($inputname);?>[]" value="ucms">
<input type="hidden" name="pics_multiple_upload_<?php echo($inputname);?>" id="pics_multiple_upload_<?php echo($inputname);?>" value="">
<span style="display:none"><span id="picseditor_<?php echo($inputname);?>"></span></span>
<span id="<?php echo($inputname);?>_piclist" class="piclist">
<?php
$pics=json_decode($inputvalue,1);
if(is_array($pics)) {
	foreach ($pics as $value) 
	{    
	echo('<li><a href="'.($value).'" target="_blank"><img src="'.($value).'" class="vt img"></a><div><span class="del"  onclick="picdel(this)"></span><input type="hidden" name="'.$inputname.'[]" value="'.($value).'"></div></li>');
	}
}
?>
</span>
<?php
if($sbie) {
?>
	<iframe id="<?php echo($inputname);?>_iframe" name="<?php echo($inputname);?>_iframe" src="upload.php?inputname=pics_multiple_upload_<?php echo($inputname);?>&picsize=<?php echo($pictips);?>" class="uploadfileiframe" style="width:170px" border=0  frameborder=0></iframe>
<?php
}else{
?>
	<iframe id="<?php echo($inputname);?>_iframe" name="<?php echo($inputname);?>_iframe" src="upload.php?inputname=pics_multiple_upload_<?php echo($inputname);?>&picsize=<?php echo($pictips);?>" class="uploadfileiframe" border=0  frameborder=0></iframe>
<?php
}
?>
<script type="text/javascript">
$(function(){
	$('#<?php echo($inputname);?>_piclist').on('mouseenter','li',function(){
		$(this).append("<span class='piclistprev piclistchange' onclick=\"picmoveup(this)\"></span><span onclick=\"picmovenext(this)\" class='piclistnext piclistchange'></span>");
	});
	$('#<?php echo($inputname);?>_piclist').on('mouseleave','li',function(){
		$(this).find("span.piclistchange").remove();
	});
	
	$("#pics_multiple_upload_<?php echo($inputname);?>").on('click',function(e){
		$("#<?php echo($inputname);?>_piclist").append('<li><a href="' + $(this).val() + '" target="_blank"><img src="' + $(this).val() + '" class="vt img"></a><div><span class="del" onclick="picdel(this)"></span><input type="hidden" name="<?php echo($inputname);?>[]" value="'+ $(this).val() +'"></div></li>');
	}); 

});
</script>