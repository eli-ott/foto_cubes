<section class="reset flex center">
    <div class="form-container flex start column">
        <h2>Réinitialiser mon mot de passe</h2>
        <form action="form/reset-mdp" method="post" class="flex row wrap">
            <input type="text" name="pseudo" placeholder="Pseudo">
            <input type="password" name="password" placeholder="Mot de passe actuel">
            <input type="password" name="newPass" placeholder="Nouveau mot de passe">
            <input type="password" name="newPassValidation" placeholder="Confirmer le mot de passe">
            <button type="submit">Réinitialiser</button>
        </form>
    </div>
</section>