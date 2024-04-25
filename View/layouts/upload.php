<section class="upload flex center">
    <div class="form-container flex start column">
        <h2>Ajouter une photo</h2>
        <form action="#" method="post" class="flex row space-between">
            <div class="drop-area flex center">
                <img src="Public/assets/image/add-photo.svg" alt="">
                <input type="file" name="photo">
            </div>
            <div class="inputs flex column start">
                <input type="text" placeholder="Titre">
                <input type="text" placeholder="Date de prise de vue">
                <select name="tag">
                    <option selected disabled hidden>Tag</option>
                    <?php require_once("Services/constantes.php") ?>
                    <?php foreach (TYPE_PHOTOS as $typePhoto) : ?>
                        <option value="<?= $typePhoto ?>"><?= $typePhoto ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Ajouter</button>
            </div>
        </form>
    </div>
</section>