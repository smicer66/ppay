<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ProbasePAY | Payment At Ease</title>
    <meta name="description" content="Online Payments on web and mobile platforms">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#222222"> <!-- Android 5.0 Tab Color -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Google Fonts -->
    <!--<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500' rel='stylesheet' type='text/css'>-->
    <!--<link href='http://fonts.googleapis.com/css?family=Raleway:400,500,600,700' rel='stylesheet' type='text/css'>-->

    <!-- Icon Fonts CSS -->
    <link rel="stylesheet" href="/knight/css/knight-iconfont.css">
    <link rel="stylesheet" href="/knight/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> -->

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="/knight/css/bootstrap.min.css">
    <link rel="stylesheet" href="/knight/css/reset.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="/knight/css/jquery.fs.shifter.css">
    <link rel="stylesheet" href="/knight/css/magnific-popup.css">
    <link rel="stylesheet" href="/knight/css/owl.carousel.css">
    <link rel="stylesheet" href="/knight/css/settings.css">
    <link rel="stylesheet" href="/knight/css/animate.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="/knight/css/main.css">
    <link rel="stylesheet" href="/knight/css/shortcodes.css">
    <link rel="stylesheet" href="/knight/css/custom-bg.css">

    <!-- JS -->
    <script src="/knight/js/vendor/modernizr-2.6.2.min.js"></script>
</head>
<body class="shifter shifter-left offcanvas-menu-left offcanvas-menu-dark mobile-header-style2 sticky-header">
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- mobile-header-wrapper -->
<div class="mobile-header-wrapper style2 shifter-header dark-bg clearfix hidden-md hidden-lg">
    <div class="shifter-handle style1">
        <a href="#" class="bars">
            <span></span>
            <span></span>
            <span></span>
        </a><!-- /bars -->
    </div><!-- /menu-trigger -->
    <div class="logo-container">
        <a href="index.html" class="logo">
            <img src="/images/probasepay.png" alt="Knight Logo">
        </a>
    </div><!-- /logo-container -->
    <a href="#" class="search-form-trigger">
        <i class="icon icon-knight-293"></i>
    </a>
    <div class="search-form-wrapper">
        <form action="#" class="mobile-header-search-form">
            <input type="search" name="mobile-header-search-form" id="mobile-header-search-form" placeholder="Type &amp; hit enter">
        </form>
                <span class="search-form-close-trigger">
                    <i class="icon icon-knight-521"></i>
                </span>
    </div><!-- /search-form-wrapper -->
</div>
<!-- /mobile-header-wrapper -->

<!-- OFF CANVAS MOBILE MENU -->
<nav class="main-nav offcanvas-menu mobile-nav shifter-navigation fullwidth-items fullwidth-menu white-bg">
    <form action="#" class="search-form">
        <input type="search" name="mobile-search-form" id="mobile-search-form" placeholder="Search">
        <input type="submit" value="">
    </form>
</nav>

