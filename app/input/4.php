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


if(!isset($GLOBALS['kindeditor'])) {
	echo('<script charset="utf-8" src="img/kindeditor.js"></script>');
	$GLOBALS['kindeditor']=1;
}
?>
<textarea<?php $style=='' ? print(' style="width:700px;height:400px"') : print($style);?> name="<?php echo($inputname);?>"  id="<?php echo($inputname);?>"><?php echo($inputvalue);?></textarea>
<script type="text/javascript">
	var <?php echo($inputname);?>;
	KindEditor.ready(function(K) {
		<?php echo($inputname);?> = K.create('#<?php echo($inputname);?>', {
		uploadJson : 'upload.php',
		filterMode : false,
		afterChange : function() {
			this.sync();
		},
		});
	});
</script>