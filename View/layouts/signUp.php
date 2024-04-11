<section>
    <div>
        <h2>M'inscrire</h2>
        <form action="#" method="post">
            <input type="text" placeholder="Pseudo">
            <input type="text" placeholder="Nom">
            <input type="text" placeholder="Prénom">
            <input type="number" placeholder="Age">
            <select name="typePref" id="typePref">
                <option value="" selected disabled hidden>Style de photo préféré</option>
                <?php require_once("Service/constantes.php") ?>
                <?php foreach (TYPE_PHOTOS as $typePhoto) : ?>
                    <option value="<?= $typePhoto ?>"><?= $typePhoto ?></option>
                <?php endforeach; ?>
            </select>
            <input type="email" placeholder="Email">
            <input type="text" name="Mot de passe">
            <input type="text" placeholder="Confirmer mot de passe">
            <button type="button">M'inscrire</button>
        </form>
    </div>
</section>