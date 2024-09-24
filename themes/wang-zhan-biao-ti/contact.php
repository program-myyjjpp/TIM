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
<div data-app-id="{{z(class)|upset_class()}}" class="page-title-area" style="background-image: url({{z(contact_banner_img)}})">
    <div data-app-id="{{z(class)|upset_class()}}" class="d-table">
        <div data-app-id="{{z(class)|upset_class()}}" class="d-table-cell">
            <div data-app-id="{{z(class)|upset_class()}}" class="container">
                <div data-app-id="{{z(class)|upset_class()}}" class="page-title-content">
                    <h2>{{i(name)}}</h2>
                    <ul>
                        <li>
                            <a href="{{host}}">Home</a>
                        </li>
                        <li>Contact Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div data-app-id="{{z(class)|upset_class()}}" class="contact-section section-padding">
    <div data-app-id="{{z(class)|upset_class()}}" class="container">
        <div data-app-id="{{z(class)|upset_class()}}" class="section-title">
            <h6 data-app-id="{{z(class)|upset_class()}}" class="sub-title">Let's Talk</h6>
            <h2>{{i(name)}}</h2>
        </div>
        <div data-app-id="{{z(class)|upset_class()}}" class="row align-items-center">
            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-10 offset-lg-1">
                <div data-app-id="{{z(class)|upset_class()}}" class="contact-form">
                    <p data-app-id="{{z(class)|upset_class()}}" class="form-message"></p>
                    <form id="contact-form" data-app-id="{{z(class)|upset_class()}}" class="contact-form form" action="{{host}}" method="POST">
                        <div data-app-id="{{z(class)|upset_class()}}" class="row">
                            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-6 col-md-6">
                                <div data-app-id="{{z(class)|upset_class()}}" class="form-group">
                                    <input type="text" name="name" id="name" data-app-id="{{z(class)|upset_class()}}" class="form-control" required="" placeholder="Your Name">
                                </div>
                            </div>
                            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-6 col-md-6">
                                <div data-app-id="{{z(class)|upset_class()}}" class="form-group">
                                    <input type="email" name="email" id="email" data-app-id="{{z(class)|upset_class()}}" class="form-control" required="" placeholder="Your Email">
                                </div>
                            </div>
                            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-6 col-md-6">
                                <div data-app-id="{{z(class)|upset_class()}}" class="form-group">
                                    <input type="text" name="phone" id="phone" required="" data-app-id="{{z(class)|upset_class()}}" class="form-control" placeholder="Your Phone">
                                </div>
                            </div>
                            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-6 col-md-6">
                                <div data-app-id="{{z(class)|upset_class()}}" class="form-group">
                                    <input type="text" name="subject" id="subject" data-app-id="{{z(class)|upset_class()}}" class="form-control" required="" placeholder="Your Subject">
                                </div>
                            </div>
                            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-12 col-md-12">
                                <div data-app-id="{{z(class)|upset_class()}}" class="form-group">
                                    <textarea name="message" data-app-id="{{z(class)|upset_class()}}" class="form-control" id="message" cols="30" rows="6" required="" placeholder="Your Message"></textarea>
                                </div>
                            </div>
                            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-12 col-md-12">
                                <button type="submit" data-app-id="{{z(class)|upset_class()}}" class="default-btn submit-btn">Send Message <span></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<section data-app-id="{{z(class)|upset_class()}}" class="contact-info-wrapper bg-grey">
    <div data-app-id="{{z(class)|upset_class()}}" class="container">
        <div data-app-id="{{z(class)|upset_class()}}" class="row">
            <div data-app-id="{{z(class)|upset_class()}}" class="col-md-12">
                <div data-app-id="{{z(class)|upset_class()}}" class="section-title">
                    <h6 data-app-id="{{z(class)|upset_class()}}" class="sub-title">Find Us</h6>
                    <h2>Contact Info</h2>
                </div>
            </div>
            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-4 col-md-6">
                <div data-app-id="{{z(class)|upset_class()}}" class="contact-info-content">
                    <p>{{z(address)}}.</p>
                    <a href="tel:{{z(phone)}}">{{z(phone)}}</a>
                    <a href="mailto:{{z(email)}}">{{z(email)}}</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section data-app-id="{{z(class)|upset_class()}}" class="footer-subscribe-wrapper">
{{file footer}}
</body>
</html>