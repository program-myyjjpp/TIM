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
<input<?php echo($style);?> autocomplete="off" name="<?php echo($inputname);?>" type="text" id="<?php echo($inputname);?>" class="inputtext" size="45" value="<?php echo(($inputvalue));?>" onmousemove="javascript:showdiv('<?php echo($inputname);?>');" onmouseout="javascript:divclose('<?php echo($inputname);?>');" >
<?php
if($sbie) {
?>
	<iframe id="<?php echo($inputname);?>_iframe" name="<?php echo($inputname);?>_iframe" src="upload.php?inputname=<?php echo($inputname);?>&picsize=<?php echo($pictips);?>" class="uploadfileiframe" style="width:170px" border=0  frameborder=0></iframe>
<?php
}else{
?>
	<iframe id="<?php echo($inputname);?>_iframe" name="<?php echo($inputname);?>_iframe" src="upload.php?inputname=<?php echo($inputname);?>&picsize=<?php echo($pictips);?>" class="uploadfileiframe" border=0  frameborder=0></iframe>
<?php
}	
?>
<span id="<?php echo($inputname);?>_pic" class="input5_pic_preview" style="display:none"></span>

<?php
	if($sbie) {echo('<!-- ie不支持粘贴上传 -->');}else{
?>
<script type="text/javascript">
	// 粘贴上传图片
	document.getElementById("<?php echo($inputname);?>").addEventListener('paste', function(e) {
		var clipboard = e.clipboardData;
		for(var i=0,len=clipboard.items.length; i<len; i++) {
			if(clipboard.items[i].kind == 'file' || clipboard.items[i].type.indexOf('image') > -1) {
				var imageFile = clipboard.items[i].getAsFile();
				var form = new FormData;
				form.append('imgFile', imageFile);
				form.append('picsize', '<?php echo($pictips);?>');
				$.ajax({
					url: 'upload.php',
					type: "POST",
					data: form,
					processData: false,
					contentType: false,
					beforeSend: function() {document.<?php echo($inputname);?>_iframe.uploadbutton.innerText='上传中';},
					error: function() {
						document.<?php echo($inputname);?>_iframe.uploadbutton.innerText='上传';
						alert('上传失败,请重新上传');
					},
					success: function(url) {
						var jsonobj=eval('('+url+')');
						if (jsonobj.error==0)
						{if (document.getElementById("<?php echo($inputname);?>").value==''){}else{}
							document.getElementById("<?php echo($inputname);?>").value=jsonobj.url;
							document.<?php echo($inputname);?>_iframe.uploadbutton.innerText='上传成功';
						}else{alert(jsonobj.message);}
					}
				})
				e.preventDefault();
			}
		}
	});
</script>
<?php
}
?>