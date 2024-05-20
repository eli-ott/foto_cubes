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
        <button type="submit" style="color: red" onclick="validateDeletion()">Supprimer mon compte</button>
    </div>
</section>
<h2 class="photos">Mes photos :</h2>
<?php require_once('View/layouts/galerie.php'); ?>