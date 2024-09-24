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


define('cookiehash',substr(md5(SiteHash),0,6));
//常用栏目
$common_channel=array(
//array(1,'关于我们'),
//array(2,'产品中心'),
//array(2,'新闻中心'),
//array(1,'联系方式'),
//array(2,'友情链接'),
);

//常用字段
$common_moudle=array(
array(1,'title','标题'),
array(1,'keywords','关键词'),
array(2,'description','描述'),
array(9,'shijian','时间'),
array(7,'aorder','排序'),
array(5,'pic','图片'),
array(6,'pics','多图'),
array(4,'content','内容'),
array(1,'url','网址'),
array(26,'ifcheck','勾选框'),
array(11,'fid','列表框'),
array(10,'fids','多选框'),
array(16,'color','颜色'),
);

//常用变量
$common_var=array(
array(1,'栏目标题'),
array(1,'栏目关键词'),
array(2,'栏目描述'),
array(5,'栏目图片'),
array(4,'内容'),
);

//定义允许上传的文件扩展名
$ext_arr = array(
	'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp','blob','psd','webp'),
	'flash' => array('swf'),
	'media' => array('flv', 'mp3','mp4','wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
	'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'txt', 'zip', 'rar', 'gz', 'bz2','pdf','rar','tar','torrent','apk','ipa'),
);

