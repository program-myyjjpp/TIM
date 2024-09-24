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

/*$channels=c(0,10,0,1);
foreach ($channels as $channel) {
    echo domain().$channel['url']."\r\n";
}*/
$set=array();
$set['cid']=0;
$set['pagesize']=5000;
$set['column']='id';
$articles=alist($set);
foreach ($articles['list'] as $a){
    echo domain().$a['link']."\r\n";
}