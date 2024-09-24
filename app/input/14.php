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

if(!empty($inputvalue)) {
		$query = $GLOBALS['db'] -> query("SELECT id,$mname FROM $thisarticletable where cid='$cid' and id='$inputvalue' limit 1;");
		$strarray = $GLOBALS['db'] -> fetchone($query);
		if($strarray) {
			$thistitle=$strarray[$mname];
		}else {
			$thistitle='已删除';
			$inputvalue=0;
		}
}
?>
		<select name="<?php echo($inputname);?>" id="<?php echo($inputname);?>">
		<?php
		if(isset($thistitle)) {
		echo('<option value="'.$inputvalue.'" selected>'.$thistitle.'</option>');
		}
		?>
	   </select>
	    <input type="text" id="<?php echo($inputname);?>_search" value="" class="inputtext" size="15" placeholder="请输入搜索词">
<script language="javascript" type="text/javascript">
			  
$(document).ready(function(){
    $("#<?php echo($inputname);?>_search").keyup(function(){
		thisvalue=$("#<?php echo($inputname);?> option:selected").attr("value");
		thistitle=$("#<?php echo($inputname);?> option:selected").text();
		$("#<?php echo($inputname);?>").empty();
		if (thisvalue!==undefined && thisvalue!=0)
		{
			$("#<?php echo($inputname);?>").append( "<option value=\""+thisvalue+"\"  selected=\"true\">"+thistitle+"</option>" );
		}
		searchkeyword=$("#<?php echo($inputname);?>_search").val();
		if (searchkeyword.length==0)
		{
			return false;
		}
		 $.post("ajax.php?do=amoudleselect",
		  {
			name:'<?php echo($inputname);?>',
			keyword:searchkeyword,
			moudleid:"<?php echo($inputarray['id']);?>",
			from:"<?php echo(@$inputarray['from']);?>",
		  },
		  function(data,status){
			 $("#<?php echo($inputname);?>_search").append(data);
			 $("#<?php echo($inputname);?>").append( "<option value=\"0\" >未选</option>" );
			//alert("Data: " + data + "\nStatus: " + status);
		  });
    });

});
</script>