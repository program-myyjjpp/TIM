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
<div data-app-id="{{z(class)|upset_class()}}" class="page-title-area" style="background-image: url({{z(works_banner_img)}})">
    <div data-app-id="{{z(class)|upset_class()}}" class="d-table">
        <div data-app-id="{{z(class)|upset_class()}}" class="d-table-cell">
            <div data-app-id="{{z(class)|upset_class()}}" class="container">
                <div data-app-id="{{z(class)|upset_class()}}" class="page-title-content">
                    <h2>{{i(name)}}</h2>
                    <ul>
                        <li>
                            <a href="{{host}}">Home</a>
                        </li>
                        <li>Our Works</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<section data-app-id="{{z(class)|upset_class()}}" class="portfolio-area section-padding">
    <div data-app-id="{{z(class)|upset_class()}}" class="container">
        <div data-app-id="{{z(class)|upset_class()}}" class="portfolio-container">
            <div data-app-id="{{z(class)|upset_class()}}" class="row">
                {{$set=array()}}
                {{$set['cid']=`cid}}
                {{$set['pagesize']=12}}
                {{$set['column']=id,title,content,shijian,pic}}
                {{$articles=alist($set)}}
                {{loop $articles['list'] as $a}}
                <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-4 col-md-6 portfolio-grid-item all branding">
                    <div data-app-id="{{z(class)|upset_class()}}" class="portfolio-item">
                        <img src="{{$a['pic']}}" alt="{{$a['title']}}">
                        <div data-app-id="{{z(class)|upset_class()}}" class="portfolio-content-overlay">
                            <h3>
                                <a href="{{$a['link']}}">{{$a['title']}}</a>
                            </h3>
                        </div>
                    </div>
                </div>
                {{/loop}}
            </div>
        </div>
    </div>
</section>
<section data-app-id="{{z(class)|upset_class()}}" class="footer-subscribe-wrapper">
{{file footer}}
</body>
</html>