<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $page_description; ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cousine:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= URL ?>Public/style/var.css">
    <link rel="stylesheet" href="<?= URL ?>Public/style/main.css">
    <title><?= $page_title; ?></title>
</head>

<body>
    <?php require_once('View/layouts/nav.php'); ?>
    <?= $page_content; ?>
    <?php require_once('View/layouts/footer.php'); ?>
</body>

</html>