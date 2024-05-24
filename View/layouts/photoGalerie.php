<?php foreach ($photos["photos"] as $photo) : ?>
    <figure class="image-container flex column start">
        <div onclick="showModal('<?= URL . $photo->getSource(); ?>', '<?= $photo->getTitre(); ?>', '<?= $photo->getPhotographe()->getPseudo(); ?>', '<?= $photo->getTag(); ?>', '<?= $photo->getPhotographe()->getEmail(); ?>')"
             class="image" style="--bg-image: url('<?= URL ?><?= $photo->getSource() ?>"></div>
        <!-- PHOTO FOR PROFIL PAGE -->
        <?php if (isset($compteActif) && $compteActif) : ?>
            <form action="<?= URL ?>form/delete-photo" method="post" style="visibility: hidden; position: absolute"
                  id="delete-form">
                <input type="text" name="idPhoto" value="<?= $photo->getId(); ?>">
                <input type="text" name="titre" value="<?= $photo->getTitre(); ?>">
                <input type="text" name="tag" value="<?= $photo->getTag(); ?>">
                <input type="text" name="source" value="<?= $photo->getSource(); ?>">
                <input type="text" name="datePriseVue" value="<?= $photo->getDatePriseVue(); ?>">
                <input type="text" name="idUser" value="<?= $photo->getPhotographe()->getId(); ?>">
            </form>
            <form action="<?= URL ?>form/modify-photo" method="post" id="modify-form" style="display: none;"
                  class="flex column">
                <div class="inputs flex row">
                    <input type="text" name="idPhoto" value="<?= $photo->getId(); ?>"
                           style="visibility: hidden; position: absolute">
                    <input type="text" name="titre" value="<?= $photo->getTitre(); ?>">
                    <select name="tag" required>
                        <?php foreach (Constants::TYPE_PHOTOS as $typePhoto) : ?>
                            <option value="<?= $typePhoto ?>" <?= $photo->getTag() === $typePhoto ? 'selected' : 'none' ?>>
                                <?= $typePhoto ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="actions flex row">
                    <button type="button" onclick="toggleModifyForm(false)">Annuler</button>
                    <button type="submit">Valider</button>
                </div>
            </form>
            <p class="description flex">
                <span class="title" style="cursor: pointer; color: red" onclick="deletePhoto()">
                    Supprimer
                </span>
                <span class="author" style="cursor: pointer" onclick="toggleModifyForm(true)">
                    Modifier
                </span>
            </p>
        <?php else : ?>
            <!-- PHOTO FOR GALLERY -->
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
<?php require_once("popupGalerie.php"); ?>
