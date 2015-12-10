<head>
    <meta charset="utf-8">
    <title>Mango - Newspaper Management Made Easy</title>
    <meta name="description" content="Mango is your complete one-stop solution for newspaper management. From press runs to commercial billing this software suite can handle it all for you.">
    <meta name="author" content="Joe Hansen <'jhansen@pioneernewsgroup.com'>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- AJAX CSRF token -->
    <meta name="_token" content="<?php $session->csrf_token ?>"/>
    <!-- #CSS Links -->
    <!-- Basic Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="/public/css/all.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/public/css/app.css">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- #FAVICONS -->
    <link rel="shortcut icon" href="/public/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/public/img/favicon.ico" type="image/x-icon">

    <!-- #GOOGLE FONT -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

    <!-- #APP SCREEN / ICONS -->
    <!-- Specifying a Webpage Icon for Web Clip
         Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
    <link rel="apple-touch-icon" href="/public/img/splash/sptouch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/public/img/splash/touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/public/img/splash/touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/public/img/splash/touch-icon-ipad-retina.png">

    <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Startup image for web apps -->
    <link rel="apple-touch-startup-image" href="/public/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="/public/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="/public/img/splash/iphone.png" media="screen and (max-device-width: 320px)">
    <script>
        //set up some global JS variables passed in from Laravel
        var menupath='<?php echo $GLOBALS['menuPath'] ?>';
    </script>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/pusher-head.php' ?>
</head>
