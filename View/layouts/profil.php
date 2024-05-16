<?php if (!$compteActif) : ?>
    <form action="form/revalidate-email" method="post">
        <input type="email" name="mail" value="<?= $mailUser ?>">
        <button type="submit">Envoyer un mail</button>
    </form>
<?php else : ?>
    <section class="info-container flex column start">
        <h2>Mes informations : </h2>
        <div class="info flex start wrap">
            <p class="flex start">
                <i>Nom:</i> <b>test</b>
                <button><img src="Public/assets/image/pen.svg" alt=""></button>
            </p>
            <p class="flex start">
                <i>Prénom:</i> <b>test</b>
                <button><img src="Public/assets/image/pen.svg" alt=""></button>
            </p>
            <p class="flex start">
                <i>Pseudo:</i> <b>test</b>
                <button><img src="Public/assets/image/pen.svg" alt=""></button>
            </p>
            <p class="flex start">
                <i>Adresse Mail:</i> <b>test@test.test</b>
                <button><img src="Public/assets/image/pen.svg" alt=""></button>
            </p>
            <p class="flex start">
                <i>Age:</i> <b>50</b>
                <button><img src="Public/assets/image/pen.svg" alt=""></button>
            </p>
        </div>
        <div class="buttons flex start">
            <form action="form/disconnect" method="post">
                <button type="submit">Me déconnecter</button>
            </form>
            <form action="form/delete-account" method="post" style="visibility: hidden;" id="deleteAccount"></form>
            <button style="color: red" onclick="validateDeletion()">Supprimer mon compte</button>
        </div>
    </section>
    <? var_dump($_SESSION['alert']); ?>
    <div class="photos-container flex">
        <h2 class="photos">Mes photos :</h2>
        <a href="ajouter" class="flex center">
            <img src="Public/assets/image/add-photo.svg" alt="">
            Ajouter une photo
        </a>
    </div>
    <?php require_once('View/layouts/galerie.php'); ?>
<?php endif; ?>