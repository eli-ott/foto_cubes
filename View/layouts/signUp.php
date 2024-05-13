<section class="sign-up flex center">
    <div class="form-container flex start column">
        <h2>M'inscrire</h2>
        <form action="form/signUp" method="post" class="flex row wrap">
            <input type="text" name="pseudo" placeholder="Pseudo" required>
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="number" name="age" placeholder="Age" required>
            <select name="typePhotoPref" id="typePref" required>
                <option value="" disabled selected>Style de photo préféré</option>
                <?php foreach (Constants::TYPE_PHOTOS as $typePhoto) : ?>
                    <option value="<?= $typePhoto ?>"><?= $typePhoto ?></option>
                <?php endforeach; ?>
            </select>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="passwordValidation" placeholder="Confirmer le mot de passe" required>
            <button type="submit">M'inscrire</button>
        </form>
    </div>
</section>

<?php var_dump($_SESSION['alert']['message']) ?>