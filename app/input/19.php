<input type="hidden" name="<?php echo($inputname);?>[]" value="array">
<div>
<ul id="dtext_<?php echo($inputname);?>" class="dtextul">
<?php
	$inputvalues=json_decode($inputvalue,1);
	if(is_array($inputvalues)) {
		foreach($inputvalues as $value) {
			if($value<>'') {
				echo('<li><input'.$style.' type="text" value="'.htmlspecialchars($value).'" name="'.$inputname.'[]" class="inputtext" size="20"><span onclick="textdel(this)"></span></li>');
			}
		}
	}else {
		echo('<li><input'.$style.' type="text" name="'.$inputname.'[]" class="inputtext" size="20"><span onclick="textdel(this)"></span></li>');
	}
?>
</ul>
<p class="dtextul_add" id="<?php echo($inputname);?>_dtextadd"></p>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#<?php echo($inputname);?>_dtextadd").click(function(){
			$("#dtext_<?php echo($inputname);?>").append("<li><input<?php echo(str_replace('"','\"',$style));?> type=\"text\" name=\"<?php echo($inputname);?>[]\" class=\"inputtext\" size=\"20\"><span onclick=\"textdel(this)\"></span></li>");
			$("#dtext_<?php echo($inputname);?> li:last-child input").focus();
		})
	});
</script>