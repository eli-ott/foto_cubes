<?php if (!$compteActif) : ?>
    <form id="revalidate-email" action="<?= URL ?>form/revalidate-email" method="post" class="flex column center">
        <h3>Votre compte n'est pas validé, veuillez le faire avant de pouvoir ajouter des photos</h3>
        <input type="email" name="mail" value="<?= $mailUser ?>">
        <button type="submit">Envoyer un mail de confirmation</button>
    </form>
<?php else : ?>
    <?php require_once("View/layouts/infos.php"); ?>
    <div class="photos-container flex">
        <h2 class="photos">Mes photos :</h2> <a href="<?= URL ?>ajouter" class="flex center">
            <img src="<?= URL ?>Public/assets/image/add-photo.svg" alt="" />
            Ajouter une photo
        </a>
    </div>
    <?php require_once('View/layouts/galerie.php'); ?>

<?php endif; ?>