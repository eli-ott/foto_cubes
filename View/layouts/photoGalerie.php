<?php foreach ($photos["photos"] as $photo) : ?>
    <figure class="image-container flex column start">
        <div class="image" style="--bg-image: url('<?= URL ?>Public/photos/<?= $photo->getSource() ?>"></div>
        <p class="description flex">
            <span class="title">
                <?= $photo->getTitre(); ?>
            </span>
            <span class="author">
                <?= $photo->getPhotographe()->getPseudo() ?>
            </span>
        </p>
    </figure>
<?php endforeach; ?>