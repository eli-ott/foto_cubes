<section class="content-container flex center">
    <div class="form-container flex start column">
        <h2>Réinitialiser mon mot de passe</h2>
        <form action="<?= URL ?>form/reset-mdp" method="post" class="flex row wrap">
            <input type="text" name="honeypot" class="hide"/>
            <input required type="text" name="pseudo" placeholder="Pseudo">
            <input required type="password" name="newPass" placeholder="Nouveau mot de passe">
            <input required type="password" name="newPassValidation" placeholder="Confirmer le mot de passe">
            <div class="flex actions">
                <a href="<?= URL ?>accueil" class="back flex center">Annuler</a>
                <button type="submit">Réinitialiser</button>
            </div>
        </form>
    </div>
</section>