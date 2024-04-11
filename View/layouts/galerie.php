<aside>
    <div>
        <h2>Trier par :</h2>
        <select name="tri" id="tri">
            <option value="decroissant">Date décroissante</option>
            <option value="croissant">Date croissante</option>
        </select>
    </div>
    <form action="#" method="post">
        <h2>Filtrer :</h2>
        <label for="du">Du</label>
        <input type="text" id="du">
        <label for="au">Au</label>
        <input type="text" id="au">
    </form>
    <div>
        <h2>Catégories :</h2>
        <select name="tri" id="tri">
            <?php require_once("Service/constantes.php") ?>
            <?php foreach (TYPE_PHOTOS as $typePhoto) : ?>
                <option value="<?= $typePhoto ?>"><?= $typePhoto ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</aside>
<section>
    <!-- requete sql -->
</section>