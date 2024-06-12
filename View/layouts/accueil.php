    <section class="accueil flex start column">
        <!-- BANNER -->
        <div class="banner flex start">
            <div class="flex center column">
                <h2 class="title_accueil">Foto, le meilleur site de partage de photo entre amateur</h2>
                <div class="buttons flex start">
                    <a href="<?= URL ?>galerie/1" class="cta">Voir la galerie</a>
                    <a href="<?= URL ?>ajouter">Ajouter des photos</a>
                </div>
            </div>
        </div>
        <!-- Pourquoi Foto ? -->
        <div class="flex center content">
            <h3>Pourquoi Foto ?</h3>
            <p class="description">
                On trouvait qu'il y avait trop peu de site de partage de photo entre amateur ouvert à tous avec la possibilité
                de se faire repéré par toutes personnes. C'est pour cela qu'on a créé Foto.
                Foto vise à faciliter les échanges entre les photographes amateur, débutant ou confirmé. <br />
                Avec son utilisation simple, les photographes peuvent partager leur photo. Si leur photo plait, il est possible aux autres utilisateurs de contacter le photographe. <br />
            </p>
        </div>
        <!-- Dernière photos poster -->
        <?php if (!empty($photos)) : ?>
            <div class="preview flex center column">
                <div class="pictures flex center">
                    <?php foreach ($photos as $preview) : ?>
                        <div class="pic" style="--bg-image: url('<?= URL ?><?= $preview["source"] ?>"></div>
                    <?php endforeach; ?>
                </div>
                <a href="<?= URL ?>galerie/1" class="more">Voir plus</a>
            </div>
        <?php else : ?>
            <div class="preview-default flex center column">
                <div class="pictures-default flex center">
                    <p>Pas de photos disponible pour le moment</p>
                </div>
                <a href="<?= URL ?>ajouter" class="more">Ajouter des photos</a>
            </div>
        <?php endif; ?>
        <!-- CCM -->
        <div class="ccm flex center content">
            <p class="description">
                Il n'y a pas plus simple comme fonctionnement. <br />
                Si vous êtes photographe, créez vous un compte afin de publier vos photos. Une fois vos photos publiez, attendez
                que quelqu'un vous contact, ou postez d'autres photos ! <br />
                Si vous rechercher des photographes, consultez la galerie à la recherche de nouveau talents. Pour les contacter
                rien de plus simple. Cliquez sur la photo qui vous plait, remplissez le formulaire et voilà !
            </p>
            <h3>Comment ça marche ?</h3>
        </div>
    </section>