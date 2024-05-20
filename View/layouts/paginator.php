<?php
$url = explode('/', $_GET['page']);
// var_dump($photos['pages'])
?>

<?php if ($photos['pages'] > 0) : ?>
    <div class="paginator flex center">
        <?php if ((int)end($url) !== 1) : ?>
            <a href="<?= URL . $url[0] ?>/<?= end($url) !== 1 ? (end($url)) - 1 : 1 ?>">précédent</a>
        <?php endif; ?>
        <?php if ((int)end($url) < (int)$photos['pages']) : ?>
            <a href="<?= URL . $url[0] ?>/<?= end($url) !== $photos['pages'] ? end($url) + 1 : $photos['pages'] ?>">suivant</a>
        <?php endif; ?>
    </div>
<?php endif ?>