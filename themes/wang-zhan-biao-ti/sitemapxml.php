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
function listsite(){
    $channels=c(0,10,0,1);
    $uppercase_strings = array(); // 初始化一个空数组
    foreach($channels as $channel){
        $uppercase_strings[] = $channel['url'];
    }
        return $uppercase_strings;
}
function articlesite($value){
    $set=array();
    $set['cid']=0;
    $set['pagesize']=5000;
    $set['column']=$value;//'id,shijian'
    $articles=alist($set);
    $article_strings = array();
    foreach($articles['list'] as $a){
        $article_strings[] = $a;
    }
        return $article_strings;
}
    
    $site_url = domain();
    $categories = listsite();
    $articles = articlesite('id,shijian');
    //生成 sitemap.xml 文件
    $xml = new DOMDocument('1.0', 'UTF-8');
    $xml->formatOutput = true;
    $root = $xml->createElement('urlset');
    $root->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    $xml->appendChild($root);

//循环生成栏目URL
/*foreach ($categories as $category) {
    $url = $xml->createElement('url');
    $loc = $xml->createElement('loc', $site_url . $category);
    $changefreq = $xml->createElement('changefreq', 'always');
    $priority = $xml->createElement('priority', '1.0');
    $url->appendChild($loc);
    $url->appendChild($changefreq);
    $url->appendChild($priority);
    $root->appendChild($url);
}*/

//循环生成文章URL
foreach ($articles as $article) {
    $url = $xml->createElement('url');
    $loc = $xml->createElement('loc', $site_url . $article['link']);
    $lastmod = $xml->createElement('lastmod', date('Y-m-d H:i:s',$article['shijian']));
    $changefreq = $xml->createElement('changefreq', 'always');
    $priority = $xml->createElement('priority', '1.0');
    $url->appendChild($loc);
    $url->appendChild($lastmod);
    $url->appendChild($changefreq);
    $url->appendChild($priority);
    $root->appendChild($url);
}

//将生成的 XML 内容保存到 sitemap.xml 文件中
//$xml->save('sitemap.xml');
header('Content-type: text/xml');
echo $xml->saveXML();
