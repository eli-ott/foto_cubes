<section class="info-container flex column start">
    <h2>Mes informations : </h2>
    <div class="info flex start wrap">
        <div class="flex start">
            <i>Nom:</i> <b id="valeur-nom"><?= $infos->getNom() ?></b>
            <form action="<?= URL ?>form/update-info" method="post" id="update-nom" style="display: none;" class="flex column">
                <div class="inputs flex row">
                    <input type="text" name="idUser" value="<?= $infos->getId(); ?>" class="hide">
                    <input type="text" name="value" value="<?= $infos->getNom(); ?>">
                    <input type="text" name="field" value="nom" class="hide">
                </div>
                <div class="actions flex row">
                    <button type="button" onclick="toggleUpdateInfo(false, 'nom')"><b>Annuler</b></button>
                    <button type="submit"><b>Valider</b></button>
                </div>
            </form>
            <button onclick="toggleUpdateInfo(true, 'nom')"><img src="<?= URL ?>Public/assets/image/pen.svg" alt="Modifier"></button>
        </div>
        <div class="flex start">
            <i>Prénom:</i> <b id="valeur-prenom"><?= $infos->getPrenom() ?></b>
            <form action="<?= URL ?>form/update-info" method="post" id="update-prenom" style="display: none;" class="flex column">
                <div class="inputs flex row">
                    <input type="text" name="idUser" value="<?= $infos->getId(); ?>" class="hide">
                    <input type="text" name="value" value="<?= $infos->getPrenom(); ?>">
                    <input type="text" name="field" value="prenom" class="hide">
                </div>
                <div class="actions flex row">
                    <button type="button" onclick="toggleUpdateInfo(false, 'prenom')"><b>Annuler</b></button>
                    <button type="submit"><b>Valider</b></button>
                </div>
            </form>
            <button onclick="toggleUpdateInfo(true, 'prenom')"><img src="<?= URL ?>Public/assets/image/pen.svg" alt="Modifier"></button>
        </div>
        <div class="flex start">
            <i>Pseudo:</i> <b id="valeur-pseudo"><?= $infos->getPseudo() ?></b>
            <form action="<?= URL ?>form/update-info" method="post" id="update-pseudo" style="display: none;" class="flex column">
                <div class="inputs flex row">
                    <input type="text" name="idUser" value="<?= $infos->getId(); ?>" class="hide">
                    <input type="text" name="value" value="<?= $infos->getPseudo(); ?>">
                    <input type="text" name="field" value="pseudo" class="hide">
                </div>
                <div class="actions flex row">
                    <button type="button" onclick="toggleUpdateInfo(false, 'pseudo')"><b>Annuler</b></button>
                    <button type="submit"><b>Valider</b></button>
                </div>
            </form>
            <button onclick="toggleUpdateInfo(true, 'pseudo')"><img src=" <?= URL ?>Public/assets/image/pen.svg" alt="Modifier"></button>
        </div>
        <div class="flex start">
            <i>Adresse Mail:</i> <b id="valeur-mail"><?= $infos->getEmail() ?></b>
            <form action="<?= URL ?>form/update-info" method="post" id="update-mail" style="display: none;" class="flex column">
                <div class="inputs flex row">
                    <input type="text" name="idUser" value="<?= $infos->getId(); ?>" class="hide">
                    <input type="email" name="value" value="<?= $infos->getEmail(); ?>">
                    <input type="text" name="field" value="email" class="hide">
                </div>
                <div class="actions flex row">
                    <button type="button" onclick="toggleUpdateInfo(false, 'mail')"><b>Annuler</b></button>
                    <button type="submit"><b>Valider</b></button>
                </div>
            </form>
            <button onclick="toggleUpdateInfo(true, 'mail')"><img src="<?= URL ?>Public/assets/image/pen.svg" alt="Modifier"></button>
        </div>
        <div class="flex start">
            <i>Age:</i> <b id="valeur-age"><?= $infos->getAge() ?></b>
            <form action="<?= URL ?>form/update-info" method="post" id="update-age" style="display: none;" class="flex column">
                <div class="inputs flex row">
                    <input type="text" name="idUser" value="<?= $infos->getId(); ?>" class="hide">
                    <input type="text" name="value" value="<?= $infos->getAge(); ?>">
                    <input type="text" name="field" value="age" class="hide">
                </div>
                <div class="actions flex row">
                    <button type="button" onclick="toggleUpdateInfo(false, 'age')"><b>Annuler</b></button>
                    <button type="submit"><b>Valider</b></button>
                </div>
            </form>
            <button onclick="toggleUpdateInfo(true, 'age')"><img src="<?= URL ?>Public/assets/image/pen.svg" alt="Modifier"></button>
        </div>
        <?php if ($infos->getWarn()) : ?>
            <p class="flex start">
                <b style="color: orange">Vous avez été warn. Attention aux prochaines photos que vous publiez</b>
            </p>
        <?php endif; ?>
    </div>
    <div class="buttons flex start">
        <form action="<?= URL ?>form/disconnect" method="post">
            <button type="submit">Me déconnecter</button>
        </form>
        <form action="form/delete-account" method="post" style="visibility: hidden;" id="deleteAccount"></form>
        <button style="color: red" onclick="validateDeletion('<?= URL ?>')">Supprimer mon compte</button>
    </div>
</section>