<div class="main-wrapper shifter-page">

    <!-- Start main-header -->
    <header class="main-header style2 overlay-header">
        <div class="main-header-inner">
            <div class="main-bar padding-30 white-bg">
                <div class="container">
                    <div class="logo-container">
                        <a href="index.html" class="logo">
                            <img src="/images/probasepay.png" alt="Knight Logo">
                        </a>
                    </div><!-- /logo-container -->
                    <div class="menu-container clearfix">
                        <nav class="main-nav active-style1 style1" id="main-nav">
                            <ul class="clearfix">
                                <li class="dropdown mega-menu full-width active">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Home</a>
                                </li>
                                <li class="dropdown mega-menu multi-column">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Merchants</a>
                                </li>
                                <li class="dropdown mega-menu full-width">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">About ProbasePAY</a>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Options</a>
                                    <ul class="sub-menu dropdown-menu dark-bg">
                                        <li class="clearfix">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-3 menu-column">
                                                        <ul class="uppercase arrow-list">
                                                            <li><a href="index-1.html">Probase WALLET</a></li>
                                                            <li><a href="index-2.html">Probase Mobile</a></li>
                                                            <li><a href="index-2.html">Probase MPOS</a></li>
                                                            <li><a href="index-3.html">Probase EagleCard</a></li>
                                                            <li><a href="index-4.html">Probase Virtual Account</a></li>
                                                        </ul>
                                                    </div>
                                                </div><!-- /row -->
                                            </div><!-- /container -->
                                        </li>
                                    </ul>

                                </li>
                                <li class="dropdown mega-menu full-width">
                                    <a href="/pages/developers">Developers</a>
                                </li>
                                <li class="dropdown mega-menu full-width">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Vendors & Bills</a>
                                </li>
                                <li class="dropdown woocommerce-menu dropdown-menu-left">
                                    @if(\Auth::user())
                                        <a class="dropdown-toggle" href="#">Welcome</a>
                                    @else
                                        <a class="dropdown-toggle" href="/auth/login">Sign In</a>
                                    @endif
                                    @if(\Auth::user())
                                        <ul class="sub-menu dropdown-menu dark-bg">
                                            <li class="clearfix">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-3 menu-column">
                                                            <ul class="uppercase arrow-list">
                                                                <li><a href="/{{getRoleInterpretRoute(\Auth::user()->role_code)}}/dashboard">My Dashboard</a></li>
                                                                <li><a href="/logout">Sign Out</a></li>
                                                            </ul>
                                                        </div>
                                                    </div><!-- /row -->
                                                </div><!-- /container -->
                                            </li>
                                        </ul>
                                    @endif
                                </li>
                            </ul>
                        </nav>
                    </div><!-- /menu-container -->
                </div><!-- /container -->
            </div><!-- /main-bar -->
        </div><!-- /main-header-inner -->
        @yield('page_content')
    </header>
    <!-- End main-header -->


    <!-- Start main-footer -->
    <footer class="main-footer padding-top112 dark-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="widget widget-about">
                        <a class="logo padding-bottom37" href="/"><img src="/images/probasepay.png" alt="Knight Logo"></a>
                        <p class="taller">At ProbasePAY, we believe that every transaction matters and so should be treated as a big deal.</p>
                    </div><!-- /widget-about -->
                    <div class="widget widget-contact-info widget-contact-info-style1">
                        <h6 class="widget-title heading-alt-style8 short-underline">Contact Info</h6>
                        <address>
                            <p class="clearfix">
                                <i class="icon icon-knight-220"></i><span>41 Paseli Road, Northmead, Lusaka. Zambia</span>
                            </p>
                            <div class="empty-space38"></div>
                            <p class="clearfix">
                                <i class="icon icon-knight-284"></i><span>PHONE: +260 977575210</span>
                            </p>
                            <p class="clearfix">
                                <i class="icon icon-knight-302"></i><span>FAX: +260 977575210</span>
                            </p>
                            <p class="clearfix">
                                <i class="icon icon-knight-365"></i><span>EMAIL: <a href="mailto:support@probasepay.com">support@probasepay.com</a></span>
                            </p>
                            <p class="clearfix">
                                <i class="icon large-icon icon-knight-283"></i><span>WEB: <a class="underline" href="http://probasepay.com/">www.probasepay.com</a></span>
                            </p>
                        </address>
                    </div><!-- /widget-contact-info -->
                </div><!-- /col-md-3 -->
                <div class="col-md-8 col-md-offset-1">
                    <div class="empty-space15"></div>
                    <div class="widget widget-contact-form widget-contact-form-style1">
                        <h6 class="widget-title heading-alt-style8 short-underline">Contact Form</h6>
                        <form action="http://162.144.16.13/~wowothem/knight/php/contact.php" class="contact-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="contact-form-name" name="name" id="name" placeholder="Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="contact-form-email" name="email" id="email" placeholder="Email" required>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="contact-form-subject" name="subject" id="subject" placeholder="Subject">
                                </div>
                                <div class="col-md-12">
                                    <textarea class="contact-form-message" name="message" cols="90" rows="10" placeholder="Content" required></textarea>
                                </div>
                                <input type="submit" class="form-submit" name="form-submit" value="Send Message">
                            </div><!-- /row -->
                        </form>
                        <div class="contact-form-message"></div>
                    </div><!-- /widget-contact-form -->
                </div><!-- /col-md-8 -->
            </div><!-- /row -->
        </div><!-- /container -->
        <div class="footer-bottom-bar margin-top120 clearfix">
            <div class="container">
                <p class="copyright uppercase">© 2014 Knight web design agency. Designed by themeroyal</p>
                <div class="socials-container">
                    <p class="uppercase">Social Networks:</p>
                    <div class="widget widget-socials widget-socials-big">
                        <ul class="clearfix">
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div><!-- /widget-socials -->
                </div><!-- /socials-container -->
            </div><!-- /container -->
        </div><!-- /footer-bottom-bar margin-top120 -->
    </footer>
    <!-- End main-footer -->

</div><!-- /main-wrapper -->

<!-- JS -->
<script src="/knight/js/vendor/jquery.min.js"></script>
<script src="/knight/js/jquery.themepunch.tools.min.js"></script>
<script src="/knight/js/jquery.themepunch.revolution.min.js"></script>
<script src="/knight/js/jquery.magnific-popup.min.js"></script>
<script src="/knight/js/imagesloaded.pkgd.min.js"></script>
<script src="/knight/js/jquery.fs.shifter.min.js"></script>
<script src="/knight/js/jquery.stellar.min.js"></script>
<script src="/knight/js/owl.carousel.min.js"></script>

<script src="/knight/js/wow.min.js"></script>
<script src="/knight/js/main.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.tp-banner').revolution(
                {
                    delay:9000,
                    startwidth:1170,
                    startheight:1000,
                    fullScreen: 'on',
                    navigationType: 'none',
                    navigationArrows: 'solo',
                    navigationStyle: 'knight-1',
                    hideTimerBar: 'on',
                    soloArrowRightVOffset: -55,
                    soloArrowLeftVOffset: -55
                });
    });
</script>

</body>

<!-- Mirrored from 162.144.16.13/~wowothem/knight/index-12.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 26 Sep 2016 01:46:54 GMT -->
</html>
