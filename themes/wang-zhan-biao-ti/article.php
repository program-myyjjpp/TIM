{{$set=array()}}
{{$set['where']['id']=intval($_GET['id'])}}
{{$article=a($set)}}
{{if !$article}}
{{notfound()}}
{{/if}}
{{$editinfo=array()}}
{{$editinfo['id']=$article['id']}}
{{$editinfo['click']=$article['click']+1}}
{{$return=aedit($editinfo)}}
{{file seo}}
    <link href="{{tempdir}}static/css/css2-Dosiswght400500600700800_swap.css" rel="stylesheet">
    <link href="{{tempdir}}static/css/css2-Catamaranwght300400500600700800900_swap.css" rel="stylesheet">
    <link rel="stylesheet" href="{{tempdir}}static/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{tempdir}}static/css/animate.min.css">
    <link rel="stylesheet" href="{{tempdir}}static/css/flaticon.css">
    <link rel="stylesheet" href="{{tempdir}}static/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{tempdir}}static/css/bootstrap-icons.css">
    <link rel="stylesheet" href="{{tempdir}}static/css/meanmenu.css">
    <link rel="stylesheet" href="{{tempdir}}static/css/magnific-popup.min.css">
    <link rel="stylesheet" href="{{tempdir}}static/css/swiper.min.css">
    <link rel="stylesheet" href="{{tempdir}}static/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{tempdir}}static/css/style.css">
    <link rel="stylesheet" href="{{tempdir}}static/css/responsive.css">
</head>
<body>
{{file header}}
<div data-app-id="{{z(class)|upset_class()}}" class="page-title-area item-bg1" style="background-image: url({{if i('cid') == 3}} {{z(works_banner_img)}} {{elseif i('cid') == 4}} {{z(news_banner_img)}} {{/if}}">
    <div data-app-id="{{z(class)|upset_class()}}" class="d-table">
        <div data-app-id="{{z(class)|upset_class()}}" class="d-table-cell">
            <div data-app-id="{{z(class)|upset_class()}}" class="container">
                <div data-app-id="{{z(class)|upset_class()}}" class="page-title-content">
                    <h2>{{i(name)}}</h2>
                    <ul>
                        <li>
                            <a href="{{host}}">Home</a>
                        </li>
                        <li>{{$article['title']}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<section data-app-id="{{z(class)|upset_class()}}" class="blog-details-area ptb-100">
    <div data-app-id="{{z(class)|upset_class()}}" class="container">
        <div data-app-id="{{z(class)|upset_class()}}" class="row">
            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-8 col-md-12">
                <div data-app-id="{{z(class)|upset_class()}}" class="blog-details-desc">
                    <div data-app-id="{{z(class)|upset_class()}}" class="article-content">
                        <h3>{{$article['title']}}</h3>
                        <div data-app-id="{{z(class)|upset_class()}}" class="entry-meta">
                            <ul>
                                <li>
                                    <span>Posted On:</span>
                                    <a href="{{$article['link']}}">{{$article['shijian']|date('Y-m-d H:i:s',this)}}</a>
                                </li>
                            </ul>
                        </div>
                        <p>{{$article['content']}}</p>
                    </div>
                    <div data-app-id="{{z(class)|upset_class()}}" class="post-navigation">
                        <div data-app-id="{{z(class)|upset_class()}}" class="navigation-links">
                            {{$prevset=array()}}
                            {{$prevset['column']=id,title}}
                            {{$prevset['order']=id desc}}
                            {{$prevset['other']=`"id<".$article['id']}}
                            {{$prev=a($prevset)}}
                            {{if $prev}}
                            <div data-app-id="{{z(class)|upset_class()}}" class="nav-previous">
                                <a href="{{host}}{{$prev['link']}}">
                                    <i data-app-id="{{z(class)|upset_class()}}" class="fa fa-arrow-left"></i> Prev Post
                                </a>
                            </div>
                            {{/if}}
                            {{$nextset=array()}}
                            {{$nextset['column']=id,title}}
                            {{$nextset['other']=`"id>".$article['id']}}
                            {{$nextset['order']=id asc}}
                            {{$next=a($nextset)}}
                            {{if $next}}
                            <div data-app-id="{{z(class)|upset_class()}}" class="nav-next">
                                <a href="{{host}}{{$next['link']}}">Next Post <i data-app-id="{{z(class)|upset_class()}}" class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                            {{/if}}
                        </div>
                    </div>
                    <div data-app-id="{{z(class)|upset_class()}}" class="comments-area">
                        <div data-app-id="{{z(class)|upset_class()}}" class="comment-respond">
                            <h3 data-app-id="{{z(class)|upset_class()}}" class="comment-reply-title">发表评论</h3>
                            <form data-app-id="{{z(class)|upset_class()}}" class="comment-form">
                                <p data-app-id="{{z(class)|upset_class()}}" class="comment-form-comment">
                                    <label>内容</label>
                                    <textarea name="comment" id="comment" cols="45" rows="5" maxlength="65525" required="required"></textarea>
                                </p>
                                <p data-app-id="{{z(class)|upset_class()}}" class="comment-form-author">
                                    <label>姓名 <span data-app-id="{{z(class)|upset_class()}}" class="required">*</span>
                                    </label>
                                    <input type="text" id="author" name="author" required="required">
                                </p>
                                <p data-app-id="{{z(class)|upset_class()}}" class="comment-form-email">
                                    <label>邮箱 <span data-app-id="{{z(class)|upset_class()}}" class="required">*</span>
                                    </label>
                                    <input type="email" id="email" name="email" required="required">
                                </p>
                                <p data-app-id="{{z(class)|upset_class()}}" class="comment-form-url">
                                    <label>网址</label>
                                    <input type="url" id="url" name="url">
                                </p>
                                <p data-app-id="{{z(class)|upset_class()}}" class="comment-form-cookies-consent">
                                    <input type="checkbox" value="yes" name="wp-comment-cookies-consent" id="wp-comment-cookies-consent">
                                    <label for="wp-comment-cookies-consent">Save my name, email, and website in this browser for the next time I comment.</label>
                                </p>
                                <p data-app-id="{{z(class)|upset_class()}}" class="form-submit">
                                    <input type="submit" name="submit" id="submit" data-app-id="{{z(class)|upset_class()}}" class="submit" value="Post Comment">
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-4 col-md-12">
                <aside data-app-id="{{z(class)|upset_class()}}" class="widget-area" id="secondary">
                    <section data-app-id="{{z(class)|upset_class()}}" class="widget widget_search">
                        <form data-app-id="{{z(class)|upset_class()}}" class="search-form search-top">
                            <label>
                                <input type="search" data-app-id="{{z(class)|upset_class()}}" class="search-field" placeholder="Search...">
                            </label>
                            <button type="submit">
                                <i data-app-id="{{z(class)|upset_class()}}" class="fas fa-search"></i>
                            </button>
                        </form>
                    </section>
                    <section data-app-id="{{z(class)|upset_class()}}" class="widget widget_categories">
                        <h3 data-app-id="{{z(class)|upset_class()}}" class="widget-title">导航</h3>
                        <ul>
                            {{$channels=c(0,999,0,1)}}
                            {{loop $channels as $channel}}
                            {{if $channel['cid']!=1}}
                            <li>
                                <a href="{{$channel['url']}}">{{$channel['name']}}</a>
                            </li>
                            {{/if}}
                            {{/loop}}
                        </ul>
                    </section>
                </aside>
            </div>
        </div>
    </div>
</section>
<section data-app-id="{{z(class)|upset_class()}}" class="footer-subscribe-wrapper">
 {{file footer}}
</body>
</html>