<input type="hidden" name="<?php echo($inputname);?>[]" value="array">
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
}else {htmlinput_error($inputarray['from'],$inputarray['id']);}

$inputvalues=json_decode($inputvalue,1);
echo('<span id="'.$inputname.'_ajax">');
if(is_array($inputvalues)) {
	foreach($inputvalues as $key=>$val) {
		$query = $GLOBALS['db'] -> query("SELECT id,$mname FROM $thisarticletable where cid='$cid' and id='$val' limit 1;");
		$strarray = $GLOBALS['db'] -> fetchone($query);
		if($strarray) {
			$thistitle=$strarray[$mname];
			echo('<label><input name="'.$inputname.'[]" type="checkbox"  value="'.$strarray['id'].'" checked>'.$strarray[$mname].'</label>');
		}
	}
}
echo('</span>');
?>
<input type="text" id="<?php echo($inputname);?>_search" value="" class="inputtext" size="15" placeholder="请输入搜索词" autocomplete=off>
<script language="javascript" type="text/javascript">		  
$(document).ready(function(){
    $("#<?php echo($inputname);?>_search").keyup(function(){
		searchkeyword=$("#<?php echo($inputname);?>_search").val();
		if (searchkeyword.length==0)
		{
			return false;
		}
		 $.post("ajax.php?do=amoudlecheckbox",
		  {
			name:'<?php echo($inputname);?>',
			keyword:searchkeyword,
			moudleid:"<?php echo($inputarray['id']);?>",
			from:"<?php echo(@$inputarray['from']);?>",
		  },
		  function(data,status){
			$("#<?php echo($inputname);?>_ajax label").each(function(){
				if ($(this).children("input").prop("checked")==false)
				{
					$(this).remove();
				}else{
					
				}
			});
			 $("#<?php echo($inputname);?>_ajax").append(data);
			//alert("Data: " + data + "\nStatus: " + status);
		  });
    });

});
</script>