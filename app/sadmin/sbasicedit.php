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
if(isset($_GET['id'])) {
	$id=intval($_GET['id']);
}else {
	die();
}
$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('str')." where id='$id' and inputkind>0");
$link = $GLOBALS['db'] -> fetchone($query);

$ssetting=json_decode($link['ssetting'],1);
$cid=$link['strcid'];
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>栏目配置</strong> </div>   <div id="mainBox">
    <h3><a href="?do=sadmin_sbasic&cid=<?php echo($cid);?>" class="actionBtn">返回</a><?php echo($link['strname']);?> <i>变量修改</i></h3>

     <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
<form id="form1" method="post" action="?do=sadmin_seditpost">
<?php newtoken();?>
		<input type="hidden" name="id" value="<?php echo($link['id']);?>">
		<input type="hidden" name="strcid" value="<?php echo($link['strcid']);?>">
			<tr><td width="10%" align="right">变量名</td>
				<td align="left"><input type="text" name="strname" value="<?php echo(htmlspecialchars($link['strname']));?>"  class="inputtext">
				<label><input type="checkbox" name="ifadmin" value="0" <?php if($link['ifadmin']==1) { echo('checked');}?>>管理员变量</label>
<?php
if($link['strcid']>0) {
?>
	<label style="display:none"><input type="checkbox" name="ifbind" value="0" <?php if($link['ifbind']==1) { echo('checked');}?>>绑定到栏目值</label>
<?php
}
?>
</td></tr>
<tr><td width="10%" align="right">变量类型</td><td align="left">
<select name="inputkind" id="inputkind"> 
<?php
$defaultcolumnkind="";
$defaultcolumntips="";
$defaultcolumnstrfrom="";
$moresetting1='none';
$moresetting2='none';
foreach($inputkindarray as $val) {
	if(isset($val['strfrom'])) {$val['strfrom']=$val['strfrom'];}else {$val['strfrom']=0;}
	if(!isset($val['tips'])) {$val['tips']="";}
	if($val['id']==$link['inputkind']) {
		echo('<option rel="'.$val['setting'].'" rev="'.$val['strfrom'].'"  alt="'.$val['tips'].'"  value="'.$val['id'].'" selected>'.$val['name'].'</option>'."\r\n");
		$defaultcolumnkind=md5($val['kind']);
		$defaultcolumntips=($val['tips']);
		$defaultcolumnstrfrom=$val['strfrom'];
		if($val['strfrom']==1) {$moresetting1='';$moresetting2='none';}elseif($val['strfrom']==2) {$moresetting1='none';$moresetting2='';}
	}else {
		echo('<option rel="'.$val['setting'].'" rev="'.$val['strfrom'].'"  alt="'.$val['tips'].'"  value="'.$val['id'].'">'.$val['name'].'</option>'."\r\n");
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
		$('#inputkind').change(function(){
			$('.input_tips').text($("#inputkind").find("option:selected").attr('alt'));
			if ($("#inputkind").find("option:selected").attr('rel')>0)
			{
				$('.input_moresetting').hide();
				$('#moresetting'+$("#inputkind").find("option:selected").attr('rev')).show();
			}else{
				$('.input_moresetting').hide();
			}
		});
	});
</script>

</td></tr>


<tr id="moresetting1" class="input_moresetting" style="display:<?php echo($moresetting1);?>"><td width="10%" align="right">变量数据来源</td>
<td align="left">
<select id="strfrom0" name="strarray0">
<?php
channel_select($strarray[0],0,0,1,'变量数据来源栏目');
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

<tr id="moresetting2"  class="input_moresetting" style="display:<?php echo($moresetting2);?>"><td width="10%" align="right">变量配置</td>
<td align="left">
<input type="text" name="strarray2" size="40" class="inputtext" value="<?php echo($strarray[2]);?>">
<i class="input_tips"><?php echo($defaultcolumntips);?></i>
</td></tr>



<tr><td width="10%" align="right">数据校验正则</td>
				<td align="left">
				<input type="text" id="sregular" name="ssetting[regular]" size="40" value="<?php if(isset($ssetting['regular'])) {echo(htmlspecialchars($ssetting['regular']));}else{$ssetting['regular']='';}?>"  class="inputtext">
				<select name="pattern_select" onchange="javascript:$('#sregular').val(this.value)">
