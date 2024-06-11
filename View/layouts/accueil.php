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
                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi
                architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione
                voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.
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
                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi
                architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni.
            </p>
            <h3>Comment ça marche ?</h3>
        </div>
    </section>