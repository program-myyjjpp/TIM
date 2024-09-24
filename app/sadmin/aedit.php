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


if (!defined('admin')) {exit();}
if(power('alevel')!=3) {die('error');}
$id=intval($_GET['id']);
if(empty($id)) {
	die();
}
$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('moudle')." where id='$id'");
$link = $GLOBALS['db'] -> fetchone($query);

$msetting=json_decode($link['msetting'],1);
$cid = $link['cid'];
$cname = $GLOBALS['db'] -> fetchcount("SELECT cname FROM ".tableex('channel')." where cid='$cid' limit 1");
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>栏目配置</strong></div>   <div id="mainBox">
    <h3>
	<a href="?do=sadmin_aindex&cid=<?php echo($cid);?>" class="actionBtn">返回</a>
	<?php echo($link['minfo']);?><i>字段修改</i></h3>
<form id="form1" method="post" action="?do=sadmin_aeditpost">
     <table width="100%" border="0" cellpadding="8" cellspacing="0" class="">
<?php newtoken();?>
		<input type="hidden" name="mid" value="<?php echo($link['id']);?>">
		<input type="hidden" name="cid" value="<?php echo($link['cid']);?>">
			<tr><td width="10%" align="right">字段名(en)</td>
				<td align="left"><input type="text" name="mname" value="<?php echo($link['mname']);?>" class="inputtext"readonly>
				<label><input type="checkbox" name="hide"<?php if($link['hide']==1) {echo('checked');}?>>禁用该字段</label>
				<label><input type="checkbox" name="ifadmin"<?php if($link['ifadmin']==1) {echo('checked');}?>>管理员字段</label>
				<label><input type="checkbox" name="ifmore"<?php if($link['ifmore']==1) {echo('checked');}?>>默认隐藏</label>
				<label><input type="checkbox" name="ifshow" <?php if($link['ifshow']==1){echo('checked');};?>>后台列表页显示</label>
				<label><input type="checkbox" name="msetting[adminsearch]" <?php if(isset($msetting['adminsearch'])){echo(' checked');}?>>后台列表页搜索字段</label>
				</td></tr>
			<tr><td width="10%" align="right">字段描述</td>
				<td align="left">
				
				<input type="text" name="minfo" value="<?php echo($link['minfo']);?>" class="inputtext">
				上级字段:
				<select name="fid" id="fid">
					<option value="">无</option>
					<?php
					$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('moudle')." where cid='$cid' and id<>'$id' order by morder asc;");
					$allmoudle = $GLOBALS['db'] -> fetchall($query);
					$sonarray=array();
					foreach($allmoudle as $value) {
						//判断当前字段是否有下属字段
						if($value['fid']==$link['mname'] && $value['hide']<>1) {
							$sonarray[]=$value['mname'];
						}
						//列出能当一级字段的字段
						if($value['fid']=='') {
							if($value['mname']==$link['fid']) {
								echo('<option value="'.$value['mname'].'" selected>'.$value['minfo'].'</option>');
							}else {
								echo('<option value="'.$value['mname'].'">'.$value['minfo'].'</option>');
							}
						}
					}
					?>
					
				</select>
				<?php
				if(count($sonarray)>0) {
					echo('该字段下有二级字段('.implode(',',$sonarray).')'.',无法设置该字段的上级字段');
					echo('<script>$(function(){$("#fid").attr("disabled","desabled");});</script>');
				}
				?>
				</td></tr>


