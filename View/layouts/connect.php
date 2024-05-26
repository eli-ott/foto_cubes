<section class="content-container flex center">
    <div class="form-container flex start column">
        <h2>Me connecter</h2>
        <form action="<?= URL ?>form/connexion" method="post" class="flex column center">
            <input type="text" class="hide" name="honeypot"/>
            <input required type="text" name="pseudo" placeholder="Pseudo">
            <input required type="password" name="password" placeholder="Mot de passe">
            <div>
                <a href="inscription">Inscription</a>
                <a href="mdp-oublie">Mot de passe oublié ?</a>
            </div>
            <div class="actions flex">
                <a href="<?= URL ?>/accueil" class="flex center back">Annuler</a>
                <button type="submit">Connexion</button>
            </div>
        </form>
    </div>
</section>