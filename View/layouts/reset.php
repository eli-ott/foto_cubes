<section class="reset flex center">
    <div class="form-container flex start column">
        <h2>Réinitialiser mon mot de passe</h2>
        <form action="<?= URL ?>form/reset-mdp" method="post" class="flex row wrap">
            <input required type="text" name="pseudo" placeholder="Pseudo">
            <input required type="password" name="password" placeholder="Mot de passe actuel">
            <input required type="password" name="newPass" placeholder="Nouveau mot de passe">
            <input required type="password" name="newPassValidation" placeholder="Confirmer le mot de passe">
            <button type="submit">Réinitialiser</button>
        </form>
    </div>
</section>