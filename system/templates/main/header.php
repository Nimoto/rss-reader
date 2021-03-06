<!DOCTYPE html>
<html>
<head>
    <title>RSS-Reader</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link href="<?php echo WEB_TEMPLATE_PATH ?>css/styles.css" rel="stylesheet">
    <link href="<?php echo WEB_TEMPLATE_PATH ?>css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="<?php echo WEB_TEMPLATE_PATH ?>js/bootstrap.min.js"></script>
    <script src="<?php echo WEB_TEMPLATE_PATH ?>js/custom.js"></script>
    <script src="<?php echo WEB_TEMPLATE_PATH ?>js/jquery.mCustomScrollbar.concat.min.js"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#" onclick="OpenLink(this, '/'); return false;">RSS-reader</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php
                $url = preg_replace('/^([^?]+)(\?.*?)?(#.*)?$/', '$1$3', $_SERVER["REQUEST_URI"]);
                ?>
                <li class="<?php if ($url == '/') {
                    echo 'active';
                } ?>"><a href="#" onclick="OpenLink(this, '/'); return false;">Главная</a></li>
                <?php if (!$_USER) { ?>
                    <li class="<?php if ($url == '/register/') {
                        echo 'active';
                    } ?>"><a href="/register/">Регистрация</a></li>
                <?php } else { ?>
                    <li class="<?php if ($url == '/personal/') {
                        echo 'active';
                    } ?>"><a href="#" onclick="OpenLink(this, '/personal/'); return false;">Личный кабинет</a></li>
                <?php } ?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="player">
    <audio src="" controls></audio>
</div>

<div class="wrapper container ajax-wrapper">