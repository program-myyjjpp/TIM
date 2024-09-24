function picdel(deltr){
		$(deltr).parent().parent("li").remove(); 
};
function picmoveup(deltr){
	var prevhtml=$(deltr).parent().prev().html();
	if (prevhtml)
	{
		var myhtml=$(deltr).parent().prev().next().html();
		$(deltr).parent().prev().html(myhtml);
		$(deltr).parent().prev().next().html(prevhtml);
		
	}
}
function picmovenext(deltr){
	var nexthtml=$(deltr).parent().next().html();
	if (nexthtml)
	{
		var myhtml=$(deltr).parent().next().prev().html();
		$(deltr).parent().next().html(myhtml);
		$(deltr).parent().next().prev().html(nexthtml);
		
	}
}
//动态文本框
function textdel(deltr){
	$(deltr).parent().remove();
};
function getos()
{
	if(isIE = navigator.userAgent.indexOf("MSIE")!=-1) { 
		return "MSIE"; 
	}
	if(isFirefox=navigator.userAgent.indexOf("Firefox")!=-1){ 
		return "Firefox"; 
	}
	if(isChrome=navigator.userAgent.indexOf("Chrome")!=-1){ 
		return "Chrome"; 
	}
	if(isSafari=navigator.userAgent.indexOf("Safari")!=-1) { 
		return "Safari"; 
	}
	if(isOpera=navigator.userAgent.indexOf("Opera")!=-1){ 
		return "Opera"; 
	}
	return "";
}
function ismobile() {
	var userAgentInfo = navigator.userAgent.toLowerCase();
	var Agents = ["android", "iphone","ipad", "mobile"];
	for (var v = 0; v < Agents.length; v++) {
		if (userAgentInfo.indexOf(Agents[v]) > 0) {
			return true;
		}
	}
	return false;
}
function confirmurl(url,message) {
	if(confirm(message)) location.href =url;
}
function selectcheckbox(form)
{
	for(var i = 0;i < form.elements.length; i++) 
	{
		var e = form.elements[i];
		if(e.name != 'chkall' && e.disabled != true) e.checked = form.chkall.checked;
	}
}
function CloseWebPage(){
	if (navigator.userAgent.indexOf("MSIE") > 0) {
		if (navigator.userAgent.indexOf("MSIE 6.0") > 0) {
			window.opener = null;
			window.close();
		} else {
			window.open('', '_top');
			window.top.close();
		}
	}
	else if (navigator.userAgent.indexOf("Firefox") > 0) {
		window.location.href = 'about:blank ';
	} else {
		window.opener = null;
		window.open('', '_self', '');
		window.close();
	}
}
function setCookie(name,value) 
{ 
	var Days = 30;
	var exp = new Date();
	exp.setTime(exp.getTime() + Days*24*60*60*1000);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function time_zero(number){
	if (number<10)
	{
		return '0'+number;
	}
	return number;
}
function showdiv(div){
	input5fileurl=document.getElementById(div).value.toLowerCase();
	image_ext=new Array("png","gif","jpg","jpeg","bmp","webp");
	ifpic=0;
	for (i in image_ext)
	{
		if (input5fileurl.indexOf("."+image_ext[i]) > -1){
			ifpic=1;
			break;
		}
	}
	if (!ifpic)
	{
		return false;
	}
	var ei = document.getElementById(div+"_pic");
	if (document.getElementById(div).value!="" && ei.style.display == "none")
	{
		ei.innerHTML = '<img src="' + document.getElementById(div).value + '" />';
	}
	ei.style.top  = document.body.scrollTop + event.clientY + 2 + "px";
	ei.style.left = document.body.scrollLeft + event.clientX + 10 + "px";
	ei.style.display = "block";
}
function divclose(div){
	var ei = document.getElementById(div+"_pic");
	ei.innerHTML = "";
	ei.style.display = "none";
}
function time_function_button(kind,inputdate){
		var nowdate = new Date();
		switch(kind)
		{
			case '1':
				inputdate=nowdate.getFullYear()+"-"+time_zero((nowdate.getMonth()+1))+"-"+time_zero(nowdate.getDate())+" "+time_zero(nowdate.getHours())+":"+time_zero(nowdate.getMinutes())+":"+time_zero(nowdate.getSeconds());
				break;
			case '2':
				var newTime = (new Date(inputdate));
				inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":00:00";
				break;
			case '13':
				var newTime = (new Date(inputdate));
				inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" 00:00:00";
				break;
			case '3':
				var newTime = (new Date(inputdate).getTime());
				newTime =newTime+3600*1000;
				newTime = new Date(newTime);
				inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
				break;
			case '4':
				var newTime = (new Date(inputdate).getTime());
				newTime =newTime-3600*1000;
				newTime = new Date(newTime);
				inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
				break;
			case '5':
				var newTime = (new Date(inputdate).getTime());
				newTime =newTime+3600*1000*24;
				newTime = new Date(newTime);
				inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
				break;
			case '6':
				var newTime = (new Date(inputdate).getTime());
				newTime =newTime-3600*1000*24;
				newTime = new Date(newTime);
				inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
				break;
			case '7':
				var newTime = (new Date(inputdate).getTime());
				newTime =newTime+3600*1000*24*7;
				newTime = new Date(newTime);
				inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
				break;
			case '8':
				var newTime = (new Date(inputdate).getTime());
				newTime =newTime-3600*1000*24*7;
				newTime = new Date(newTime);
				inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
				break;
			case '9':
				var newTime = (new Date(inputdate));
				newTime.setMonth(newTime.getMonth()+1);
				inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
				break;
			case '10':
				var newTime = (new Date(inputdate));
				newTime.setMonth(newTime.getMonth()-1);
				inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
				break;
			case '11':
				var newTime = (new Date(inputdate));
				newTime.setFullYear(newTime.getFullYear()+1);
				inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
				break;
			case '12':
				var newTime = (new Date(inputdate));
				newTime.setFullYear(newTime.getFullYear()-1);
				inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
				break;
			default:
		}
		return inputdate;
}

function select_article(stype){
	$('input.delpost').each(function(){
		if (stype=='all')
		{
			$(this).prop('checked',true);
		}else if(stype=='no'){
			if ($(this).prop('checked'))
			{
				$(this).prop('checked',false);
			}else{
				$(this).prop('checked',true);
			}
		}
	});
	chose_article_count();
}


function select_article_submit(url,tips)
{
	var ids = "";
	$('input.delpost:checked').each(function(){
		if (ids=="")
		{
			ids = $(this).val();
		}else{
			ids = ids+"_"+$(this).val();
		}
	});
	if(ids=='')
	{
		alert('未选择任何内容！');
		return false;
	}
	else
	{
		if (tips=='')
		{
			window.location.href=url+"&id="+ids;
		}else{
			if (confirm(tips)){
				window.location.href=url+"&id="+ids;
			}else{
				return false
			}
		}
		
	}
}
function list_chose_article(){//文章快捷键选择
	var last_click=0;
	$('.article_checkbox input').click(function(e){
		if ($(this).prop('checked'))
		{
			if (e.shiftKey==1)
			{
				now_select_id=$('.article_checkbox input').index(this);
				console.log(last_click+"|"+now_select_id);
				if (last_click>now_select_id)
				{
					$('.article_checkbox input').each(function(index){
						if (index>=now_select_id && index<=last_click){$(this).prop('checked',true);}
					});
				}else if(last_click<now_select_id){
					$('.article_checkbox input').each(function(index){
						if (index>=last_click && index<=now_select_id){$(this).prop('checked',true);}
					});
				}
				last_click=now_select_id;
			}else{
				last_click=$('.article_checkbox input').index(this);
			}
		}
		chose_article_count();
	});
}
function chose_article_count(){
	if ($('.article_checkbox input:checked').length>999)
	{
		thiscount=$('.article_checkbox input:checked').length;
	}else if($('.article_checkbox input:checked').length>99){
		thiscount="&nbsp;"+$('.article_checkbox input:checked').length;
	}else if($('.article_checkbox input:checked').length>9){
		thiscount="&nbsp;"+$('.article_checkbox input:checked').length+"&nbsp;";
	}else{
		thiscount="&nbsp;&nbsp;"+$('.article_checkbox input:checked').length+"&nbsp;&nbsp;";
	}
	$('.chose_article_count').html(thiscount);
}