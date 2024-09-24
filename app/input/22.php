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
echo('<input type="hidden" name="'.$inputname.'[]" value="array">');
$inputvalues=json_decode($inputvalue,1);
echo('<ul id="'.$inputname.'" class="articleschoose">');
if(is_array($inputvalues) && count($inputvalues)>0) {
	foreach($inputvalues as $value) {
		$query = $GLOBALS['db'] -> query("SELECT id,$mname FROM $thisarticletable where id='$value' limit 1;");
		if($link = $GLOBALS['db'] -> fetchone($query)) {
			if(empty($link[$mname])) {
				$link[$mname]='无标题';
			}
			echo('<li><a href="?do=list_edit&id='.$link['id'].'&cid='.$cid.'" target="_blank">'.$link[$mname].'</a>
			<div class="articleschose_action"><p class="up"></p><p class="down"></p><p class="del"></p></div>
			<input type="hidden" name="'.$inputname.'[]" value="'.$value.'">
			</li>');
		}
	}
}
?>
<?php
echo('</ul>');
?>
<input type="button" id="<?php echo($inputname);?>_articleschoose"  value="选择" style="width:55px;height:25px;font-size:12px;">
<script type="text/javascript">
	$(document).ready(function(){
		$("#<?php echo($inputname);?>_articleschoose").click(function(){
			window.open("?do=list&cid=<?php echo($cid);?>&articleschoose=<?php echo($inputname);?>&articlemname=<?php echo($mname);?>");
		})
	});
	$('#<?php echo($inputname);?>').on('mouseenter','li',function(){
		$(this).find(".articleschose_action").show();
	});
	$('#<?php echo($inputname);?>').on('mouseleave','li',function(){
		$(this).find(".articleschose_action").hide();
	});
	$("#<?php echo($inputname);?>").on('click','.articleschose_action p.del',function(){
		if (confirm('删除？')){
			$(this).parent().parent("li").remove(); 
		}
	})
	$("#<?php echo($inputname);?>").on('click','.articleschose_action p.up',function(){
		var prevhtml=$(this).parent().parent("li").prev().html();
		if (prevhtml)
		{
			var myhtml=$(this).parent().parent("li").prev().next().html();
			$(this).parent().parent("li").prev().html(myhtml);
			$(this).parent().parent("li").prev().next().html(prevhtml);
			
		}
	})
	$("#<?php echo($inputname);?>").on('click','.articleschose_action p.down',function(){
		var nexthtml=$(this).parent().parent("li").next().html();
		if (nexthtml)
		{
			var myhtml=$(this).parent().parent("li").html();
			$(this).parent().parent("li").next().html(myhtml);
			$(this).parent().parent("li").html(nexthtml);
			
		}
	})
</script>