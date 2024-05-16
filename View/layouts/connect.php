<section class="connect flex center">
    <div class="form-container flex start column">
        <h2>Me connecter</h2>
        <form action="form/connexion" method="post" class="flex column center">
            <input type="text" name="pseudo" placeholder="Pseudo">
            <input type="password" name="password" placeholder="Mot de passe">
            <div>
                <a href="inscription">Inscription</a>
                <a href="mdp-oublie">Mot de passe oublié ?</a>
            </div>
            <button type="submit">Connexion</button>
        </form>
    </div>
</section>
<?php var_dump($_SESSION['alert']); ?>