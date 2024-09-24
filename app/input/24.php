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


$sbie=0;
if(isset($_SERVER['HTTP_USER_AGENT']) && (stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 5') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 6') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 7') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 8') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 9') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 10'))) {
	$sbie=1;
}
$newinputvalue=json_decode($inputvalue,1);
if(isset($newinputvalue['markdown'])) {
	$inputvalue=$newinputvalue['markdown'];
}
if(!is_dir("img/markdown/")) {
	echo('您尚未安装markdown编辑器,请先安装配置,详见:<a href="//uuu.la/help/markdown.html" target="_blank">http://uuu.la/help/markdown.html</a>');
}elseif($sbie) {
?>
	<textarea name="<?php echo($inputname);?>" style="display:none"></textarea>
	<textarea<?php echo($style);?> name="editormd<?php echo($inputname);?>-markdown-doc"  cols="60" rows="6" class="textarea"><?php echo($inputvalue);?></textarea>IE浏览器不支持Markdown编辑器
<?php
}else {
if(!isset($GLOBALS['markdown_res'])) {
	$GLOBALS['markdown_res']=1;
	?>
<link href="img/markdown/editormd.css" rel="stylesheet" type="text/css"> 
<script src="img/markdown/editormd.js"></script> 
	<?php
}
if(empty($style)) {
	$style='width: "100%",height: 480,';
}else {
	$style1=$style;
	$style='';
	preg_match_all("/height:([0-9]+)px;/isU",$style1,$height);
	if(isset($height[1][0])) {
		$style.='height: "'.$height[1][0].'px",';
	}else {
		preg_match_all("/height:([0-9]+)%;/isU",$style1,$height);
		if(isset($height[1][0])) {
			$style.='height: "'.$height[1][0].'%",';
		}else {
			$style.='height: "480",';
		}
	}
	preg_match_all("/width:([0-9]+)px;/isU",$style1,$width);
	if(isset($width[1][0])) {
		$style.='width: "'.$width[1][0].'px",';
	}else {
		preg_match_all("/width:([0-9]+)%;/isU",$style1,$width);
		if(isset($width[1][0])) {
			$style.='width: "'.$width[1][0].'%",';
		}else {
			$style.='width: "100%",';
		}
	}
}
?>
<textarea style="display:none" name="<?php echo($inputname);?>" id="markdown_inputvalue_textarea_<?php echo($inputname);?>"><?php echo($inputvalue);?></textarea>
<div id="editormd<?php echo($inputname);?>"></div>
<script type="text/javascript">
	$(function() {
		Editormd_<?php echo($inputname);?> = editormd("editormd<?php echo($inputname);?>", {
			<?php echo($style);?>
			saveHTMLToTextarea:true,
			htmlDecode : true,
			placeholder:'',
			autoFocus:false,
			markdown : $("#markdown_inputvalue_textarea_<?php echo($inputname);?>").val(),
			path : 'img/markdown/lib/',
			imageUpload    : true,
			imageUploadURL : "upload.php",
		});
		
	});
</script>

<?php
}
?>