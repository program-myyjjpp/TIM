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
 
 
if (extension_loaded('zlib')){ob_end_clean();ob_start('ob_gzhandler');}else{ob_end_clean();ob_start();}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<title>404 not found</title>
<link rel="stylesheet" href="{{host}}{{tempdir}}/style.css">
<style>
     .box__button {
        display: block;
        position: relative;
        background: #FF5E65;
        border: 1px solid transparent;
        border-radius: 50px;
        height: 50px;
        text-align: center;
        text-decoration: none;
        color: #fff;
        line-height: 50px;
        font-size: 18px;
        padding: 0 70px;
        white-space: nowrap;
        margin-top: 25px;
        transition: background .5s ease;
        overflow: hidden;
    }

     .box__button:before {
        content: '';
        position: absolute;
        width: 20px;
        height: 100px;
        background: #fff;
        bottom: -25px;
        left: 0;
        border: 2px solid #fff;
        transform: translateX(-50px) rotate(45deg);
        transition: transform .5s ease;
    }

     .box__button:hover {
        background: transparent;
        border-color: #fff;
    }

     .box__button:hover:before {
        transform: translateX(250px) rotate(45deg);
    }
</style>
</head>
<body>

<div>
  <aside><img src="{{host}}{{tempdir}}/404.png" alt="404 Image" />
  </aside>
  <main>
    <h1>Sorry!</h1>
    <p>
     要么你不够酷，无法访问此网页，要么它不存在<em>. . . 你的社交生活.</em>
    </p>
    <a href="{{host}}" class="box__button">返回主页！</a>
  </main>
</div>
</body>
</html>
<?php $content = ob_get_contents();$content = ltrim(rtrim(preg_replace(array("/> *([^ ]*) *</","//","'/\*[^*]*\*/'","/\r\n/","/\n/","/\t/",'/>[ ]+</'),array(">\\1<",'','','','','','><'),$content)));ob_end_clean();echo $content;?>