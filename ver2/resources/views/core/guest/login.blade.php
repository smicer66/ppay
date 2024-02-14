<html lang="en" class="-webkit- wf-proximanova-n7-active wf-proximanova-i4-active wf-proximanova-n4-active wf-proximanova-i7-active wf-proximanova-n1-active wf-proximanova-n3-active wf-proximanova-n6-active wf-active"><head>

    <meta charset="UTF-8">

    <link rel="apple-touch-icon" type="image/png" href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png">
    <meta name="apple-mobile-web-app-title" content="CodePen">

    <link rel="shortcut icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico">

    <link rel="mask-icon" type="" href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111">


    <title>Access Lets Go!</title>

    <style media="" data-href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:before,blockquote:after,q:before,q:after{content:'';content:none}table{border-collapse:collapse;border-spacing:0}</style>



    <style>
        body {
            font-family: "proxima-nova",sans-serif;
            font-size: 16px;
        }
        body a {
            color: inherit;
            text-decoration: none;
        }

        * {
            outline: 0;
            border: 0;
            margin: 0;
        }

        button {
            background-color: #000 !important;
            color: #fff !important;
            font-size: 1.02em !important;

        }
        .left {
            float: left;
        }

        .right {
            float: right;
        }

        header:after, .login-form:after, footer:after {
            content: "";
            display: table;
            clear: both;
        }

        .ui-panel {
            margin: 0 auto;
            margin-top: 80px;
            width: 460px;
            height: auto;
            background-color: black;
            color: white;
            border: 1px solid #161616;
            box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.3);
            position: absolute;
            margin-top: -130px;
            margin-left: -181px;
            top: 35%;
            left: 50%;
        }

        header {
            height: 46px;
            line-height: 46px;
            padding: 0 28px;
            font-size: 1.15em;
            font-weight: 600;
            letter-spacing: 0.3em;
        }
        header .logo {
            text-transform: uppercase;
        }
        header span {
            color: #ffdd00;
        }

        .login-form {
            padding: 18px 28px 0 28px;
        }
        .login-form .subtitle {
            font-size: 1.02em;
        }
        .login-form input {
            font-size: 1.05em;
            font-weight: 300;
            margin-top: 18px;
            padding: 10px 8px;
            width: 400px;
        }

        footer {
            padding: 26px 28px 22px 28px;
            font-size: 1.02em;
        }
        footer .social-login i:first-child {
            margin-left: 4px;
        }
        footer .form-actions a {
            padding: 4px 8px;
        }
        footer .register {
            background-color: #ffdd00;
            color: black;
            border-radius: 2px;
        }

        body {
            width: 100%;
            height: 100%;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #f7f8f8 !important;
        }
    </style>

    <script>
        window.console = window.console || function(t) {};
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>


    <script>
        if (document.location.search.match(/type=embed/gi)) {
            window.parent.postMessage("resize", "*");
        }
    </script><style type="text/css">.tk-proxima-nova{font-family:"proxima-nova",sans-serif;}</style><style type="text/css">@font-face{font-family:proxima-nova;src:url(https://use.typekit.net/af/7d485b/00000000000000003b9ad1b1/27/l?subset_id=2&fvd=n7&v=3) format("woff2"),url(https://use.typekit.net/af/7d485b/00000000000000003b9ad1b1/27/d?subset_id=2&fvd=n7&v=3) format("woff"),url(https://use.typekit.net/af/7d485b/00000000000000003b9ad1b1/27/a?subset_id=2&fvd=n7&v=3) format("opentype");font-weight:700;font-style:normal;font-display:auto;}@font-face{font-family:proxima-nova;src:url(https://use.typekit.net/af/347aea/00000000000000003b9ad1b2/27/l?subset_id=2&fvd=i7&v=3) format("woff2"),url(https://use.typekit.net/af/347aea/00000000000000003b9ad1b2/27/d?subset_id=2&fvd=i7&v=3) format("woff"),url(https://use.typekit.net/af/347aea/00000000000000003b9ad1b2/27/a?subset_id=2&fvd=i7&v=3) format("opentype");font-weight:700;font-style:italic;font-display:auto;}@font-face{font-family:proxima-nova;src:url(https://use.typekit.net/af/f6bc94/00000000000000003b9ad1bd/27/l?subset_id=2&fvd=n1&v=3) format("woff2"),url(https://use.typekit.net/af/f6bc94/00000000000000003b9ad1bd/27/d?subset_id=2&fvd=n1&v=3) format("woff"),url(https://use.typekit.net/af/f6bc94/00000000000000003b9ad1bd/27/a?subset_id=2&fvd=n1&v=3) format("opentype");font-weight:100;font-style:normal;font-display:auto;}@font-face{font-family:proxima-nova;src:url(https://use.typekit.net/af/04b81b/00000000000000003b9ad1bb/27/l?subset_id=2&fvd=n6&v=3) format("woff2"),url(https://use.typekit.net/af/04b81b/00000000000000003b9ad1bb/27/d?subset_id=2&fvd=n6&v=3) format("woff"),url(https://use.typekit.net/af/04b81b/00000000000000003b9ad1bb/27/a?subset_id=2&fvd=n6&v=3) format("opentype");font-weight:600;font-style:normal;font-display:auto;}@font-face{font-family:proxima-nova;src:url(https://use.typekit.net/af/c9cde8/00000000000000003b9ad1b9/27/l?subset_id=2&fvd=n4&v=3) format("woff2"),url(https://use.typekit.net/af/c9cde8/00000000000000003b9ad1b9/27/d?subset_id=2&fvd=n4&v=3) format("woff"),url(https://use.typekit.net/af/c9cde8/00000000000000003b9ad1b9/27/a?subset_id=2&fvd=n4&v=3) format("opentype");font-weight:400;font-style:normal;font-display:auto;}@font-face{font-family:proxima-nova;src:url(https://use.typekit.net/af/4ba64f/00000000000000003b9ad1ba/27/l?subset_id=2&fvd=i4&v=3) format("woff2"),url(https://use.typekit.net/af/4ba64f/00000000000000003b9ad1ba/27/d?subset_id=2&fvd=i4&v=3) format("woff"),url(https://use.typekit.net/af/4ba64f/00000000000000003b9ad1ba/27/a?subset_id=2&fvd=i4&v=3) format("opentype");font-weight:400;font-style:italic;font-display:auto;}@font-face{font-family:proxima-nova;src:url(https://use.typekit.net/af/3333ef/00000000000000003b9ad1b5/27/l?subset_id=2&fvd=n3&v=3) format("woff2"),url(https://use.typekit.net/af/3333ef/00000000000000003b9ad1b5/27/d?subset_id=2&fvd=n3&v=3) format("woff"),url(https://use.typekit.net/af/3333ef/00000000000000003b9ad1b5/27/a?subset_id=2&fvd=n3&v=3) format("opentype");font-weight:300;font-style:normal;font-display:auto;}</style>


</head>

<body translate="no">
<!-- fa pls -->
<style media="" data-href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">/*!
 *  Font Awesome 4.0.3 by @davegandy - http://fontawesome.io - @fontawesome
 *  License - http://fontawesome.io/license (Font: SIL OFL 1.1, CSS: MIT License)
 */
    /* FONT PATH
     * -------------------------- */
    @font-face {
        font-family: 'FontAwesome';
        src: url("https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/../fonts/fontawesome-webfont.eot?v=4.0.3");
        src: url("https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/../fonts/fontawesome-webfont.eot?#iefix&v=4.0.3") format('embedded-opentype'), url("https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/../fonts/fontawesome-webfont.woff?v=4.0.3") format('woff'), url("https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/../fonts/fontawesome-webfont.ttf?v=4.0.3") format('truetype'), url("https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/../fonts/fontawesome-webfont.svg?v=4.0.3#fontawesomeregular") format('svg');
        font-weight: normal;
        font-style: normal;
    }
    .fa {
        display: inline-block;
        font-family: FontAwesome;
        font-style: normal;
        font-weight: normal;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    /* makes the font 33% larger relative to the icon container */
    .fa-lg {
        font-size: 1.3333333333333333em;
        line-height: 0.75em;
        vertical-align: -15%;
    }
    .fa-2x {
        font-size: 2em;
    }
    .fa-3x {
        font-size: 3em;
    }
    .fa-4x {
        font-size: 4em;
    }
    .fa-5x {
        font-size: 5em;
    }
    .fa-fw {
        width: 1.2857142857142858em;
        text-align: center;
    }
    .fa-ul {
        padding-left: 0;
        margin-left: 2.142857142857143em;
        list-style-type: none;
    }
    .fa-ul > li {
        position: relative;
    }
    .fa-li {
        position: absolute;
        left: -2.142857142857143em;
        width: 2.142857142857143em;
        top: 0.14285714285714285em;
        text-align: center;
    }
    .fa-li.fa-lg {
        left: -1.8571428571428572em;
    }
    .fa-border {
        padding: .2em .25em .15em;
        border: solid 0.08em #eeeeee;
        border-radius: .1em;
    }
    .pull-right {
        float: right;
    }
    .pull-left {
        float: left;
    }
    .fa.pull-left {
        margin-right: .3em;
    }
    .fa.pull-right {
        margin-left: .3em;
    }
    .fa-spin {
        -webkit-animation: spin 2s infinite linear;
        -moz-animation: spin 2s infinite linear;
        -o-animation: spin 2s infinite linear;
        animation: spin 2s infinite linear;
    }
    @-moz-keyframes spin {
        0% {
            -moz-transform: rotate(0deg);
        }
        100% {
            -moz-transform: rotate(359deg);
        }
    }
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(359deg);
        }
    }
    @-o-keyframes spin {
        0% {
            -o-transform: rotate(0deg);
        }
        100% {
            -o-transform: rotate(359deg);
        }
    }
    @-ms-keyframes spin {
        0% {
            -ms-transform: rotate(0deg);
        }
        100% {
            -ms-transform: rotate(359deg);
        }
    }
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(359deg);
        }
    }
    .fa-rotate-90 {
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=1);
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
    }
    .fa-rotate-180 {
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);
        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        -o-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .fa-rotate-270 {
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
        -webkit-transform: rotate(270deg);
        -moz-transform: rotate(270deg);
        -ms-transform: rotate(270deg);
        -o-transform: rotate(270deg);
        transform: rotate(270deg);
    }
    .fa-flip-horizontal {
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=0, mirror=1);
        -webkit-transform: scale(-1, 1);
        -moz-transform: scale(-1, 1);
        -ms-transform: scale(-1, 1);
        -o-transform: scale(-1, 1);
        transform: scale(-1, 1);
    }
    .fa-flip-vertical {
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2, mirror=1);
        -webkit-transform: scale(1, -1);
        -moz-transform: scale(1, -1);
        -ms-transform: scale(1, -1);
        -o-transform: scale(1, -1);
        transform: scale(1, -1);
    }
    .fa-stack {
        position: relative;
        display: inline-block;
        width: 2em;
        height: 2em;
        line-height: 2em;
        vertical-align: middle;
    }
    .fa-stack-1x,
    .fa-stack-2x {
        position: absolute;
        left: 0;
        width: 100%;
        text-align: center;
    }
    .fa-stack-1x {
        line-height: inherit;
    }
    .fa-stack-2x {
        font-size: 2em;
    }
    .fa-inverse {
        color: #ffffff;
    }
    /* Font Awesome uses the Unicode Private Use Area (PUA) to ensure screen
       readers do not read off random characters that represent icons */
    .fa-glass:before {
        content: "\f000";
    }
    .fa-music:before {
        content: "\f001";
    }
    .fa-search:before {
        content: "\f002";
    }
    .fa-envelope-o:before {
        content: "\f003";
    }
    .fa-heart:before {
        content: "\f004";
    }
    .fa-star:before {
        content: "\f005";
    }
    .fa-star-o:before {
        content: "\f006";
    }
    .fa-user:before {
        content: "\f007";
    }
    .fa-film:before {
        content: "\f008";
    }
    .fa-th-large:before {
        content: "\f009";
    }
    .fa-th:before {
        content: "\f00a";
    }
    .fa-th-list:before {
        content: "\f00b";
    }
    .fa-check:before {
        content: "\f00c";
    }
    .fa-times:before {
        content: "\f00d";
    }
    .fa-search-plus:before {
        content: "\f00e";
    }
    .fa-search-minus:before {
        content: "\f010";
    }
    .fa-power-off:before {
        content: "\f011";
    }
    .fa-signal:before {
        content: "\f012";
    }
    .fa-gear:before,
    .fa-cog:before {
        content: "\f013";
    }
    .fa-trash-o:before {
        content: "\f014";
    }
    .fa-home:before {
        content: "\f015";
    }
    .fa-file-o:before {
        content: "\f016";
    }
    .fa-clock-o:before {
        content: "\f017";
    }
    .fa-road:before {
        content: "\f018";
    }
    .fa-download:before {
        content: "\f019";
    }
    .fa-arrow-circle-o-down:before {
        content: "\f01a";
    }
    .fa-arrow-circle-o-up:before {
        content: "\f01b";
    }
    .fa-inbox:before {
        content: "\f01c";
    }
    .fa-play-circle-o:before {
        content: "\f01d";
    }
    .fa-rotate-right:before,
    .fa-repeat:before {
        content: "\f01e";
    }
    .fa-refresh:before {
        content: "\f021";
    }
    .fa-list-alt:before {
        content: "\f022";
    }
    .fa-lock:before {
        content: "\f023";
    }
    .fa-flag:before {
        content: "\f024";
    }
    .fa-headphones:before {
        content: "\f025";
    }
    .fa-volume-off:before {
        content: "\f026";
    }
    .fa-volume-down:before {
        content: "\f027";
    }
    .fa-volume-up:before {
        content: "\f028";
    }
    .fa-qrcode:before {
        content: "\f029";
    }
    .fa-barcode:before {
        content: "\f02a";
    }
    .fa-tag:before {
        content: "\f02b";
    }
    .fa-tags:before {
        content: "\f02c";
    }
    .fa-book:before {
        content: "\f02d";
    }
    .fa-bookmark:before {
        content: "\f02e";
    }
    .fa-print:before {
        content: "\f02f";
    }
    .fa-camera:before {
        content: "\f030";
    }
    .fa-font:before {
        content: "\f031";
    }
    .fa-bold:before {
        content: "\f032";
    }
    .fa-italic:before {
        content: "\f033";
    }
    .fa-text-height:before {
        content: "\f034";
    }
    .fa-text-width:before {
        content: "\f035";
    }
    .fa-align-left:before {
        content: "\f036";
    }
    .fa-align-center:before {
        content: "\f037";
    }
    .fa-align-right:before {
        content: "\f038";
    }
    .fa-align-justify:before {
        content: "\f039";
    }
    .fa-list:before {
        content: "\f03a";
    }
    .fa-dedent:before,
    .fa-outdent:before {
        content: "\f03b";
    }
    .fa-indent:before {
        content: "\f03c";
    }
    .fa-video-camera:before {
        content: "\f03d";
    }
    .fa-picture-o:before {
        content: "\f03e";
    }
    .fa-pencil:before {
        content: "\f040";
    }
    .fa-map-marker:before {
        content: "\f041";
    }
    .fa-adjust:before {
        content: "\f042";
    }
    .fa-tint:before {
        content: "\f043";
    }
    .fa-edit:before,
    .fa-pencil-square-o:before {
        content: "\f044";
    }
    .fa-share-square-o:before {
        content: "\f045";
    }
    .fa-check-square-o:before {
        content: "\f046";
    }
    .fa-arrows:before {
        content: "\f047";
    }
    .fa-step-backward:before {
        content: "\f048";
    }
    .fa-fast-backward:before {
        content: "\f049";
    }
    .fa-backward:before {
        content: "\f04a";
    }
    .fa-play:before {
        content: "\f04b";
    }
    .fa-pause:before {
        content: "\f04c";
    }
    .fa-stop:before {
        content: "\f04d";
    }
    .fa-forward:before {
        content: "\f04e";
    }
    .fa-fast-forward:before {
        content: "\f050";
    }
    .fa-step-forward:before {
        content: "\f051";
    }
    .fa-eject:before {
        content: "\f052";
    }
    .fa-chevron-left:before {
        content: "\f053";
    }
    .fa-chevron-right:before {
        content: "\f054";
    }
    .fa-plus-circle:before {
        content: "\f055";
    }
    .fa-minus-circle:before {
        content: "\f056";
    }
    .fa-times-circle:before {
        content: "\f057";
    }
    .fa-check-circle:before {
        content: "\f058";
    }
    .fa-question-circle:before {
        content: "\f059";
    }
    .fa-info-circle:before {
        content: "\f05a";
    }
    .fa-crosshairs:before {
        content: "\f05b";
    }
    .fa-times-circle-o:before {
        content: "\f05c";
    }
    .fa-check-circle-o:before {
        content: "\f05d";
    }
    .fa-ban:before {
        content: "\f05e";
    }
    .fa-arrow-left:before {
        content: "\f060";
    }
    .fa-arrow-right:before {
        content: "\f061";
    }
    .fa-arrow-up:before {
        content: "\f062";
    }
    .fa-arrow-down:before {
        content: "\f063";
    }
    .fa-mail-forward:before,
    .fa-share:before {
        content: "\f064";
    }
    .fa-expand:before {
        content: "\f065";
    }
    .fa-compress:before {
        content: "\f066";
    }
    .fa-plus:before {
        content: "\f067";
    }
    .fa-minus:before {
        content: "\f068";
    }
    .fa-asterisk:before {
        content: "\f069";
    }
    .fa-exclamation-circle:before {
        content: "\f06a";
    }
    .fa-gift:before {
        content: "\f06b";
    }
    .fa-leaf:before {
        content: "\f06c";
    }
    .fa-fire:before {
        content: "\f06d";
    }
    .fa-eye:before {
        content: "\f06e";
    }
    .fa-eye-slash:before {
        content: "\f070";
    }
    .fa-warning:before,
    .fa-exclamation-triangle:before {
        content: "\f071";
    }
    .fa-plane:before {
        content: "\f072";
    }
    .fa-calendar:before {
        content: "\f073";
    }
    .fa-random:before {
        content: "\f074";
    }
    .fa-comment:before {
        content: "\f075";
    }
    .fa-magnet:before {
        content: "\f076";
    }
    .fa-chevron-up:before {
        content: "\f077";
    }
    .fa-chevron-down:before {
        content: "\f078";
    }
    .fa-retweet:before {
        content: "\f079";
    }
    .fa-shopping-cart:before {
        content: "\f07a";
    }
    .fa-folder:before {
        content: "\f07b";
    }
    .fa-folder-open:before {
        content: "\f07c";
    }
    .fa-arrows-v:before {
        content: "\f07d";
    }
    .fa-arrows-h:before {
        content: "\f07e";
    }
    .fa-bar-chart-o:before {
        content: "\f080";
    }
    .fa-twitter-square:before {
        content: "\f081";
    }
    .fa-facebook-square:before {
        content: "\f082";
    }
    .fa-camera-retro:before {
        content: "\f083";
    }
    .fa-key:before {
        content: "\f084";
    }
    .fa-gears:before,
    .fa-cogs:before {
        content: "\f085";
    }
    .fa-comments:before {
        content: "\f086";
    }
    .fa-thumbs-o-up:before {
        content: "\f087";
    }
    .fa-thumbs-o-down:before {
        content: "\f088";
    }
    .fa-star-half:before {
        content: "\f089";
    }
    .fa-heart-o:before {
        content: "\f08a";
    }
    .fa-sign-out:before {
        content: "\f08b";
    }
    .fa-linkedin-square:before {
        content: "\f08c";
    }
    .fa-thumb-tack:before {
        content: "\f08d";
    }
    .fa-external-link:before {
        content: "\f08e";
    }
    .fa-sign-in:before {
        content: "\f090";
    }
    .fa-trophy:before {
        content: "\f091";
    }
    .fa-github-square:before {
        content: "\f092";
    }
    .fa-upload:before {
        content: "\f093";
    }
    .fa-lemon-o:before {
        content: "\f094";
    }
    .fa-phone:before {
        content: "\f095";
    }
    .fa-square-o:before {
        content: "\f096";
    }
    .fa-bookmark-o:before {
        content: "\f097";
    }
    .fa-phone-square:before {
        content: "\f098";
    }
    .fa-twitter:before {
        content: "\f099";
    }
    .fa-facebook:before {
        content: "\f09a";
    }
    .fa-github:before {
        content: "\f09b";
    }
    .fa-unlock:before {
        content: "\f09c";
    }
    .fa-credit-card:before {
        content: "\f09d";
    }
    .fa-rss:before {
        content: "\f09e";
    }
    .fa-hdd-o:before {
        content: "\f0a0";
    }
    .fa-bullhorn:before {
        content: "\f0a1";
    }
    .fa-bell:before {
        content: "\f0f3";
    }
    .fa-certificate:before {
        content: "\f0a3";
    }
    .fa-hand-o-right:before {
        content: "\f0a4";
    }
    .fa-hand-o-left:before {
        content: "\f0a5";
    }
    .fa-hand-o-up:before {
        content: "\f0a6";
    }
    .fa-hand-o-down:before {
        content: "\f0a7";
    }
    .fa-arrow-circle-left:before {
        content: "\f0a8";
    }
    .fa-arrow-circle-right:before {
        content: "\f0a9";
    }
    .fa-arrow-circle-up:before {
        content: "\f0aa";
    }
    .fa-arrow-circle-down:before {
        content: "\f0ab";
    }
    .fa-globe:before {
        content: "\f0ac";
    }
    .fa-wrench:before {
        content: "\f0ad";
    }
    .fa-tasks:before {
        content: "\f0ae";
    }
    .fa-filter:before {
        content: "\f0b0";
    }
    .fa-briefcase:before {
        content: "\f0b1";
    }
    .fa-arrows-alt:before {
        content: "\f0b2";
    }
    .fa-group:before,
    .fa-users:before {
        content: "\f0c0";
    }
    .fa-chain:before,
    .fa-link:before {
        content: "\f0c1";
    }
    .fa-cloud:before {
        content: "\f0c2";
    }
    .fa-flask:before {
        content: "\f0c3";
    }
    .fa-cut:before,
    .fa-scissors:before {
        content: "\f0c4";
    }
    .fa-copy:before,
    .fa-files-o:before {
        content: "\f0c5";
    }
    .fa-paperclip:before {
        content: "\f0c6";
    }
    .fa-save:before,
    .fa-floppy-o:before {
        content: "\f0c7";
    }
    .fa-square:before {
        content: "\f0c8";
    }
    .fa-bars:before {
        content: "\f0c9";
    }
    .fa-list-ul:before {
        content: "\f0ca";
    }
    .fa-list-ol:before {
        content: "\f0cb";
    }
    .fa-strikethrough:before {
        content: "\f0cc";
    }
    .fa-underline:before {
        content: "\f0cd";
    }
    .fa-table:before {
        content: "\f0ce";
    }
    .fa-magic:before {
        content: "\f0d0";
    }
    .fa-truck:before {
        content: "\f0d1";
    }
    .fa-pinterest:before {
        content: "\f0d2";
    }
    .fa-pinterest-square:before {
        content: "\f0d3";
    }
    .fa-google-plus-square:before {
        content: "\f0d4";
    }
    .fa-google-plus:before {
        content: "\f0d5";
    }
    .fa-money:before {
        content: "\f0d6";
    }
    .fa-caret-down:before {
        content: "\f0d7";
    }
    .fa-caret-up:before {
        content: "\f0d8";
    }
    .fa-caret-left:before {
        content: "\f0d9";
    }
    .fa-caret-right:before {
        content: "\f0da";
    }
    .fa-columns:before {
        content: "\f0db";
    }
    .fa-unsorted:before,
    .fa-sort:before {
        content: "\f0dc";
    }
    .fa-sort-down:before,
    .fa-sort-asc:before {
        content: "\f0dd";
    }
    .fa-sort-up:before,
    .fa-sort-desc:before {
        content: "\f0de";
    }
    .fa-envelope:before {
        content: "\f0e0";
    }
    .fa-linkedin:before {
        content: "\f0e1";
    }
    .fa-rotate-left:before,
    .fa-undo:before {
        content: "\f0e2";
    }
    .fa-legal:before,
    .fa-gavel:before {
        content: "\f0e3";
    }
    .fa-dashboard:before,
    .fa-tachometer:before {
        content: "\f0e4";
    }
    .fa-comment-o:before {
        content: "\f0e5";
    }
    .fa-comments-o:before {
        content: "\f0e6";
    }
    .fa-flash:before,
    .fa-bolt:before {
        content: "\f0e7";
    }
    .fa-sitemap:before {
        content: "\f0e8";
    }
    .fa-umbrella:before {
        content: "\f0e9";
    }
    .fa-paste:before,
    .fa-clipboard:before {
        content: "\f0ea";
    }
    .fa-lightbulb-o:before {
        content: "\f0eb";
    }
    .fa-exchange:before {
        content: "\f0ec";
    }
    .fa-cloud-download:before {
        content: "\f0ed";
    }
    .fa-cloud-upload:before {
        content: "\f0ee";
    }
    .fa-user-md:before {
        content: "\f0f0";
    }
    .fa-stethoscope:before {
        content: "\f0f1";
    }
    .fa-suitcase:before {
        content: "\f0f2";
    }
    .fa-bell-o:before {
        content: "\f0a2";
    }
    .fa-coffee:before {
        content: "\f0f4";
    }
    .fa-cutlery:before {
        content: "\f0f5";
    }
    .fa-file-text-o:before {
        content: "\f0f6";
    }
    .fa-building-o:before {
        content: "\f0f7";
    }
    .fa-hospital-o:before {
        content: "\f0f8";
    }
    .fa-ambulance:before {
        content: "\f0f9";
    }
    .fa-medkit:before {
        content: "\f0fa";
    }
    .fa-fighter-jet:before {
        content: "\f0fb";
    }
    .fa-beer:before {
        content: "\f0fc";
    }
    .fa-h-square:before {
        content: "\f0fd";
    }
    .fa-plus-square:before {
        content: "\f0fe";
    }
    .fa-angle-double-left:before {
        content: "\f100";
    }
    .fa-angle-double-right:before {
        content: "\f101";
    }
    .fa-angle-double-up:before {
        content: "\f102";
    }
    .fa-angle-double-down:before {
        content: "\f103";
    }
    .fa-angle-left:before {
        content: "\f104";
    }
    .fa-angle-right:before {
        content: "\f105";
    }
    .fa-angle-up:before {
        content: "\f106";
    }
    .fa-angle-down:before {
        content: "\f107";
    }
    .fa-desktop:before {
        content: "\f108";
    }
    .fa-laptop:before {
        content: "\f109";
    }
    .fa-tablet:before {
        content: "\f10a";
    }
    .fa-mobile-phone:before,
    .fa-mobile:before {
        content: "\f10b";
    }
    .fa-circle-o:before {
        content: "\f10c";
    }
    .fa-quote-left:before {
        content: "\f10d";
    }
    .fa-quote-right:before {
        content: "\f10e";
    }
    .fa-spinner:before {
        content: "\f110";
    }
    .fa-circle:before {
        content: "\f111";
    }
    .fa-mail-reply:before,
    .fa-reply:before {
        content: "\f112";
    }
    .fa-github-alt:before {
        content: "\f113";
    }
    .fa-folder-o:before {
        content: "\f114";
    }
    .fa-folder-open-o:before {
        content: "\f115";
    }
    .fa-smile-o:before {
        content: "\f118";
    }
    .fa-frown-o:before {
        content: "\f119";
    }
    .fa-meh-o:before {
        content: "\f11a";
    }
    .fa-gamepad:before {
        content: "\f11b";
    }
    .fa-keyboard-o:before {
        content: "\f11c";
    }
    .fa-flag-o:before {
        content: "\f11d";
    }
    .fa-flag-checkered:before {
        content: "\f11e";
    }
    .fa-terminal:before {
        content: "\f120";
    }
    .fa-code:before {
        content: "\f121";
    }
    .fa-reply-all:before {
        content: "\f122";
    }
    .fa-mail-reply-all:before {
        content: "\f122";
    }
    .fa-star-half-empty:before,
    .fa-star-half-full:before,
    .fa-star-half-o:before {
        content: "\f123";
    }
    .fa-location-arrow:before {
        content: "\f124";
    }
    .fa-crop:before {
        content: "\f125";
    }
    .fa-code-fork:before {
        content: "\f126";
    }
    .fa-unlink:before,
    .fa-chain-broken:before {
        content: "\f127";
    }
    .fa-question:before {
        content: "\f128";
    }
    .fa-info:before {
        content: "\f129";
    }
    .fa-exclamation:before {
        content: "\f12a";
    }
    .fa-superscript:before {
        content: "\f12b";
    }
    .fa-subscript:before {
        content: "\f12c";
    }
    .fa-eraser:before {
        content: "\f12d";
    }
    .fa-puzzle-piece:before {
        content: "\f12e";
    }
    .fa-microphone:before {
        content: "\f130";
    }
    .fa-microphone-slash:before {
        content: "\f131";
    }
    .fa-shield:before {
        content: "\f132";
    }
    .fa-calendar-o:before {
        content: "\f133";
    }
    .fa-fire-extinguisher:before {
        content: "\f134";
    }
    .fa-rocket:before {
        content: "\f135";
    }
    .fa-maxcdn:before {
        content: "\f136";
    }
    .fa-chevron-circle-left:before {
        content: "\f137";
    }
    .fa-chevron-circle-right:before {
        content: "\f138";
    }
    .fa-chevron-circle-up:before {
        content: "\f139";
    }
    .fa-chevron-circle-down:before {
        content: "\f13a";
    }
    .fa-html5:before {
        content: "\f13b";
    }
    .fa-css3:before {
        content: "\f13c";
    }
    .fa-anchor:before {
        content: "\f13d";
    }
    .fa-unlock-alt:before {
        content: "\f13e";
    }
    .fa-bullseye:before {
        content: "\f140";
    }
    .fa-ellipsis-h:before {
        content: "\f141";
    }
    .fa-ellipsis-v:before {
        content: "\f142";
    }
    .fa-rss-square:before {
        content: "\f143";
    }
    .fa-play-circle:before {
        content: "\f144";
    }
    .fa-ticket:before {
        content: "\f145";
    }
    .fa-minus-square:before {
        content: "\f146";
    }
    .fa-minus-square-o:before {
        content: "\f147";
    }
    .fa-level-up:before {
        content: "\f148";
    }
    .fa-level-down:before {
        content: "\f149";
    }
    .fa-check-square:before {
        content: "\f14a";
    }
    .fa-pencil-square:before {
        content: "\f14b";
    }
    .fa-external-link-square:before {
        content: "\f14c";
    }
    .fa-share-square:before {
        content: "\f14d";
    }
    .fa-compass:before {
        content: "\f14e";
    }
    .fa-toggle-down:before,
    .fa-caret-square-o-down:before {
        content: "\f150";
    }
    .fa-toggle-up:before,
    .fa-caret-square-o-up:before {
        content: "\f151";
    }
    .fa-toggle-right:before,
    .fa-caret-square-o-right:before {
        content: "\f152";
    }
    .fa-euro:before,
    .fa-eur:before {
        content: "\f153";
    }
    .fa-gbp:before {
        content: "\f154";
    }
    .fa-dollar:before,
    .fa-usd:before {
        content: "\f155";
    }
    .fa-rupee:before,
    .fa-inr:before {
        content: "\f156";
    }
    .fa-cny:before,
    .fa-rmb:before,
    .fa-yen:before,
    .fa-jpy:before {
        content: "\f157";
    }
    .fa-ruble:before,
    .fa-rouble:before,
    .fa-rub:before {
        content: "\f158";
    }
    .fa-won:before,
    .fa-krw:before {
        content: "\f159";
    }
    .fa-bitcoin:before,
    .fa-btc:before {
        content: "\f15a";
    }
    .fa-file:before {
        content: "\f15b";
    }
    .fa-file-text:before {
        content: "\f15c";
    }
    .fa-sort-alpha-asc:before {
        content: "\f15d";
    }
    .fa-sort-alpha-desc:before {
        content: "\f15e";
    }
    .fa-sort-amount-asc:before {
        content: "\f160";
    }
    .fa-sort-amount-desc:before {
        content: "\f161";
    }
    .fa-sort-numeric-asc:before {
        content: "\f162";
    }
    .fa-sort-numeric-desc:before {
        content: "\f163";
    }
    .fa-thumbs-up:before {
        content: "\f164";
    }
    .fa-thumbs-down:before {
        content: "\f165";
    }
    .fa-youtube-square:before {
        content: "\f166";
    }
    .fa-youtube:before {
        content: "\f167";
    }
    .fa-xing:before {
        content: "\f168";
    }
    .fa-xing-square:before {
        content: "\f169";
    }
    .fa-youtube-play:before {
        content: "\f16a";
    }
    .fa-dropbox:before {
        content: "\f16b";
    }
    .fa-stack-overflow:before {
        content: "\f16c";
    }
    .fa-instagram:before {
        content: "\f16d";
    }
    .fa-flickr:before {
        content: "\f16e";
    }
    .fa-adn:before {
        content: "\f170";
    }
    .fa-bitbucket:before {
        content: "\f171";
    }
    .fa-bitbucket-square:before {
        content: "\f172";
    }
    .fa-tumblr:before {
        content: "\f173";
    }
    .fa-tumblr-square:before {
        content: "\f174";
    }
    .fa-long-arrow-down:before {
        content: "\f175";
    }
    .fa-long-arrow-up:before {
        content: "\f176";
    }
    .fa-long-arrow-left:before {
        content: "\f177";
    }
    .fa-long-arrow-right:before {
        content: "\f178";
    }
    .fa-apple:before {
        content: "\f179";
    }
    .fa-windows:before {
        content: "\f17a";
    }
    .fa-android:before {
        content: "\f17b";
    }
    .fa-linux:before {
        content: "\f17c";
    }
    .fa-dribbble:before {
        content: "\f17d";
    }
    .fa-skype:before {
        content: "\f17e";
    }
    .fa-foursquare:before {
        content: "\f180";
    }
    .fa-trello:before {
        content: "\f181";
    }
    .fa-female:before {
        content: "\f182";
    }
    .fa-male:before {
        content: "\f183";
    }
    .fa-gittip:before {
        content: "\f184";
    }
    .fa-sun-o:before {
        content: "\f185";
    }
    .fa-moon-o:before {
        content: "\f186";
    }
    .fa-archive:before {
        content: "\f187";
    }
    .fa-bug:before {
        content: "\f188";
    }
    .fa-vk:before {
        content: "\f189";
    }
    .fa-weibo:before {
        content: "\f18a";
    }
    .fa-renren:before {
        content: "\f18b";
    }
    .fa-pagelines:before {
        content: "\f18c";
    }
    .fa-stack-exchange:before {
        content: "\f18d";
    }
    .fa-arrow-circle-o-right:before {
        content: "\f18e";
    }
    .fa-arrow-circle-o-left:before {
        content: "\f190";
    }
    .fa-toggle-left:before,
    .fa-caret-square-o-left:before {
        content: "\f191";
    }
    .fa-dot-circle-o:before {
        content: "\f192";
    }
    .fa-wheelchair:before {
        content: "\f193";
    }
    .fa-vimeo-square:before {
        content: "\f194";
    }
    .fa-turkish-lira:before,
    .fa-try:before {
        content: "\f195";
    }
    .fa-plus-square-o:before {
        content: "\f196";
    }
