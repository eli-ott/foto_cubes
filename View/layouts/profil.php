<section>
    <h2>Mes informations : </h2>
    <p><span>Nom :</span> test <a href=""><img src="Public/assets/image/Vector.svg" alt=""></a></p>
    <p><span>Prénom :</span> test <a href=""><img src="Public/assets/image/Vector.svg" alt=""></a></p>
    <p><span>Pseudo :</span> test <a href=""><img src="Public/assets/image/Vector.svg" alt=""></a></p>
    <p><span>Adresse Mail :</span> test@test.test <a href=""><img src="Public/assets/image/Vector.svg" alt=""></a></p>
    <p><span>Age :</span> 50 <a href=""><img src="Public/assets/image/Vector.svg" alt=""></a></p>
</section>
<section>
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
        <form action="#" method="post">
            <h2>Rechercher : </h2>
            <input type="text">
        </form>
    </aside>
    <div>
        <!-- requete sql -->
    </div>
</section>