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
        <link rel="stylesheet" href="/css/normalize.min.css?v=<?= getenv('VERSION') ?>">
        <!-- <link rel="stylesheet" href="/css/zoning.min.css?v=<?= getenv('VERSION') ?>"> -->
        <link rel="stylesheet" href="/css/frameworks/fontawesome.min.css?v=<?= getenv('VERSION') ?>">
        <link rel="stylesheet" href="/css/frameworks/bootstrap.min.css?v=<?= getenv('VERSION') ?>">
        <link rel="stylesheet" href="/css/style.min.css?v=<?= getenv('VERSION') ?>">
        <?php if (file_exists('css/views/'.$view.'.css')) : ?>
            <link rel="stylesheet" href="/css/views/<?= $view ?>.css?v=<?= getenv('VERSION') ?>">
        <?php endif; ?>
        <script src="/js/frameworks/vue.global.prod.js?v=<?= getenv('VERSION') ?>"></script>
        <script src="/js/frameworks/bootstrap.bundle.min.js?v=<?= getenv('VERSION') ?>" defer></script>
        <script src="/js/frameworks/rick.min.js?v=<?= getenv('VERSION') ?>" defer></script>
    </head>
    <body>