<tr><td width="10%" align="right">字段类型</td><td align="left">
<select name="mkind" id="mkind"> 
<?php
$defaultcolumnkind="";
$defaultcolumntips="";
$defaultcolumnstrfrom="";
$moresetting1='none';
$moresetting2='none';
foreach($inputkindarray as $val) {
	if(isset($val['strfrom'])) {$val['strfrom']=$val['strfrom'];}else {$val['strfrom']=0;}
	if(!isset($val['tips'])) {$val['tips']="";}
	if($val['id']==$link['mkind']) {
		echo('<option rel="'.$val['setting'].'" rev="'.$val['strfrom'].'" alt="'.$val['tips'].'" columnkind="'.($val['kind']).'" value="'.$val['id'].'" selected>'.$val['name'].'</option>'."\r\n");
		$defaultcolumntips=($val['tips']);
		$defaultcolumnstrfrom=$val['strfrom'];
		$defaultcolumnkind=($val['kind']);
		if($val['strfrom']==1) {$moresetting1='';$moresetting2='none';}elseif($val['strfrom']==2) {$moresetting1='none';$moresetting2='';}
	}else {
		echo('<option rel="'.$val['setting'].'" rev="'.$val['strfrom'].'" alt="'.$val['tips'].'" columnkind="'.($val['kind']).'" value="'.$val['id'].'">'.$val['name'].'</option>'."\r\n");
	}
}
$strarray=$link['strarray'];
if($defaultcolumnstrfrom==1) {
	$strarray=explode('|',$link['strarray']);
	if(count($strarray)<2) {
		$strarray[0]=0;
		$strarray[1]='title';
	}
	$strarray[2]='';
}elseif($defaultcolumnstrfrom==2) {
	$strarray=array(0,'title',$strarray);
}else {
	$strarray=array(0,'title','');
}
?>
</select>
<script type="text/javascript">
	$(function(){
		defaultcolumnkind='<?php echo($defaultcolumnkind);?>';
		$('#mkind').change(function(){
			if ($("#mkind").find("option:selected").attr('columnkind')!=defaultcolumnkind)
			{
				alert('更换后的字段类型('+$("#mkind").find("option:selected").attr('columnkind')+')与更换前的字段类型('+defaultcolumnkind+')不一致,\r\n请手动在数据库中修改该字段类型为: '+$("#mkind").find("option:selected").attr('columnkind')+'\r\n取消更改请刷新当前页面');
			}
			$('.input_tips').text($("#mkind").find("option:selected").attr('alt'));
			if ($("#mkind").find("option:selected").attr('rel')>0)
			{
				$('.input_moresetting').hide();
				$('#moresetting'+$("#mkind").find("option:selected").attr('rev')).show();
			}else{
				$('.input_moresetting').hide();
			}
		});
	});
</script>		
</td></tr>

<tr id="moresetting1" class="input_moresetting" style="display:<?php echo($moresetting1);?>"><td width="10%" align="right">字段数据来源</td>
<td align="left">
<select id="strfrom0" name="strarray0">
<?php
channel_select($strarray[0],0,0,1,'字段数据来源栏目');
?>
</select>
 <img class="strarrayloading" src="img/loading.gif"> 
<select id="strfrom1" name="strarray1">
<?php
if(isset($strarray[1])) {
	echo('<option value="'.$strarray[1].'">'.$strarray[1].'</option>');
}
?>
</select>
<i class="input_tips"><?php echo($defaultcolumntips);?></i>
<script>
$(function(){
	changestrarray('<?php echo($strarray[1]);?>');
	$('#strfrom0').change(function(){
		changestrarray('');
	});
});
function changestrarray(strdefault){
	cid=$('#strfrom0').val();
	if (strdefault=='')
	{
		strdefault=$('#strfrom1').val();
	}
	$('.strarrayloading').show();
	$.post("ajax.php?do=strarraylist",
	  {
		cid:cid,
		strdefault:strdefault
	  },
	  function(data,status){
		$('#strfrom1').html('');
		$("#strfrom1").append(data);
		$('.strarrayloading').hide();
		if ($('#strfrom1').val()=='')
		{
			//$('.pleasetips').show();
		}else{
			//$('.pleasetips').hide();
		}
	  });
}
</script>
</td></tr>

