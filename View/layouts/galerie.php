<?php require_once('View/layouts/filtres.php'); ?>
<section class="galerie">
    <!-- requete sql -->
    <?php foreach ([0, 1, 2, 3, 4, 4] as $item) : ?>
        <?php require('View/layouts/photoGalerie.php'); ?>
    <?php endforeach; ?>
    <div class="paginator-container">
        <?php require_once('View/layouts/paginator.php'); ?>
    </div>
</section>