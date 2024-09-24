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


if(strlen($inputvalue)<5) {
	$inputvalue='116.419075,39.869762,5';
}
$mappos=explode(',',$inputvalue);
echo('<input type="hidden" name="'.$inputname.'" id="'.$inputname.'_inputmap" value="'.$inputvalue.'">');
if(strlen($style)<5) {
	$style='style="height:500px;width:80%;"';
}
?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=MeFu3gZv7wcBC2RWUL19BgOG"></script>
<div id="<?php echo($inputname);?>_map" <?php echo($style);?>></div>
<script type="text/javascript">
	// 百度地图API功能
	var <?php echo($inputname);?>_map = new BMap.Map("<?php echo($inputname);?>_map");
	var <?php echo($inputname);?>_point = new BMap.Point(<?php echo($mappos[0]);?>,<?php echo($mappos[1]);?>);
	<?php echo($inputname);?>_map.centerAndZoom(<?php echo($inputname);?>_point,<?php echo($mappos[2]);?>);
	<?php echo($inputname);?>_map.disableDoubleClickZoom();
	var <?php echo($inputname);?>_marker = new BMap.Marker(<?php echo($inputname);?>_point);// 创建标注
	<?php echo($inputname);?>_map.addOverlay(<?php echo($inputname);?>_marker);             // 将标注添加到地图中
	<?php echo($inputname);?>_map.enableScrollWheelZoom(); 
	<?php echo($inputname);?>_marker.enableDragging();
	<?php echo($inputname);?>_marker.addEventListener("onmouseup",<?php echo($inputname);?>_getAttr);
	<?php echo($inputname);?>_map.addEventListener("rightclick", <?php echo($inputname);?>_rightclick);
	function <?php echo($inputname);?>_rightclick(e){
		<?php echo($inputname);?>_marker.setPosition(new BMap.Point(e.point.lng,e.point.lat));
		document.getElementById("<?php echo($inputname);?>_inputmap").value=e.point.lng + "," + e.point.lat + "," + <?php echo($inputname);?>_map.getZoom();
	}
	function <?php echo($inputname);?>_getAttr(){
		var p = <?php echo($inputname);?>_marker.getPosition();       //获取marker的位置
		document.getElementById("<?php echo($inputname);?>_inputmap").value=p.lng + "," + p.lat + "," + <?php echo($inputname);?>_map.getZoom();
	}
</script>