<option<?php if($ssetting['regular']=='') {echo(' selected');}?> value="">常用正则</option>
<option<?php if($ssetting['regular']=='/^[0-9.-]+$/') {echo(' selected');}?> value="/^[0-9.-]+$/">数字</option>
<option<?php if($ssetting['regular']=='/^[0-9-]+$/') {echo(' selected');}?> value="/^[0-9-]+$/">整数</option>
<option<?php if($ssetting['regular']=='/^[a-z]+$/i') {echo(' selected');}?> value="/^[a-z]+$/i">字母</option>
<option<?php if($ssetting['regular']=='/^[0-9a-z]+$/i') {echo(' selected');}?> value="/^[0-9a-z]+$/i">数字+字母</option>
<option<?php if($ssetting['regular']=='/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/') {echo(' selected');}?> value="/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/">E-mail</option>
<option<?php if($ssetting['regular']=='/^[0-9]{5,20}$/') {echo(' selected');}?> value="/^[0-9]{5,20}$/">QQ</option>
<option<?php if($ssetting['regular']=='/^http:\/\//') {echo(' selected');}?> value="/^http:\/\//">超级链接</option>
<option<?php if($ssetting['regular']=='/^(1)[0-9]{10}$/') {echo(' selected');}?> value="/^(1)[0-9]{10}$/">手机号码</option>
<option<?php if($ssetting['regular']=='/^[0-9-]{6,13}$/') {echo(' selected');}?> value="/^[0-9-]{6,13}$/">电话号码</option>
<option<?php if($ssetting['regular']=='/^[0-9]{6}$/') {echo(' selected');}?> value="/^[0-9]{6}$/">邮政编码</option>
<option<?php if($ssetting['regular']=='/(.*)$/') {echo(' selected');}?> value="/(.*)$/">任意字符串</option>
</select>

				</td></tr>

<tr><td width="10%" align="right">长度限制</td>
				<td align="left">
				最短 <input type="text" name="ssetting[lenmin]" size="10" value="<?php if(isset($ssetting['lenmin'])) {echo(intval($ssetting['lenmin']));}?>"  class="inputtext">
				最长 <input type="text" name="ssetting[lenmax]" size="10" value="<?php if(isset($ssetting['lenmax'])) {echo(intval($ssetting['lenmax']));}?>"  class="inputtext">
				<i>不填则不限制</i>
				</td></tr>

			<tr><td width="10%" align="right">输入提示</td>
				<td align="left">
				<textarea name="strtip" rows="3" cols="60"><?php echo($link['strtip']);?></textarea>
				</td></tr>

				<tr><td width="10%" align="right">HTML代码设置</td>
				<td align="left">
				<select name="ssetting[filterhtml]">
<option value="0" <?php if(!isset($ssetting['filterhtml'])){echo(' selected');}?>>HTML代码设置</option>
<option value="0" <?php if(isset($ssetting['filterhtml']) && $ssetting['filterhtml']==0){echo(' selected');}?>>允许HTML代码</option>
<option value="1" <?php if(isset($ssetting['filterhtml']) && $ssetting['filterhtml']==1){echo(' selected');}?>>过滤危险HTML代码</option>
<option value="2" <?php if(isset($ssetting['filterhtml']) && $ssetting['filterhtml']==2){echo(' selected');}?>>禁用HTML代码</option>
</select>
<i> 超级管理员始终允许HTML代码</i>
				</td></tr>

				

<tr><td width="10%" align="right">输入框style</td>
				<td align="left">
				<input type="text" name="strstyle" size="60" value="<?php echo(htmlspecialchars($link['strstyle']));?>"  class="inputtext">
				<i>如:height:250px;width:1212px</i>
				</td></tr>	


			<tr><td width="10%" align="right">排序</td>
				<td align="left">
				<input type="text" name="strorder" size="40" value="<?php echo($link['strorder']);?>"  class="inputtext">
				</td></tr>
</td></tr>

      <tr>
       <td></td>
       <td>
        <input class="btn btn140" type="submit" value="提交" />
       </td>
      </tr>
     </table>
    </form>
       </div>
 </div>

