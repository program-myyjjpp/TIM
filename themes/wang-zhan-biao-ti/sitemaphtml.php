<?php

/**
 *  ----------------------------------------------
 * @Author:     开发时长两年半
 * @Date:       2023-03-14 16:00:00
 * @Email:      61468384@qq.com
 * @Version:    2.0(end)
 * @Blog:       https://www.tim-blog.com
 * @website:    https://www.timcms.com
 * @Desc:       简单即是美 Simple is beautiful...
 * ----------------------------------------------
 **/
 
/*清除换行*/

function domain()
{
    $http_type =
        (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ||
        (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
            ? 'https://'
            : 'http://';
    $urls = $http_type . $_SERVER['HTTP_HOST'];
    return $urls;
}
function getNextNumber() 
{
    static $num = 0;
    return ++$num;
    
}
function articleimg($str){
    $img = explode('">',explode('<img src="',$str)[1]);
    return '/'.$img[0];
}
?>
<!-- Author:开发时长两年半 -->
<!-- website:https://www.timcms.com -->
<!-- Desc:简单即是美 Simple is beautiful... -->
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    <head>
        <title>XML Sitemap — Post Type</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style type="text/css">
            body{font-family:"Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif;font-size:13px}#header,#footer{padding:2px;margin:10px;font-size:8pt;color:gray}a{color:black}td{font-size:11px}th{text-align:left;padding-right:30px;font-size:11px}tr.high{background-color:whitesmoke}#footer img{vertical-align:middle}
        </style>
    </head>
    <body>
        <h1>XML Sitemap — Post Type</h1>
        <div id="header">
            <p>开发时长两年半,简单即是美 Simple is beautiful...</p>
        </div>
        <div id="content">
            <table cellpadding="5">
                <tbody>
                    <tr>
                        <th>#</th>
                        <th>URL</th>
                        <th>title</th>
                        <th># Images</th>
                        <th>Priority</th>
                        <th>Last Modified</th>
                    </tr>
<?php
$set=array();
$set['cid']=0;
$set['pagesize']=5000;
$set['column']='id,shijian,pic,title,content';
$articles=alist($set);
foreach ($articles['list'] as $a){
?>
                    <tr>
                        <td><?=$a['key']?></td>
                        <td>
                            <a href="<?=domain().$a['link']?>"><?=domain().$a['link']?></a>
                        </td>
                        <td><?=$a['title']?></td>
                        <td><?=domain().($a['pic'])?></td>
                        <td>50%</td>
                        <td><?=date('Y-m-d H:i:s',$a['shijian'])?></td>
                    </tr>
<?php } ?>
                </tbody>
            </table>
        </div>
        <div id="footer">
            <p>
                <img src="data:image/gif;base64,R0lGODlhUAAPAJEAAGZmZv////9mAImOeSwAAAAAUAAPAAACoISPqcvtD0+YtNqLs968myCE4kiW5jkGw8q27gvDwYfWdq3G+i7T9w/M8Ya7GQAUoiSTEyYSKYA2nSKhdXUdCIlaXzRVDVdB0+dS2lJZ1bkt0Sgti6NysvM5jbq2ai2WywJHYrZUaEhIWJXm99foNiRI9XUoV4g4GJjJyEgBGAkEivIIyPUZeppCqorlheo6ulr00UFba3uLEaG7y9urUAAAOw%3D%3D" alt="XML Sitemap" title="XML Sitemap"> &amp; XML Sitemap .</p>
        </div>
    </body>
</html>