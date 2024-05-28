<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $description; ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>

    <link rel="manifest" href="/manifest.json"/>
    <!--IOS SUPPORT-->
    <meta name="apple-mobile-web-app-status-bar" content="#db4938"/>
    <meta name="theme-color" content="#3378df"/>

    <link href="https://fonts.googleapis.com/css2?family=Cousine:ital,wght@0,400;0,700;1,400;1,700&display=swap"
          rel="stylesheet"/>
    <link rel="stylesheet" href="<?= URL ?>Public/style/var.css">
    <link rel="stylesheet" href="<?= URL ?>Public/style/main.css">
    <?php if (!empty($pageCss)) : ?>
        <?php foreach ($pageCss as $css) : ?>
            <link rel="stylesheet" href="<?= URL ?>Public/style/<?= $css ?>.css">
        <?php endforeach; ?>
    <?php endif; ?>
    <title><?= $title; ?></title>
</head>

<body>
<?php if ($showHeader) : ?>
    <?php require_once('View/layouts/nav.php'); ?>
<?php endif; ?>
<?= $page_content; ?>
<?php if ($showFooter) : ?>
    <?php require_once('View/layouts/footer.php'); ?>
<?php endif; ?>
<?php if (isset($_SESSION['alert'])): ?>
    <div class="snack-alert <?= $_SESSION['alert']['type'] ?> flex center">
        <div class="content flex center">
            <img onclick="removeAlert('<?= URL ?>')" src="<?= URL ?>Public/assets/image/x.svg" alt="croix"/>
            <h5><?= $_SESSION['alert']['message'] ?></h5>
        </div>
    </div>
<?php endif; ?>

<script lang="text/javascript" src="<?= URL ?>Public/javascript/alert.js"></script>
<?php if (!empty($pageScripts)) : ?>
    <?php foreach ($pageScripts as $js) : ?>
        <script lang="text/javascript" src="<?= URL ?>Public/javascript/<?= $js ?>.js"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>

</html>