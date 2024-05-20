<?php foreach ($photos["photos"] as $photo) : ?>
    <figure class="image-container flex column start">
        <div class="image" style="--bg-image: url('<?= URL ?><?= $photo->getSource() ?>"></div>
        <?php if ($compteActif) : ?>
            <form action="<?= URL ?>form/delete-photo" method="post" style="visibility: hidden; position: absolute" id="delete-form">
                <input type="text" name="idPhoto" value="<?= $photo->getId(); ?>">
                <input type="text" name="titre" value="<?= $photo->getTitre(); ?>">
                <input type="text" name="tag" value="<?= $photo->getTag(); ?>">
                <input type="text" name="source" value="<?= $photo->getSource(); ?>">
                <input type="text" name="datePriseVue" value="<?= $photo->getDatePriseVue(); ?>">
                <input type="text" name="idUser" value="<?= $photo->getPhotographe()->getId(); ?>">
            </form>
            <p class="description flex">
                <span class="title" style="cursor: pointer; color: red" onclick="deletePhoto()">
                    Supprimer
                </span>
                <span class="author" style="cursor: pointer">
                    Modifier //TODO: AJOUTER LA POSSIBILITé DE MODIFER LES INFOS DE LA PHOTO PEUT êTRE VIA UNE AUTRE PAGE
                </span>
            </p>
        <?php else : ?>
            <p class="description flex">
                <span class="title">
                    <?= $photo->getTitre(); ?>
                </span>
                <span class="author">
                    <?= $photo->getPhotographe()->getPseudo() ?>
                </span>
            </p>
        <?php endif; ?>
    </figure>
<?php endforeach; ?>