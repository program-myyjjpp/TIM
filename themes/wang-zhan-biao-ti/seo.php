 {{if identifyPageType($_SERVER['REQUEST_URI']) ==1 }}
 <!DOCTYPE html>
 <html lang="zh-CN">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{z(title)}}</title>
    <meta name="keywords" content="{{z(keywords)}}">
    <meta name="description" content="{{z(description)}}">
    <meta name="theme-color" content="{{z(themes_color)}}">
    <link rel="canonical" href="{{lianjie}}"/>
    <meta property="og:locale" content="zh_CN"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{z(title)}}"/>
    <meta property="og:keywords" content="{{z(keywords)}}"/>
    <meta property="og:description" content="{{z(description)}}"/>
    <meta property="og:url" content="{{lianjie}}"/>
    <meta property="og:site_name" content="{{z(title)}}"/>
    <meta property="og:image" content="{{host}}{{z(logo)}}"/>
    <meta property="og:image:secure_url" content="{{host}}{{z(logo)}}"/>
    <meta property="og:image:type" content="image/png"/>
    <link rel="icon" href="{{host}}/uploads/images/icon/favicon.ico" type="image/x-icon">
 {{elseif identifyPageType($_SERVER['REQUEST_URI']) ==2}}
 <!DOCTYPE html>
 <html lang="zh-CN">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>{{i(name)}} - {{z(title)}}</title>
     <meta name="keywords" content="{{i(name)}}">
     <meta name="description" content="{{i(name)}}">
     <meta name="theme-color" content="{{z(themes_color)}}">
     <link rel="canonical" href="{{lianjie}}"/>
     <meta property="og:locale" content="zh_CN"/>
     <meta property="og:type" content="website"/>
     <meta property="og:title" content="{{i(name)}}"/>
     <meta property="og:keywords" content="{{i(name)}}"/>
     <meta property="og:description" content="{{i(name)}}"/>
     <meta property="og:url" content="{{lianjie}}"/>
     <meta property="og:site_name" content="{{z(title)}}"/>
     {{if i('cid') == 2}}
     <meta property="og:image" content="{{host}}{{z(about_banner_img)}}"/>
     <meta property="og:image:secure_url" content="{{host}}{{z(about_banner_img)}}"/>
     {{elseif i('cid') == 3}}
     <meta property="og:image" content="{{host}}{{z(product_banner_img)}}"/>
     <meta property="og:image:secure_url" content="{{host}}{{z(product_banner_img)}}"/>
     {{elseif i('cid') == 4}}
     <meta property="og:image" content="{{host}}{{z(news_banner_img)}}"/>
     <meta property="og:image:secure_url" content="{{host}}{{z(news_banner_img)}}"/>
     {{elseif i('cid') == 5}}
     <meta property="og:image" content="{{host}}{{z(service_banner_img)}}"/>
     <meta property="og:image:secure_url" content="{{host}}{{z(service_banner_img)}}"/>
     {{elseif i('cid') == 5}}
     <meta property="og:image" content="{{host}}{{z(contact_banner_img)}}"/>
     <meta property="og:image:secure_url" content="{{host}}{{z(contact_banner_img)}}"/>
     {{/if}}
     <meta property="og:image:type" content="image/png"/>
     <link rel="icon" href="{{host}}/uploads/images/icon/favicon.ico" type="image/x-icon">
 {{elseif identifyPageType($_SERVER['REQUEST_URI']) ==3}}
 <!DOCTYPE html>
 <html lang="zh-CN">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>{{$article['title']}} - {{z(title)}}</title>
     <meta name="keywords" content="{{$article['title']}}">
     <meta name="description" content="{{$article['content']|text(200)}}...">
     <meta name="theme-color" content="#3baa24">
     <link rel="canonical" href="{{lianjie}}" />
     <meta property="og:locale" content="zh_CN" />
     <meta property="og:type" content="website" />
     <meta property="og:title" content="{{$article['title']}}" />
     <meta property="og:keywords" content="{{$article['title']}}" />
     <meta property="og:url" content="{{lianjie}}" />
     <meta property="og:site_name" content="{{z(title)}}" />
     <meta property="og:image" content="{{host}}{{$article['pic']}}" />
     <meta property="og:image:secure_url" content="{{host}}{{$article['pic']}}" />
     <meta property="og:image:type" content="image/png" />
     <link rel="icon" href="{{host}}/uploads/images/icon/favicon.ico" type="image/x-icon">
 {{/if}}