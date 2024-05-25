<nav class="flex">
    <a class="logo flex center" href="<?= URL ?>accueil">
        <img src="<?= URL ?>Public/assets/image/logo.svg" alt="Logo Foto"/>
        <p>Foto</p>
    </a>
    <ul class="menu flex center">
        <li><a href="<?= URL ?>galerie/1">Galerie</a></li>
        <?php if (Utils::userConnected()): ?>
            <li><a href="<?= URL ?>profil/1">Mon compte</a></li>
        <?php else: ?>
            <li><a href="<?= URL ?>connexion">Me connecter</a></li>
        <?php endif; ?>
    </ul>
</nav>