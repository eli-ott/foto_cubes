<aside class="flex column start">
    <div class="input-container flex column start">
        <h4>Trier par :</h4>
        <select name="tri" id="tri">
            <option value="decroissant">Date décroissante</option>
            <option value="croissant">Date croissante</option>
        </select>
    </div>
    <form action="#" method="post" class="input-container flex column start">
        <h4>Date de publication :</h4>
        <div class="input-container flex column start">
            <div class="flex center">
                <label for="du" style="height: fit-content;">Du</label>
                <input type="text" id="du" placeholder="10/10/2024">
            </div>
            <div class="flex center">
                <label for="au" class="flex center">Au</label>
                <input type="text" id="au" placeholder="12/10/2024">
            </div>
        </div>
    </form>
    <div class="input-container flex column start">
        <h4>Catégories :</h4>
        <select name="tri" id="tri">
            <?php require_once("Services/constantes.php") ?>
            <?php foreach (TYPE_PHOTOS as $typePhoto) : ?>
                <option value="<?= $typePhoto ?>"><?= $typePhoto ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <form action="#" method="post" class="input-container flex column start">
        <h4>Rechercher : </h4>
        <input type="text" placeholder="Mer">
    </form>
</aside>