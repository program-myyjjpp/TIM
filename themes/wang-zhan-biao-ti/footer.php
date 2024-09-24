<div data-app-id="{{z(class)|upset_class()}}" class="footer-area ptb-100">
    <div data-app-id="{{z(class)|upset_class()}}" class="container">
        <div data-app-id="{{z(class)|upset_class()}}" class="row">
            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-4 col-md-6 col-sm-6">
                <div data-app-id="{{z(class)|upset_class()}}" class="single-footer-widget">
                    <a data-app-id="{{z(class)|upset_class()}}" class="footer-logo" href="{{host}}">
                        <img src="{{z(logo)}}" data-app-id="{{z(class)|upset_class()}}" class="white-logo" alt="<?php echo explode_array("&#x2c;",z('keywords'),0) ?>">
                    </a>
                    <p>{{z(description)}}</p>
                    <ul data-app-id="{{z(class)|upset_class()}}" class="footer-social">
                        <li>
                            <a href="{{host}}">
                                <i data-app-id="{{z(class)|upset_class()}}" class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{host}}">
                                <i data-app-id="{{z(class)|upset_class()}}" class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{host}}">
                                <i data-app-id="{{z(class)|upset_class()}}" class="fab fa-youtube"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{host}}">
                                <i data-app-id="{{z(class)|upset_class()}}" class="fab fa-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-2 col-md-6 col-sm-6">
                <div data-app-id="{{z(class)|upset_class()}}" class="single-footer-widget">
                    <div data-app-id="{{z(class)|upset_class()}}" class="footer-heading">
                        <h3>导航</h3>
                    </div>
                    <ul data-app-id="{{z(class)|upset_class()}}" class="footer-quick-links">
                        {{$channels=c(0,999,0,1)}}
                        {{loop $channels as $channel}}
                        {{if $channel['cid']!=1}}
                        <li>
                            <a href="{{$channel['url']}}">{{$channel['name']}}</a>
                        </li>
                        {{/if}}
                        {{/loop}}
                    </ul>
                </div>
            </div>
            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-2 col-md-6 col-sm-6">
                <div data-app-id="{{z(class)|upset_class()}}" class="single-footer-widget">
                    <div data-app-id="{{z(class)|upset_class()}}" class="footer-heading">
                        <h3>网站地图</h3>
                    </div>
                    <ul data-app-id="{{z(class)|upset_class()}}" class="footer-quick-links">
                        <li>
                            <a href="{{host}}/sitemap.xml">XML</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-4 col-md-6 col-sm-6">
                <div data-app-id="{{z(class)|upset_class()}}" class="single-footer-widget">
                    <div data-app-id="{{z(class)|upset_class()}}" class="footer-heading">
                        <h3>{{i(name,6)}}</h3>
                    </div>
                    <div data-app-id="{{z(class)|upset_class()}}" class="footer-info-contact">
                        <i data-app-id="{{z(class)|upset_class()}}" class="flaticon-phone-call"></i>
                        <h3>Phone</h3>
                        <span>
                                        <a href="tel:{{z(phone)}}">{{z(phone)}}</a>
                                    </span>
                    </div>
                    <div data-app-id="{{z(class)|upset_class()}}" class="footer-info-contact">
                        <i data-app-id="{{z(class)|upset_class()}}" class="flaticon-envelope"></i>
                        <h3>Email</h3>
                        <span>
                                        <a href="mailto:{{z(email)}}">{{z(email)}}</a>
                                    </span>
                    </div>
                    <div data-app-id="{{z(class)|upset_class()}}" class="footer-info-contact">
                        <i data-app-id="{{z(class)|upset_class()}}" class="flaticon-placeholder"></i>
                        <h3>Address</h3>
                        <span>{{z(address)}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<div data-app-id="{{z(class)|upset_class()}}" class="copyright-area">
    <div data-app-id="{{z(class)|upset_class()}}" class="container">
        <div data-app-id="{{z(class)|upset_class()}}" class="row align-items-center">
            <div data-app-id="{{z(class)|upset_class()}}" class="col-lg-6 col-md-6">
                <p>
                    <i data-app-id="{{z(class)|upset_class()}}" class="far fa-copyright"></i> 2023  - All Rights Reserved <a href="{{host}}"><?php echo explode_array("&#x2c;",z('keywords'),3) ?></a> .
                </p>
            </div>
        </div>
    </div>
</div>
<div data-app-id="{{z(class)|upset_class()}}" class="go-top">
    <i data-app-id="{{z(class)|upset_class()}}" class="fas fa-chevron-up"></i>
    <i data-app-id="{{z(class)|upset_class()}}" class="fas fa-chevron-up"></i>
</div>
<script src="{{tempdir}}static/js/jquery.min.js"></script>
<script src="{{tempdir}}static/js/popper.min.js"></script>
<script src="{{tempdir}}static/js/bootstrap.bundle.min.js"></script>
<script src="{{tempdir}}static/js/jquery.meanmenu.js"></script>
<script src="{{tempdir}}static/js/jquery.appear.min.js"></script>
<script src="{{tempdir}}static/js/jquery.waypoints.min.js"></script>
<script src="{{tempdir}}static/js/jquery.counterup.min.js"></script>
<script src="{{tempdir}}static/js/owl.carousel.min.js"></script>
<script src="{{tempdir}}static/js/jquery.magnific-popup.min.js"></script>
<script src="{{tempdir}}static/js/isotope.pkgd.min.js"></script>
<script src="{{tempdir}}static/js/swiper.min.js"></script>
<script src="{{tempdir}}static/js/wow.min.js"></script>
<script src="{{tempdir}}static/js/main.js"></script>