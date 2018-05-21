<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Analytics
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <!-- Basic Page Needs
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <title><?php if($pageTitle) echo ucwords($pageTitle) . ' | '; ?>ಸಮಾಜಮುಖಿ</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Javascript calls
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="<?=PUBLIC_URL?>js/jquery.columnizer.js"></script>
    
    <!-- CSS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>css/viewer.css?v=1.0">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>css/fonts.css?v=1.0">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>css/navbar.css?v=1.0">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>css/homepage.css?v=1.3">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>css/profile.css?v=1.0">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>css/general.css?v=1.1">

    <!-- Fonts
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display|Raleway:200,300,400|Roboto:300,400&amp;subset=latin-ext" rel="stylesheet">

    <!-- Favicon
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="icon" type="image/png" href="<?=PUBLIC_URL?>images/favicon.png">
</head>
<body>

    <!-- Navigation
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <nav id="mainNavBar" class="navbar navbar-light navbar-expand-lg fixed-top">
        <div class="container-fluid clear-paddings">
            <a class="navbar-brand" href="<?=BASE_URL?>"><img src="<?=PUBLIC_URL?>images/logo.png" alt="Logo" class="logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php $this->printNavigation($navigation, ' class="navbar-nav nav ml-auto"'); ?>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>
    <div class="container-fluid sec-nav">
        <div class="row justify-content-around text-center kannada">
            <div class="col-md pill back-green"><a href="<?=BASE_URL?>#samakalina">ಸಮಕಾಲೀನ</a></div>
            <div class="col-md pill back-orange"><a href="<?=BASE_URL?>#mukhyacharche">ಮುಖ್ಯಚರ್ಚೆ</a></div>
            <div class="col-md pill back-blue"><a href="<?=BASE_URL?>#jagadarivu">ಜಗದರಿವು</a></div>
            <div class="col-md pill back-brown"><a href="<?=BASE_URL?>#pustaka">ಪುಸ್ತಕ ಪ್ರಪಂಚ</a></div>
            <div class="col-md pill back-red"><a href="<?=BASE_URL?>#samskriti">ಸಂಸ್ಕೃತಿ ಸಂಪದ</a></div>
        </div>
    </div>
    <!-- End Navigation
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
