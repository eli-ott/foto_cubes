<section class="sign-up flex center">
    <div class="form-container flex start column">
        <h2>M'inscrire</h2>
        <form action="#" method="post" class="flex row wrap">
            <input type="text" placeholder="Pseudo">
            <input type="text" placeholder="Nom">
            <input type="text" placeholder="Prénom">
            <input type="number" placeholder="Age">
            <select name="typePref" id="typePref">
                <option selected disabled hidden>Style de photo préféré</option>
                <?php foreach (Constants::TYPE_PHOTOS as $typePhoto) : ?>
                    <option value="<?= $typePhoto ?>"><?= $typePhoto ?></option>
                <?php endforeach; ?>
            </select>
            <input type="email" placeholder="Email">
            <input type="password" placeholder="Mot de passe">
            <input type="password" placeholder="Confirmer le mot de passe">
            <button type="button">M'inscrire</button>
        </form>
    </div>
</section>