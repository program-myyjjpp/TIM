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
if(!AdminFileedit) {
	adminmsg('','文件管理功能已关闭',0);
}
if(isset($_GET['dir'])) {
	if(empty($_GET['dir'])) {
		$_GET['dir']='/';
	}
	$getdir=$_GET['dir'];
	if($_GET['dir']=='/') {
		$dir=$_GET['dir'];
	}else {
		$dir=$_GET['dir'];
	}
	$alldir=$_SERVER['DOCUMENT_ROOT'].$_GET['dir'].'/';
	if(stripos($_GET['dir'],'..')===false) {}else {die('error dir');}
}else {
	die('no dir');
}
if(isset($_GET['file'])) {
	$filename=$_GET['file'];
	if(stripos($_GET['file'],'..')===false) {}else {die('error filename');}
	if(!isedit($_GET['file'])) {
		die('error');
	}
}else {
	die('no file');
}
if(isset($_POST['co'])) {
	checktoken();
	$content=$_POST['co'];
	$fp = @fopen($alldir.$filename,"w");
	if(!@fwrite($fp,$content) && strlen($content)<>0){
		adminmsg('','写入失败,请修改文件权限',1);
		exit;
	}
	fclose($fp);
	$refererurl='?do=sadmin_fileedit&dir='.$_GET['dir'].'&file='.$_GET['file'].'&pos='.$_POST['pos'];
	adminmsg($refererurl,'保存成功',1,'编辑页');
	exit();
}
if(!is_file($alldir.$filename)) {
	$content='';
}else {
	$content=htmlspecialchars(file_get_contents($alldir.$filename));
}

function isedit($filename) {
	$array=array('php','css','js','htm','html','txt');
	foreach($array as $val) {
		if(pathinfo($filename, PATHINFO_EXTENSION)==$val) {
			Return true;
		}
	}
	Return false;
}
?>
<script type="text/javascript">
document.title = '<?php echo($_GET['file']);?>';
</script>
<style type="text/css">
textarea{font-size:9pt;  color:#000}
.grey{color:#fff;background-color:#5E5E5E}
#msg1,#msg2,#msg3,#msg4{ display:none}
#ol{position:absolute; z-index:1; padding:0px; margin:0px; border:0px; background:#ecf0f5;width:23px; text-align:left;}
#li{background:#EAE3DF; overflow:hidden; width:32px; border-right:0; line-height:20px; margin:0px; padding:0px;text-align:center;color:#333}
#c2{font-family:Fixedsys,Arial, Helvetica, sans-serif;  margin:0px; padding:0 0 0 35px; overflow-x: hidden; line-height:20px;}
</style>
<script language="javascript" type="text/javascript">
String.prototype.trim2 = function()
{
return this.replace(/(^\s*)|(\s*$)/g, "");
}
function F(objid){
return document.getElementById(objid).value;
}
function G(objid){
return document.getElementById(objid);
}
 
</script>
<div id="UMain">
   <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>文件修改</strong> </div>   <div id="mainBox">
    <h3>文件管理<a href="<?php echo(substr(SystemDir,0,strlen(SystemDir)-1).$dir.$_GET['file']);?>" target="_blank"><?php echo('&nbsp;&nbsp;'.$dir.$_GET['file']);?></a>
	<a href="?do=sadmin_file&dir=<?php echo($getdir);?>" class="actionBtn" style="margin-left:10px"><em>返回</em></a>
	<a href="//uuu.la/temphelper/" target="_blank" class="actionBtn" style="margin-left:10px">模板制作助手</a>
	<a href="?do=sadmin_file&dir=<?php echo('/');?>" class="actionBtn" style="margin-left:10px">根目录</a>
	</h3>
	<form method=post action="" id="form1" onsubmit="return insertpos()">
	<?php newtoken();?>
	<table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
     <tr>
	 <td width="95%">
<div id="ol"><textarea style="height:100%" cols="2" rows="25"  id="li" disabled></textarea></div>
<textarea name="co" style="height:100%;width:95%;"  rows="25"  wrap="off" id="c2" onblur="check('2')" onkeyup="keyUp()" onscroll="G('li').scrollTop = this.scrollTop;" oncontextmenu="return false" class="grey"><?php echo($content);?></textarea> 
<script language="javascript" type="text/javascript">
function insertpos(){
	 var textbox = document.getElementById('c2');
	document.getElementById('pos').value=textbox.selectionStart;
	//alert(document.selection.createRange());
	return true;
}
// onFocus="clearValue('2')"
var msgA=["msg1","msg2","msg3","msg4"];
var c=["c1","c2","c3","c4"];
var slen=[50,20000,20000,60];//允许最大字数rows="10"
var num="";
var isfirst=[0,0,0,0,0,0];
function isEmpty(strVal){
	if( strVal == "" )
	return true;
	else
	return false;
}
function isBlank(testVal){ 
	var regVal=/^\s*$/;
	return (regVal.test(testVal))
}
function chLen(strVal){
	strVal=strVal.trim2();
	var cArr = strVal.match(/[^\x00-\xff]/ig);
	return strVal.length + (cArr == null ? 0 : cArr.length); 
}
function check(i){
	return true;
	var iValue=F("c"+i);
	var iObj=G("msg"+i);
	var n=(chLen(iValue)>slen[i-1]);
	if((isBlank(iValue)==true)||(isEmpty(iValue)==true)||n==true){ 
		iObj.style.display ="block";
	}else{ 
		iObj.style.display ="none";
	}
}

function clearValue(i){
	G(c[i-1]).style.color="#000";
	keyUp(); 
	if(isfirst[i]==0){
		G(c[i-1]).value="";
	}
	isfirst[i]=1;
}
function keyUp(){
	var obj=G("c2");
	var str=obj.value; 
	str=str.replace(/\r/gi,"");
	str=str.split("\n");
	n=str.length;
	line(n);
}
function line(n){
	var lineobj=G("li");
	for(var i=1;i<=n;i++){
	if(document.all){
		num+=i+"\r\n";
	}else{
		num+=i+"\n";
	}
}
lineobj.value=num;
num="";
}
function autoScroll(){
	var nV = 0;
	if(!document.all){
		nV=G("c2").scrollTop;
		G("li").scrollTop=nV;
		setTimeout("autoScroll()",20);
	} 
}
if(!document.all){
	window.addEventListener("load",autoScroll,false);
}
</script>

<script type="text/javascript">
keyUp();
</script>
		</td>
		<td>
		<input type="hidden" name="pos" id="pos" value="">
		<script type="text/javascript">
			document.getElementById('c2').focus();
			<?php
			if (isset($_GET['pos']) && $_GET['pos']>0)
			{
			?>
			document.getElementById('c2').selectionStart=<?php echo($_GET['pos']);?>;
			<?php
				}
			?>
			$(document).ready(function(){
				$('#c2').keypress(function(e){
					if(e.ctrlKey && e.which == 13 || e.which == 10) {
						$('#form1').submit();
					}
				});
			}); 
		</script>
<?php
if(!is_file($alldir.$filename)) {
	echo('<input class="btn" style="width:60px;" type="submit" value="新建">');
}else {
	echo('<input class="btn" style="width:60px;" type="submit" value="保存">');
}
?>

		</td>
		</table>
		</form>
       </div>
 </div>
