<label>
<input type="hidden" name="<?php echo($inputname);?>" id="<?php echo($inputname);?>" value="<?php echo($inputvalue);?>">
<input <?php echo($style);?> type="checkbox" id="<?php echo($inputname);?>_checkbox" <?php if($inputvalue==1) {echo('checked');}?>></label>
<script>
$(function(){
	$('#<?php echo($inputname);?>_checkbox').change(function(){
		if($(this).prop('checked')){
			$('#<?php echo($inputname);?>').val("1");
		}else{
			$('#<?php echo($inputname);?>').val("0");
		}
	});
});
</script>