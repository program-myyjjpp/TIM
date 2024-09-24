<ul id="allarticleschose_<?php echo($inputname);?>_list" class="allarticlechose_list articleschoose">
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


$inputvalues=json_decode($inputvalue,1);
$hovercid=0;
if(is_array($inputvalues)&&count($inputvalues)>0) {
	foreach($inputvalues as $key=>$val) {
		$set=array();
		$set['cid']=$val[0];
		$set['column']='id,title';
		$set['where']['id']=$val[1];
		$article=a($set);
		if($article) {
			if(empty($article['title'])) {
				$article['title']='无标题';
			}
			$hovercid=$val[0];
			if(power('s',$val[0])) {
				echo('<li><a rel="'.$article['id'].'" rev="'.$val[0].'" href="?do=list_edit&id='.$article['id'].'&cid='.$val[0].'&allarticleschoose='.$inputname.'&articlemname=title" target="_blank">'.$article['title'].'</a><div class="articleschose_action"><p class="up"></p><p class="down"></p><p class="del"></p></div><input type="hidden" name="'.$inputname.'[]" value="'.$article['id'].'"><input type="hidden" name="'.$inputname.'-channel[]" value="'.$val[0].'"></li>');
			}else {
				echo('<li><a rel="'.$article['id'].'" rev="'.$val[0].'" href="" target="_blank" style="color:red">[无权限]'.$article['title'].'</a><div class="articleschose_action"><p class="up"></p><p class="down"></p><p class="del"></p></div><input type="hidden" name="'.$inputname.'[]" value="'.$article['id'].'"><input type="hidden" name="'.$inputname.'-channel[]" value="'.$val[0].'"></li>');
			}
		}else {
			echo('<li><a title="'.$val[0].':'.$val[1].'" style="color:red">[文章已被删除]</a><div class="articleschose_action"><p class="up"></p><p class="down"></p><p class="del"></p></div><input type="hidden" name="'.$inputname.'[]" value="'.$val[1].'"><input type="hidden" name="'.$inputname.'-channel[]" value="'.$val[0].'"></li>');
		}
	}
}
?>
</ul>
<?php
$allchannel=channel_select(0,0,0,0);
echo('<select id="allarticlechose_'.$inputname.'"><option value="0">请选择栏目</option>');
foreach($allchannel as $val) {
	if($val['ifshowadmin'] && power('s',$val['cid']) ) {
		if($val['ckind']==2) {
			if($hovercid==$val['cid']) {
				$allow=1;
				echo('<option value="'.$val['cid'].'" selected>'.$val['ext'].$val['cname'].'</option>');
			}else {
				echo('<option value="'.$val['cid'].'">'.$val['ext'].$val['cname'].'</option>');
			}
		}else {
			echo('<option value="'.$val['cid'].'" disabled>'.$val['ext'].$val['cname'].'</option>');
		}
	}
}
echo('</select>');
?>
<input type="button" id="allarticlechosebutton_<?php echo($inputname);?>" <?php if(!isset($allow)) {echo('disabled');}?> value="选择" style="margin-left:4px;width:55px;height:28px;font-size:12px;">
<script type="text/javascript">
	$(document).ready(function(){
		$("#allarticlechosebutton_<?php echo($inputname);?>").click(function(){
			window.open("?do=list&cid="+$("#allarticlechose_<?php echo($inputname);?>").val()+"&allarticleschoose=<?php echo($inputname);?>&articlemname=title");
		})
		$("#allarticlechose_<?php echo($inputname);?>").change(function(){
			if ($(this).val()>0)
			{
				$("#allarticlechosebutton_<?php echo($inputname);?>").attr('disabled',false);
			}else{
				$("#allarticlechosebutton_<?php echo($inputname);?>").attr('disabled',true);
			}
		})
	});
	$('#allarticleschose_<?php echo($inputname);?>_list').on('mouseenter','li',function(){
		$(this).find(".articleschose_action").show();
	});
	$('#allarticleschose_<?php echo($inputname);?>_list').on('mouseleave','li',function(){
		$(this).find(".articleschose_action").hide();
	});
	$("#allarticleschose_<?php echo($inputname);?>_list").on('click','.articleschose_action p.del',function(){
		if (confirm('删除？')){
			$(this).parent().parent("li").remove(); 
		}
	})
	$("#allarticleschose_<?php echo($inputname);?>_list").on('click','.articleschose_action p.up',function(){
		var prevhtml=$(this).parent().parent("li").prev().html();
		if (prevhtml)
		{
			var myhtml=$(this).parent().parent("li").prev().next().html();
			$(this).parent().parent("li").prev().html(myhtml);
			$(this).parent().parent("li").prev().next().html(prevhtml);
			
		}
	})
	$("#allarticleschose_<?php echo($inputname);?>_list").on('click','.articleschose_action p.down',function(){
		var nexthtml=$(this).parent().parent("li").next().html();
		if (nexthtml)
		{
			var myhtml=$(this).parent().parent("li").html();
			$(this).parent().parent("li").next().html(myhtml);
			$(this).parent().parent("li").html(nexthtml);
			
		}
	})

</script>
<br>