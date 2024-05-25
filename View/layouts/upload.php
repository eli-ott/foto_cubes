<section class="upload flex center">
    <div class="form-container flex start column">
        <h2>Ajouter une photo</h2>
        <form action="form/ajouter-photo" method="post" enctype="multipart/form-data" class="flex row space-between">
            <div class="drop-area flex center">
                <img src="Public/assets/image/add-photo.svg" alt="">
                <input type="file" name="source" required>
            </div>
            <div class="inputs flex column start">
                <input required type="text" placeholder="Titre" name="titre">
                <input required type="date" placeholder="Date de prise de vue" name="datePriseVue">
                <select name="tag" required>
                    <option value="" hidden>Tag</option>
                    <?php foreach (Constants::TYPE_PHOTOS as $typePhoto) : ?>
                        <option value="<?= $typePhoto ?>"><?= $typePhoto ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Ajouter</button>
            </div>
        </form>
    </div>
</section>