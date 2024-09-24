<script src="/myyjjpp.js"></script>
<div data-app-id="{{z(class)|upset_class()}}" class="navbar-area">
    <div data-app-id="{{z(class)|upset_class()}}" class="techvio-responsive-nav index-navber-responsive">
        <div data-app-id="{{z(class)|upset_class()}}" class="container">
            <div data-app-id="{{z(class)|upset_class()}}" class="techvio-responsive-menu">
                <div data-app-id="{{z(class)|upset_class()}}" class="logo">
                    <h1>
                        <a href="{{host}}">
                            <img src="{{z(logo)}}" data-app-id="{{z(class)|upset_class()}}" class="white-logo" alt="<?php echo explode_array("&#x2c;",z('keywords'),0) ?>">
                            <img src="{{z(logo)}}" data-app-id="{{z(class)|upset_class()}}" class="black-logo" alt="<?php echo explode_array("&#x2c;",z('keywords'),0) ?>">
                        </a>
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div data-app-id="{{z(class)|upset_class()}}" class="techvio-nav index-navber">
        <div data-app-id="{{z(class)|upset_class()}}" class="container">
            <nav data-app-id="{{z(class)|upset_class()}}" class="navbar navbar-expand-md navbar-light">
                <a data-app-id="{{z(class)|upset_class()}}" class="navbar-brand" href="{{host}}">
                    <img src="{{z(logo)}}" data-app-id="{{z(class)|upset_class()}}" class="white-logo" alt="<?php echo explode_array("&#x2c;",z('keywords'),0) ?>">
                    <img src="{{z(logo)}}" data-app-id="{{z(class)|upset_class()}}" class="black-logo" alt="<?php echo explode_array("&#x2c;",z('keywords'),0) ?>">
                </a>
                <div data-app-id="{{z(class)|upset_class()}}" class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <ul data-app-id="{{z(class)|upset_class()}}" class="navbar-nav">
                        {{$channels=c(0,999,0,1)}}
                        {{loop $channels as $channel}}
                        <li data-app-id="{{z(class)|upset_class()}}" class="nav-item">
                            <a href="{{$channel['url']}}" data-app-id="{{z(class)|upset_class()}}" class="nav-link">{{$channel['name']}}</a>
                        </li>
                        {{/loop}}
                    </ul>

                </div>
            </nav>
        </div>
    </div>
</div>