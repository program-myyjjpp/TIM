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


if(!is_numeric($inputvalue)) {
	$defaulttime=@strtotime($inputvalue);
	if($defaulttime) {
		$inputvalue=date("Y-m-d H:i:s",$defaulttime);
	}else {
		$inputvalue='';
	}
}else {
	if(empty($inputvalue)) {
		$inputvalue='';
	}else {
		$inputvalue=date("Y-m-d H:i:s",$inputvalue);
	}
}
if(empty($style)) {
	$style=' style="width:170px;"';
}
?>
<input<?php echo($style);?> name="<?php echo($inputname);?>" autocomplete="off" id="time_<?php echo($inputname);?>" type="text" value="<?php echo($inputvalue);?>" size="20"  class="inputtext timeinput"/>
<?php
if(isset($_SERVER['HTTP_USER_AGENT'])) {
	if(stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 5') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 6') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 7') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 8') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 9') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 10')) {echo('<!-- ie不支持date -->');}else{
?>
<div id="time_function_<?php echo($inputname);?>" class="time_function">
<p >时期格式不正确,请重新填写</p>
<p >格式 : 2012-12-12 12:12:12</p>
<input type="button" value="现在" rel="1" style="width:60px;height:24px">
<input type="button" value="整点" rel="2" style="width:46px;height:24px">
<input type="button" value="零点" rel="13" style="width:46px;height:24px">
<input type="button" value="加一小时" rel="3" style="width:100px;height:24px;margin-top:5px">
<input type="button" value="(减)" rel="4" style="width:55px;height:24px;margin-top:5px">
<input type="button" value="加一天" rel="5" style="width:100px;height:24px;margin-top:5px">
<input type="button" value="(减)" rel="6" style="width:55px;height:24px;margin-top:5px">
<input type="button" value="加一周" rel="7" style="width:100px;height:24px;margin-top:5px">
<input type="button" value="(减)" rel="8" style="width:55px;height:24px;margin-top:5px">
<input type="button" value="加一月" rel="9" style="width:100px;height:24px;margin-top:5px">
<input type="button" value="(减)" rel="10" style="width:55px;height:24px;margin-top:5px">
<input type="button" value="加一年" rel="11" style="width:100px;height:24px;margin-top:5px">
<input type="button" value="(减)" rel="12" style="width:55px;height:24px;margin-top:5px">
</div>
<script>

$(function(){
	$('#time_<?php echo($inputname);?>').focus(function(){
		var mytop=$(this).offset().top+$(this).height()+10;
		var myleft=$(this).offset().left;
		$('#time_function_<?php echo($inputname);?>').css({"top":mytop,"left":myleft}).show();
	});
	$('#time_<?php echo($inputname);?>').blur(function(){
		$('#time_function_<?php echo($inputname);?>').hide();
		time_<?php echo($inputname);?>_check();
	});
	$('#time_<?php echo($inputname);?>').keyup(function(){
		time_<?php echo($inputname);?>_check();
	});
	$('#time_function_<?php echo($inputname);?>').hover(function(){
		$('#time_<?php echo($inputname);?>').unbind('blur');
	},function(){
		$('#time_function_<?php echo($inputname);?>').hide();
		$('#time_<?php echo($inputname);?>').blur(function(){
			$('#time_function_<?php echo($inputname);?>').hide();
			time_<?php echo($inputname);?>_check();
		});
	});
	$("#time_function_<?php echo($inputname);?> input").click(function(){
		inputdate=time_function_button($(this).attr('rel'),$('#time_<?php echo($inputname);?>').val());
		$('#time_<?php echo($inputname);?>').val(inputdate);
		time_<?php echo($inputname);?>_check();
	});
});
function time_<?php echo($inputname);?>_check(){
	var reg = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/;
	var r = $('#time_<?php echo($inputname);?>').val().match(reg);
	if(r == null){
		$('#time_<?php echo($inputname);?>').css('border-color','red');
		$('#time_function_<?php echo($inputname);?> p').show();
		return false;
	}
	$('#time_function_<?php echo($inputname);?> p').hide();
	$('#time_<?php echo($inputname);?>').css('border-color','#DBDBDB');
	return true;
}
time_<?php echo($inputname);?>_check();
</script>
<?php
	}
}
?>