</style>

<!-- animate.css -->
<link href="https://s3-us-west-2.amazonaws.com/s.cdpn.io/67239/animate.min.css" rel="stylesheet" data-inprogress="">

<!-- under overlay stuff -->
<div class="body"></div>

<!-- the panel -->
<div class="overlay">
    <div class="ui-panel login-panel animated bounceInDown">
        <header>

            <div class="left logo" style="padding-top: 30px !important;">
                <img class="logo_image" src="/images/bevurabluelogo.png" alt="" width="120"><br>
                <a href="/"><span>Probase</span>Pay</a>
            </div>

            <!--<div class="right">
                <a href="#close" id="close" class="ui-button close">
                    x
                </a>
            </div>-->
        </header>

        <form class="" method="post" id="login" action="/login">
            <div class="login-form" style="clear: both !important">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="deviceVersion" id="deviceVersion" value="">
                    <input type="hidden" name="deviceName" id="deviceName" value="">
                    <input type="hidden" name="deviceKey" id="deviceKey" value="">
                    <input type="hidden" name="deviceAppId" id="deviceAppId" value="">
                    <input type="hidden" name="deviceId" id="deviceId" value="">




                    <div class="subtitle"><strong>Provide your username and valid password</strong></div>
                    <input type="text" name="username" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
            </div>

        <footer style="padding-bottom: 5px !important;">
            <div class="left social-login">
                <!--<a href="#login" class="ui-button inactive login">Forgot Password</a>
                <a href="/auth/customer-register" class="ui-button inactive login"> | Register</a>-->
            </div>

            <div class="right form-actions">
                <a onclick="loginAction()" style="cursor: pointer !important;" class="ui-button inactive register">Login</a>
            </div>
        </footer>
	 <footer style="padding-bottom: 50px !important; padding-top: 5px !important;">
            <div class="left social-login">
                <!--<a href="/admin-portal" class="ui-button inactive login">Admin Portal</a>-->
            </div>

            <div class="right form-actions">
                
            </div>
        </footer>
        </form>
    </div>
