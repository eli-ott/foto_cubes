<div class="popup flex center column">
    <!-- image choisis -->
    <div class="content-container flex row nowrap">
        <img onclick='hideModal()' class="croix" src="<?= URL ?>Public/assets/image/x.svg" alt="croix"/>
        <img class="image" src="" alt="image choisi">
        <div class="infos flex column start">
            <div>
                <h2 class="titre">titre photo</h2>
                <p class="tag">tag</p>
                <p class="pseudo">pseudo photographe</p>
            </div>
            <form action="<?= URL ?>form/contact-photographe" method="post" class="flex column center">
                <h5>Contacter le photographe</h5>
                <input type="text" name="honeypot" class="hide"/>
                <input required type="email" name="receiver" class="hide mail-receveur"/>
                <input required type="text" name="subject" placeholder="Object">
                <input required type="text" name="message" placeholder="Contenu du mail">
                <button type="submit">Envoyer le mail</button>
            </form>
        </div>
        <?php if (Utils::userAdmin()): ?>
            <form action="<?= URL ?>form/warn-user" method="post">
                <input type="text" name="pseudo" class="pseudo-warn hide">
                <button type="submit" class="warn">Warn l'utilisateur</button>
            </form>
        <?php endif; ?>
    </div>
</div>