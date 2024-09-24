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
<div data-app-id="{{z(class)|upset_class()}}" class="page-title-area item-bg2" style="background-image: url('{{z(news_banner_img)}}')">
    <div data-app-id="{{z(class)|upset_class()}}" class="d-table">
        <div data-app-id="{{z(class)|upset_class()}}" class="d-table-cell">
            <div data-app-id="{{z(class)|upset_class()}}" class="container">
                <div data-app-id="{{z(class)|upset_class()}}" class="page-title-content">
                    <h2>{{i(name)}}</h2>
                    <ul>
                        <li>
                            <a href="{{host}}">Home</a>
                        </li>
                        <li>Our News</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<section data-app-id="{{z(class)|upset_class()}}" class="blog-section pt-100 pb-100">
    <div data-app-id="{{z(class)|upset_class()}}" class="container">
        <div data-app-id="{{z(class)|upset_class()}}" class="row">
            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-8 col-md-12">
                <div data-app-id="{{z(class)|upset_class()}}" class="row">
                    {{$set=array()}}
                    {{$set['cid']=`cid}}
                    {{$set['pagesize']=12}}
                    {{$set['page']=page}}
                    {{$set['column']=id,title,content,shijian,pic,click}}
                    {{$articles=alist($set)}}
                    {{loop $articles['list'] as $a}}
                    <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-6 col-md-6">
                        <div data-app-id="{{z(class)|upset_class()}}" class="blog-single-item">
                            <div data-app-id="{{z(class)|upset_class()}}" class="blog-image">
                                <a href="{{$a['link']}}">
                                    <img src="{{$a['pic']}}" alt="{{$a['title']}}">
                                </a>
                            </div>
                            <div data-app-id="{{z(class)|upset_class()}}" class="blog-description">
                                <ul data-app-id="{{z(class)|upset_class()}}" class="blog-info">
                                    <li>
                                        <a href="{{$a['link']}}">
                                            <i data-app-id="{{z(class)|upset_class()}}" class="bi bi-calendar-check"></i> {{$a['shijian']|date('Y-m-d H:i:s',this)}}
                                        </a>
                                    </li>
                                </ul>
                                <div data-app-id="{{z(class)|upset_class()}}" class="blog-text">
                                    <h3>
                                        <a href="{{$a['link']}}">
                                            {{$a['title']}}
                                        </a>
                                    </h3>
                                    <p>{{$a['content']|text(150)}}...</p>
                                    <div data-app-id="{{z(class)|upset_class()}}" class="blog-btn">
                                        <a href="{{$a['link']}}" data-app-id="{{z(class)|upset_class()}}" class="read-more">
                                            <i data-app-id="{{z(class)|upset_class()}}" class="bi bi-arrow-right-short"></i> 阅读
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{/loop}}
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