</div>

<!-- get dem fancy typefaces -->
<script type="text/javascript" src="//use.typekit.net/psm0wvc.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-157cd5b220a5c80d4ff8e0e70ac069bffd87a61252088146915e8726e5d9f147.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script id="rendered-js">
    // Quick exercise
    // Working on a login panel from my Bananaplate project
    // http://dribbble.com/iamnbutler/projects/178899-BANANAPLATE


	function makeid(length) {
		console.log("generate id");
    		var result           = '';
    		var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    		var charactersLength = characters.length;
    		for ( var i = 0; i < length; i++ ) {
      			result += characters.charAt(Math.floor(Math.random() * 
 			charactersLength));
   		}
   		return result;
	}

    $(document).ready(function () {
        // No links pls
        $('.ui-button.inactive').click(function () {
            e.preventDefault();
        });

        $('#close').click(function () {
            $('.ui-panel').removeClass('bounceInDown').addClass('bounceOutUp');
        });

	 console.log("navigator");
	 console.log(navigator);
	 let deviceId = localStorage.getItem("deviceId")==null ? (makeid(32)) : localStorage.getItem("deviceId");
	 let deviceVersion = navigator.appVersion;
	 let deviceName = navigator.appName;
	 let deviceKey = localStorage.getItem("deviceKey")==null ? (makeid(128)) : localStorage.getItem("deviceKey");
	 let deviceAppId = localStorage.getItem("deviceAppId")==null ? (makeid(128)) : localStorage.getItem("deviceAppId");

	 localStorage.setItem("deviceId", deviceId);
	 localStorage.setItem("deviceVersion", deviceVersion);
	 localStorage.setItem("deviceName", deviceName);
	 localStorage.setItem("deviceKey", deviceKey);
	 localStorage.setItem("deviceAppId", deviceAppId);

	 console.log(deviceAppId);

	 $("#deviceId").val(deviceId);
	 $("#deviceVersion").val(deviceVersion);
	 $("#deviceName").val(deviceName);
	 $("#deviceKey").val(deviceKey);
	 $("#deviceAppId").val(deviceAppId);
    });



    function loginAction(){
        $('form#login').submit();
    }
</script>







</body></html>