<tr id="moresetting2"  class="input_moresetting" style="display:<?php echo($moresetting2);?>"><td width="10%" align="right">字段配置</td>
<td align="left">
<input type="text" name="strarray2" size="40" class="inputtext" value="<?php echo($strarray[2]);?>">
<i class="input_tips"><?php echo($defaultcolumntips);?></i>
</td></tr>

				<tr><td width="10%" align="right">数据校验正则</td>
				<td align="left">
				<input type="text" id="mregular" name="msetting[regular]" size="40" value="<?php if(isset($msetting['regular'])) {echo(htmlspecialchars($msetting['regular']));}else{$msetting['regular']='';}?>"  class="inputtext">
				<select name="pattern_select" onchange="javascript:$('#mregular').val(this.value)">
				<option<?php if($msetting['regular']=='') {echo(' selected');}?> value="">常用正则</option>
				<option<?php if($msetting['regular']=='/^[0-9.-]+$/') {echo(' selected');}?> value="/^[0-9.-]+$/">数字</option>
				<option<?php if($msetting['regular']=='/^[0-9-]+$/') {echo(' selected');}?> value="/^[0-9-]+$/">整数</option>
				<option<?php if($msetting['regular']=='/^[a-z]+$/i') {echo(' selected');}?> value="/^[a-z]+$/i">字母</option>
				<option<?php if($msetting['regular']=='/^[0-9a-z]+$/i') {echo(' selected');}?> value="/^[0-9a-z]+$/i">数字+字母</option>
				<option<?php if($msetting['regular']=='/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/') {echo(' selected');}?> value="/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/">E-mail</option>
				<option<?php if($msetting['regular']=='/^[0-9]{5,20}$/') {echo(' selected');}?> value="/^[0-9]{5,20}$/">QQ</option>
				<option<?php if($msetting['regular']=='/^http:\/\//') {echo(' selected');}?> value="/^http:\/\//">超级链接</option>
				<option<?php if($msetting['regular']=='/^(1)[0-9]{10}$/') {echo(' selected');}?> value="/^(1)[0-9]{10}$/">手机号码</option>
				<option<?php if($msetting['regular']=='/^[0-9-]{6,13}$/') {echo(' selected');}?> value="/^[0-9-]{6,13}$/">电话号码</option>
				<option<?php if($msetting['regular']=='/^[0-9]{6}$/') {echo(' selected');}?> value="/^[0-9]{6}$/">邮政编码</option>
				<option<?php if($msetting['regular']=='/(.*)$/') {echo(' selected');}?> value="/(.*)$/">任意字符串</option>
				</select>
				<i>不填则不限制</i>
				</td></tr>

				<tr><td width="10%" align="right">输入提示</td>
				<td align="left">
				<textarea name="mcontent" rows="3" class="textarea" cols="50"><?php echo(htmlspecialchars($link['mcontent']));?></textarea>
				</td></tr>

				<tr><td width="10%" align="right">长度限制</td>
					<td align="left">
					最短 <input type="text" name="msetting[lenmin]" size="10" value="<?php if(isset($msetting['lenmin'])) {echo(intval($msetting['lenmin']));}?>"  class="inputtext">
					最长 <input type="text" name="msetting[lenmax]" size="10" value="<?php if(isset($msetting['lenmax'])) {echo(intval($msetting['lenmax']));}?>"  class="inputtext">
					<i>不填则不限制</i>
				</td></tr>

				<tr><td width="10%" align="right">HTML代码过滤</td>
								<td align="left">
								<select name="msetting[filterhtml]">
				<option value="0" <?php if(!isset($msetting['filterhtml'])){echo(' selected');}?>>HTML代码设置</option>
				<option value="0" <?php if(isset($msetting['filterhtml']) && $msetting['filterhtml']==0){echo(' selected');}?>>允许HTML代码</option>
				<option value="1" <?php if(isset($msetting['filterhtml']) && $msetting['filterhtml']==1){echo(' selected');}?>>过滤危险HTML代码</option>
				<option value="2" <?php if(isset($msetting['filterhtml']) && $msetting['filterhtml']==2){echo(' selected');}?>>禁用HTML代码</option>
				</select>
				<i>超级管理员始终允许HTML代码</i>
				</td></tr>

				<tr><td width="10%" align="right">数据唯一</td>
				<td align="left">
				<label><input type="checkbox" name="ifonly" <?php if($link['ifonly']==1){echo('checked');};?>>唯一</label>
				<i>勾选后同一个表中不能出现相同的数据</i>
				</td></tr>

				<tr><td width="10%" align="right">默认值</td>
				<td align="left">
				<input type="text" name="strdefault" size="40" value="<?php echo(htmlspecialchars($link['strdefault']));?>"  class="inputtext">
				</td></tr>

				<tr><td width="10%" align="right">字段排序</td>
				<td align="left">
				<input type="text" name="morder" size="40" value="<?php echo($link['morder']);?>"  class="inputtext">
				</td></tr>

		<tr style="display:none"><td width="10%" align="right">后台列表页显示模板</td>
				<td align="left">
				<textarea name="ifshowtemp" rows="3" cols="50"  class="textarea"><?php echo(htmlspecialchars($link['ifshowtemp']));?></textarea> 
				<i>如:&lt;a href="?{id}"&gt;{title}&lt;/a&gt;</i>
				</td></tr>
		<tr><td width="10%" align="right">输入框style</td>
				<td align="left">
				<input type="text" name="mfunction" size="58" value="<?php echo($link['mfunction']);?>"  class="inputtext">
				<i>如:height:250px;width:1212px</i>
				</td></tr>	
      <tr>
       <td></td>
       <td>
        <input class="btn btn140" type="submit" value="提交" />	
		<br><br>
		<i>注:长度限制 数据唯一 只做程序判断,并不会在数据库中限制.如您需要更多设置,请使用数据库软件在数据库中修改字段</i>
       </td>
      </tr>
     </table></form>
       </div>
 </div>