//默认新增栏目配置文件
//单页栏目
$default_channel_setting['default_1']='eyJpbmZvIjp7ImNpZCI6IjYyIiwiMCI6IjYyIiwiZmlkIjoiMCIsIjEiOiIwIiwiY25hbWUiOiJcdTllZDhcdThiYTRcdTUzNTVcdTk4NzVcdTY4MGZcdTc2ZWUiLCIyIjoiXHU5ZWQ4XHU4YmE0XHU1MzU1XHU5ODc1XHU2ODBmXHU3NmVlIiwiY2tpbmQiOiIxIiwiMyI6IjEiLCJpZnNob3ciOiIxIiwiNCI6IjEiLCJpZnNob3duYXYiOiIxIiwiNSI6IjEiLCJpZnNob3dhZG1pbiI6IjEiLCI2IjoiMSIsIm5ld3dpbmRvdyI6IjAiLCI4IjoiMCIsImNvcmRlciI6IjUwIiwiOSI6IjUwIiwiY3NldHRpbmciOiJ7XCJjaGFubmVsX3VybFwiOlwiXFxcLyhjaWQpXFxcL1wiLFwidGVtcGxhdGVcIjpcInBhZ2UucGhwXCIsXCJjaGFubmVsX3VybGNhY2hlXCI6MCxcImNoYW5uZWxfcGFnZXVybFwiOlwiXFxcLyhjaWQpXFxcL3BhZ2VfKHBhZ2UpLmh0bWxcIixcInRlbXBsYXRlbGlzdFwiOlwibGlzdC5waHBcIixcImNoYW5uZWxfcGFnZXVybGNhY2hlXCI6XCIwXCIsXCJjaGFubmVsX2FydGljbGV1cmxcIjpcIlxcXC8oY2lkKVxcXC8oaWQpLmh0bWxcIixcInRlbXBsYXRlYXJ0aWNsZVwiOlwiYXJ0aWNsZS5waHBcIixcImNoYW5uZWxfYXJ0aWNsZXVybGNhY2hlXCI6XCIwXCIsXCJ0ZW1wcGFnZV9zaXplXCI6MTUsXCJ0ZW1wcGFnZV9vcmRlclwiOlwiaWQgZGVzY1wiLFwibGlzdGFkbWludWlkXCI6MSxcImNub3RlXCI6XCJcXHU5ZWQ4XFx1OGJhNFxcdTUzNTVcXHU5ODc1XFx1NjgwZlxcdTc2ZWVcIixcImNoYW5uZWxfZG9tYWluXCI6XCJcIixcIm90aGVycGFnZVwiOlwiW11cIn0iLCIxMCI6IntcImNoYW5uZWxfdXJsXCI6XCJcXFwvKGNpZClcXFwvXCIsXCJ0ZW1wbGF0ZVwiOlwicGFnZS5waHBcIixcImNoYW5uZWxfdXJsY2FjaGVcIjowLFwiY2hhbm5lbF9wYWdldXJsXCI6XCJcXFwvKGNpZClcXFwvcGFnZV8ocGFnZSkuaHRtbFwiLFwidGVtcGxhdGVsaXN0XCI6XCJsaXN0LnBocFwiLFwiY2hhbm5lbF9wYWdldXJsY2FjaGVcIjpcIjBcIixcImNoYW5uZWxfYXJ0aWNsZXVybFwiOlwiXFxcLyhjaWQpXFxcLyhpZCkuaHRtbFwiLFwidGVtcGxhdGVhcnRpY2xlXCI6XCJhcnRpY2xlLnBocFwiLFwiY2hhbm5lbF9hcnRpY2xldXJsY2FjaGVcIjpcIjBcIixcInRlbXBwYWdlX3NpemVcIjoxNSxcInRlbXBwYWdlX29yZGVyXCI6XCJpZCBkZXNjXCIsXCJsaXN0YWRtaW51aWRcIjoxLFwiY25vdGVcIjpcIlxcdTllZDhcXHU4YmE0XFx1NTM1NVxcdTk4NzVcXHU2ODBmXFx1NzZlZVwiLFwiY2hhbm5lbF9kb21haW5cIjpcIlwiLFwib3RoZXJwYWdlXCI6XCJbXVwifSIsImN2YWx1ZSI6IiIsIjExIjoiIn0sInN0ciI6W3siaWQiOiIxNTYiLCJzdHJjaWQiOiI2MiIsInN0cm5hbWUiOiJcdTY4MGZcdTc2ZWVcdTY4MDdcdTk4OTgiLCJzdHJ2YWx1ZSI6IiIsInN0cmluZm8iOiIiLCJzdHJzdHlsZSI6IiIsImlmc2hvdyI6IjAiLCJpZmJpbmQiOiIwIiwiaW5wdXRraW5kIjoiMSIsInN0cm9yZGVyIjoiNSIsInN0cmFycmF5IjoiIiwic3NldHRpbmciOiIiLCJzdHJ0aXAiOiIiLCJzdHJmcm9tIjpudWxsfSx7ImlkIjoiMTU3Iiwic3RyY2lkIjoiNjIiLCJzdHJuYW1lIjoiXHU2ODBmXHU3NmVlXHU1MTczXHU5NTJlXHU4YmNkIiwic3RydmFsdWUiOiIiLCJzdHJpbmZvIjoiIiwic3Ryc3R5bGUiOiIiLCJpZnNob3ciOiIwIiwiaWZiaW5kIjoiMCIsImlucHV0a2luZCI6IjEiLCJzdHJvcmRlciI6IjEwIiwic3RyYXJyYXkiOiIiLCJzc2V0dGluZyI6IiIsInN0cnRpcCI6IiIsInN0cmZyb20iOm51bGx9LHsiaWQiOiIxNTgiLCJzdHJjaWQiOiI2MiIsInN0cm5hbWUiOiJcdTY4MGZcdTc2ZWVcdTYzY2ZcdThmZjAiLCJzdHJ2YWx1ZSI6IiIsInN0cmluZm8iOiIiLCJzdHJzdHlsZSI6IiIsImlmc2hvdyI6IjAiLCJpZmJpbmQiOiIwIiwiaW5wdXRraW5kIjoiMiIsInN0cm9yZGVyIjoiMTUiLCJzdHJhcnJheSI6IiIsInNzZXR0aW5nIjoiIiwic3RydGlwIjoiIiwic3RyZnJvbSI6bnVsbH0seyJpZCI6IjE1OSIsInN0cmNpZCI6IjYyIiwic3RybmFtZSI6Ilx1NTE4NVx1NWJiOSIsInN0cnZhbHVlIjoiIiwic3RyaW5mbyI6IiIsInN0cnN0eWxlIjoiIiwiaWZzaG93IjoiMCIsImlmYmluZCI6IjAiLCJpbnB1dGtpbmQiOiI0Iiwic3Ryb3JkZXIiOiIyMCIsInN0cmFycmF5IjoiIiwic3NldHRpbmciOiIiLCJzdHJ0aXAiOiIiLCJzdHJmcm9tIjpudWxsfV19';
//文章栏目
$default_channel_setting['default_2']='eyJpbmZvIjp7ImNpZCI6IjU3IiwiMCI6IjU3IiwiZmlkIjoiMCIsIjEiOiIwIiwiY25hbWUiOiJcdTllZDhcdThiYTRcdTY1ODdcdTdhZTBcdTY4MGZcdTc2ZWUiLCIyIjoiXHU5ZWQ4XHU4YmE0XHU2NTg3XHU3YWUwXHU2ODBmXHU3NmVlIiwiY2tpbmQiOiIyIiwiMyI6IjIiLCJpZnNob3ciOiIxIiwiNCI6IjEiLCJpZnNob3duYXYiOiIxIiwiNSI6IjEiLCJpZnNob3dhZG1pbiI6IjEiLCI2IjoiMSIsIm5ld3dpbmRvdyI6IjAiLCI4IjoiMCIsImNvcmRlciI6IjUwIiwiOSI6IjUwIiwiY3NldHRpbmciOiJ7XCJjaGFubmVsX3VybFwiOlwiXFxcLyhjaWQpXFxcL1wiLFwidGVtcGxhdGVcIjpcImxpc3QucGhwXCIsXCJjaGFubmVsX3VybGNhY2hlXCI6MCxcImNoYW5uZWxfcGFnZXVybFwiOlwiXFxcLyhjaWQpXFxcL3BhZ2VfKHBhZ2UpLmh0bWxcIixcInRlbXBsYXRlbGlzdFwiOlwibGlzdC5waHBcIixcImNoYW5uZWxfcGFnZXVybGNhY2hlXCI6MCxcImNoYW5uZWxfYXJ0aWNsZXVybFwiOlwiXFxcLyhjaWQpXFxcLyhpZCkuaHRtbFwiLFwidGVtcGxhdGVhcnRpY2xlXCI6XCJhcnRpY2xlLnBocFwiLFwiY2hhbm5lbF9hcnRpY2xldXJsY2FjaGVcIjowLFwiYXJ0aWNsZXRhYmxlXCI6XCJcIixcInRlbXBwYWdlX3NpemVcIjoxNSxcInRlbXBwYWdlX29yZGVyXCI6XCJpZCBkZXNjXCIsXCJsaXN0YWRtaW51aWRcIjoxLFwiY25vdGVcIjpcIlxcdTllZDhcXHU4YmE0XFx1NjU4N1xcdTdhZTBcXHU2ODBmXFx1NzZlZVxcdTkxNGRcXHU3ZjZlXCIsXCJjaGFubmVsX2RvbWFpblwiOlwiXCIsXCJvdGhlcnBhZ2VcIjpcIltdXCIsXCJsaXN0bm9hZGRcIjowLFwibGlzdG5vZWRpdFwiOjAsXCJsaXN0bm9kZWxcIjowLFwibGlzdGNvcHlcIjowLFwibGlzdHNob3dhZG1pbm5hbWVcIjowfSIsIjEwIjoie1wiY2hhbm5lbF91cmxcIjpcIlxcXC8oY2lkKVxcXC9cIixcInRlbXBsYXRlXCI6XCJsaXN0LnBocFwiLFwiY2hhbm5lbF91cmxjYWNoZVwiOjAsXCJjaGFubmVsX3BhZ2V1cmxcIjpcIlxcXC8oY2lkKVxcXC9wYWdlXyhwYWdlKS5odG1sXCIsXCJ0ZW1wbGF0ZWxpc3RcIjpcImxpc3QucGhwXCIsXCJjaGFubmVsX3BhZ2V1cmxjYWNoZVwiOjAsXCJjaGFubmVsX2FydGljbGV1cmxcIjpcIlxcXC8oY2lkKVxcXC8oaWQpLmh0bWxcIixcInRlbXBsYXRlYXJ0aWNsZVwiOlwiYXJ0aWNsZS5waHBcIixcImNoYW5uZWxfYXJ0aWNsZXVybGNhY2hlXCI6MCxcImFydGljbGV0YWJsZVwiOlwiXCIsXCJ0ZW1wcGFnZV9zaXplXCI6MTUsXCJ0ZW1wcGFnZV9vcmRlclwiOlwiaWQgZGVzY1wiLFwibGlzdGFkbWludWlkXCI6MSxcImNub3RlXCI6XCJcXHU5ZWQ4XFx1OGJhNFxcdTY1ODdcXHU3YWUwXFx1NjgwZlxcdTc2ZWVcXHU5MTRkXFx1N2Y2ZVwiLFwiY2hhbm5lbF9kb21haW5cIjpcIlwiLFwib3RoZXJwYWdlXCI6XCJbXVwiLFwibGlzdG5vYWRkXCI6MCxcImxpc3Rub2VkaXRcIjowLFwibGlzdG5vZGVsXCI6MCxcImxpc3Rjb3B5XCI6MCxcImxpc3RzaG93YWRtaW5uYW1lXCI6MH0iLCJjdmFsdWUiOiIiLCIxMSI6IiJ9LCJtb3VkbGUiOlt7ImlkIjoiMjM1IiwiY2lkIjoiNTciLCJmaWQiOiIiLCJtbmFtZSI6InRpdGxlIiwibWluZm8iOiJcdTY4MDdcdTk4OTgiLCJtY29udGVudCI6IiIsIm1raW5kIjoiMSIsIm1vcmRlciI6IjUiLCJpZnNob3ciOiIxIiwiaWZvbmx5IjoiMCIsImlmYWRtaW4iOiIwIiwiaWZtb3JlIjoiMCIsImhpZGUiOiIwIiwiaWZzaG93dGVtcCI6IiIsInN0cmFycmF5IjoiIiwic3RyZGVmYXVsdCI6IiIsIm1zZXR0aW5nIjoie1wiZmlsdGVyaHRtbFwiOjEsXCJhZG1pbnNlYXJjaFwiOjF9IiwibXJlZ3VsYXIiOiIiLCJtZnVuY3Rpb24iOiIiLCJzdHJmcm9tIjpudWxsfSx7ImlkIjoiMjM2IiwiY2lkIjoiNTciLCJmaWQiOiIiLCJtbmFtZSI6ImtleXdvcmRzIiwibWluZm8iOiJcdTUxNzNcdTk1MmVcdThiY2QiLCJtY29udGVudCI6IiIsIm1raW5kIjoiMSIsIm1vcmRlciI6IjEwIiwiaWZzaG93IjoiMCIsImlmb25seSI6IjAiLCJpZmFkbWluIjoiMCIsImlmbW9yZSI6IjAiLCJoaWRlIjoiMCIsImlmc2hvd3RlbXAiOiIiLCJzdHJhcnJheSI6IiIsInN0cmRlZmF1bHQiOiIiLCJtc2V0dGluZyI6IntcImZpbHRlcmh0bWxcIjoxfSIsIm1yZWd1bGFyIjoiIiwibWZ1bmN0aW9uIjoiIiwic3RyZnJvbSI6bnVsbH0seyJpZCI6IjIzNyIsImNpZCI6IjU3IiwiZmlkIjoiIiwibW5hbWUiOiJkZXNjcmlwdGlvbiIsIm1pbmZvIjoiXHU2M2NmXHU4ZmYwIiwibWNvbnRlbnQiOiIiLCJta2luZCI6IjIiLCJtb3JkZXIiOiIxNSIsImlmc2hvdyI6IjAiLCJpZm9ubHkiOiIwIiwiaWZhZG1pbiI6IjAiLCJpZm1vcmUiOiIwIiwiaGlkZSI6IjAiLCJpZnNob3d0ZW1wIjoiIiwic3RyYXJyYXkiOiIiLCJzdHJkZWZhdWx0IjoiIiwibXNldHRpbmciOiJ7XCJmaWx0ZXJodG1sXCI6MX0iLCJtcmVndWxhciI6IiIsIm1mdW5jdGlvbiI6IiIsInN0cmZyb20iOm51bGx9LHsiaWQiOiIyMzgiLCJjaWQiOiI1NyIsImZpZCI6IiIsIm1uYW1lIjoiY29udGVudCIsIm1pbmZvIjoiXHU1MTg1XHU1YmI5IiwibWNvbnRlbnQiOiIiLCJta2luZCI6IjQiLCJtb3JkZXIiOiIyMCIsImlmc2hvdyI6IjAiLCJpZm9ubHkiOiIwIiwiaWZhZG1pbiI6IjAiLCJpZm1vcmUiOiIwIiwiaGlkZSI6IjAiLCJpZnNob3d0ZW1wIjoiIiwic3RyYXJyYXkiOiIiLCJzdHJkZWZhdWx0IjoiIiwibXNldHRpbmciOiJ7XCJmaWx0ZXJodG1sXCI6MX0iLCJtcmVndWxhciI6IiIsIm1mdW5jdGlvbiI6IiIsInN0cmZyb20iOm51bGx9XSwic3RyIjpbeyJpZCI6IjE0NCIsInN0cmNpZCI6IjU3Iiwic3RybmFtZSI6Ilx1NjgwZlx1NzZlZVx1NjgwN1x1OTg5OCIsInN0cnZhbHVlIjoiIiwic3RyaW5mbyI6IiIsInN0cnN0eWxlIjoiIiwiaWZzaG93IjoiMCIsImlmYmluZCI6IjAiLCJpbnB1dGtpbmQiOiIxIiwic3Ryb3JkZXIiOiI1Iiwic3RyYXJyYXkiOiIiLCJzc2V0dGluZyI6IiIsInN0cnRpcCI6IiIsInN0cmZyb20iOm51bGx9LHsiaWQiOiIxNDUiLCJzdHJjaWQiOiI1NyIsInN0cm5hbWUiOiJcdTY4MGZcdTc2ZWVcdTUxNzNcdTk1MmVcdThiY2QiLCJzdHJ2YWx1ZSI6IiIsInN0cmluZm8iOiIiLCJzdHJzdHlsZSI6IiIsImlmc2hvdyI6IjAiLCJpZmJpbmQiOiIwIiwiaW5wdXRraW5kIjoiMSIsInN0cm9yZGVyIjoiMTAiLCJzdHJhcnJheSI6IiIsInNzZXR0aW5nIjoiIiwic3RydGlwIjoiIiwic3RyZnJvbSI6bnVsbH0seyJpZCI6IjE0NiIsInN0cmNpZCI6IjU3Iiwic3RybmFtZSI6Ilx1NjgwZlx1NzZlZVx1NjNjZlx1OGZmMCIsInN0cnZhbHVlIjoiIiwic3RyaW5mbyI6IiIsInN0cnN0eWxlIjoiIiwiaWZzaG93IjoiMCIsImlmYmluZCI6IjAiLCJpbnB1dGtpbmQiOiIyIiwic3Ryb3JkZXIiOiIxNSIsInN0cmFycmF5IjoiIiwic3NldHRpbmciOiIiLCJzdHJ0aXAiOiIiLCJzdHJmcm9tIjpudWxsfSx7ImlkIjoiMTQ3Iiwic3RyY2lkIjoiNTciLCJzdHJuYW1lIjoiXHU1MTg1XHU1YmI5Iiwic3RydmFsdWUiOiIiLCJzdHJpbmZvIjoiIiwic3Ryc3R5bGUiOiIiLCJpZnNob3ciOiIwIiwiaWZiaW5kIjoiMCIsImlucHV0a2luZCI6IjQiLCJzdHJvcmRlciI6IjIwIiwic3RyYXJyYXkiOiIiLCJzc2V0dGluZyI6IiIsInN0cnRpcCI6IiIsInN0cmZyb20iOm51bGx9XX0=';


//后台钩子动作列表
//leftnav 左侧栏目导航循环时
//index 文章列表页表格之前,可以输出html
//list 文章列表页读取文章列表之前,可以修改读取参数
//listrow 文章列表页文章循环时
//listrowaction 文章列表页文章循环时 操作框内
//listsearch 文章列表页搜索框
//listaction 文章列表页批量勾选提交
//add 文章添加页
//addpost 文章添加提交页
//addposted 文章添加成功时
//edit 文章编辑页
//editpost 文章编辑提交页
//editposted 文章编辑成功后
//delete 文章删除前
//deleted 文章删除后
//move 文章转移前 
//moved 文章转移成功后
//stredited 变量编辑成功后
//演示:admin_hook(1,'index','indexshow');在后台访问栏目id为1的栏目的列表页时将会运行indexshow的函数
//演示:admin_hook(1,'addpost;editpost','SaveRomoteImg');栏目id为1的栏目文章(增加或编辑)提交时运行SaveRomoteImg函数
