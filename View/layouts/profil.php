<?php var_dump($_SESSION['alert']); ?>

<?php if (!$compteActif) : ?>
    <form id="revalidate-email" action="<?= URL ?>form/revalidate-email" method="post" class="flex column center">
        <h3>Votre compte n'est pas validé, veuillez le faire avant de pouvoir ajouter des photos</h3>
        <input type="email" name="mail" value="<?= $mailUser ?>">
        <button type="submit">Envoyer un mail de confirmation</button>
    </form>
<?php else : ?>
    <section class="info-container flex column start">
        <h2>Mes informations : </h2>
        <div class="info flex start wrap">
            <p class="flex start">
                <i>Nom:</i> <b><?= $infos->getNom() ?></b>
                <button><img src="<?= URL ?>Public/assets/image/pen.svg" alt="Modifier"></button>
            </p>
            <p class="flex start">
                <i>Prénom:</i> <b><?= $infos->getPrenom() ?></b>
                <button><img src="<?= URL ?>Public/assets/image/pen.svg" alt="Modifier"></button>
            </p>
            <p class="flex start">
                <i>Pseudo:</i> <b><?= $infos->getPseudo() ?></b>
                <button><img src="<?= URL ?>Public/assets/image/pen.svg" alt="Modifier"></button>
            </p>
            <p class="flex start">
                <i>Adresse Mail:</i> <b><?= $infos->getEmail() ?></b>
                <button><img src="<?= URL ?>Public/assets/image/pen.svg" alt="Modifier"></button>
            </p>
            <p class="flex start">
                <i>Age:</i> <b><?= $infos->getAge() ?></b>
                <button><img src="<?= URL ?>Public/assets/image/pen.svg" alt="Modifier"></button>
            </p>
        </div>
        <div class="buttons flex start">
            <form action="<?= URL ?>form/disconnect" method="post">
                <button type="submit">Me déconnecter</button>
            </form>
            <form action="form/delete-account" method="post" style="visibility: hidden;" id="deleteAccount"></form>
            <button style="color: red" onclick="validateDeletion('<?= URL ?>')">Supprimer mon compte</button>
        </div>
    </section>
    <? var_dump($_SESSION['alert']); ?>
    <div class="photos-container flex">
        <h2 class="photos">Mes photos :</h2> <a href="<?= URL ?>ajouter" class="flex center">
            <img src="<?= URL ?>Public/assets/image/add-photo.svg" alt="">
            Ajouter une photo
        </a>
    </div>
    <?php require_once('View/layouts/galerie.php'); ?>

<?php endif; ?>