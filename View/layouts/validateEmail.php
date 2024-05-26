<section class="content-container flex center">
    <div class="form-container flex start column">
        <h2>Valider le compte</h2>
        <form action="form/validate-email" method="post" class="flex column center">
            <input type="text" name="code" placeholder="Code" required>
            <div class="flex actions">
                <a href="<?= URL ?>/accueil" class="back flex center">Annuler</a>
                <button type="submit">Valider</button>
            </div>
        </form>
    </div>
</section>