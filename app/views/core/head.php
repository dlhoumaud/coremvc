<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="<?= $head_viewport??'width=device-width, initial-scale=1.0' ?>">
        <meta name="description" content="<?= $head_description??'CoreMVC est un framework PHP' ?>">
        <meta name="keywords" content="<?= $head_keywords??'CoreMVC, PHP, Framework, MVC' ?>">
        <meta name="author" content="<?= $head_author??'David Lhoumaud' ?>">
        <meta property="og:title" content="<?= $head_title??'CoreMVC' ?>">
        <meta property="og:description" content="<?= $head_description??'CoreMVC est un framework PHP' ?>">
        <meta property="og:image" content="https://<?= $_SERVER['HTTP_HOST'] ?>/assets/images/favicon.png">
        <meta property="og:type" content="article">
        <meta property="og:url" content="<?= $_SERVER['HTTP_HOST'] ?>">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?= $head_title??'CoreMVC' ?>">
        <meta name="twitter:description" content="<?= $head_description??'CoreMVC est un framework PHP' ?>">
        <meta name="twitter:image" content="https://<?= $_SERVER['HTTP_HOST'] ?>/assets/images/favicon.png">
        <title><?= $head_title??'CoreMVC' ?></title>
        <link rel="icon" href="/assets/images/favicon.png" alt="CoreMVC Logo">
        <link rel="stylesheet" href="/css/normalize.css?v=<?= getenv('VERSION') ?>">
        <!-- <link rel="stylesheet" href="/css/zoning.css?v=<?= getenv('VERSION') ?>"> -->

        <link rel="stylesheet" href="/css/frameworks/fontawesome-free-6.6.0-web/css/all.css?v=<?= getenv('VERSION') ?>">
        <link rel="stylesheet" href="/css/frameworks/bootstrap-5.3.0/dist/css/bootstrap.min.css?v=<?= getenv('VERSION') ?>">
        <link rel="stylesheet" href="/css/style.css?v=<?= getenv('VERSION') ?>">
        <script src="/js/frameworks/vue-3.5.13.global.prod.js?v=<?= getenv('VERSION') ?>"></script>
        <script src="/css/frameworks/bootstrap-5.3.0/dist/js/bootstrap.bundle.min.js?v=<?= getenv('VERSION') ?>" defer></script>
        <script src="/js/libraries/rick.js?v=<?= getenv('VERSION') ?>" defer></script>
    </head>
    <body>