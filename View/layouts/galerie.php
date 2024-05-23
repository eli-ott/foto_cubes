<section class="gallerie-container flex start">
    <?php require_once('View/layouts/filtres.php'); ?>
    <section class="galerie">
        <!-- requete sql -->
        <?php require('View/layouts/photoGalerie.php'); ?>
        <div class="paginator-container">
            <?php require_once('View/layouts/paginator.php'); ?>
        </div>
    </section>
</section>