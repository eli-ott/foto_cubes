<?php require_once("View/layouts/infos.php"); ?>
<section class="admin flex column start">
    <div class="stats-container flex column wrap start">
        <h4>Statistiques : </h4>
        <div class="stats flex row start wrap">
            <p>Photos posté : <b><?= $stats->getPhotosPostees(); ?></b></p>
            <p>Nombre total de compte : <b><?= $stats->getComptesTotal(); ?></b></p>
            <p>Nombre de comptes validés : <b><?= $stats->getComptesValides(); ?></b></p>
            <p>Nombre de comptes warn : <b><?= $stats->getComptesWarn(); ?></b></p>
        </div>
    </div>
    <?php if (!empty($comptesWarn)): ?>
        <div class="account-container flex column start">
            <h4>Les comptes warn : </h4>
            <!-- afficher les comptes en php -->
            <div class="accounts flex row start wrap">
                <?php foreach ($comptesWarn as $profil): ?>
                    <div class="account">
                        <p><?= $profil->getPseudo(); ?>></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <h4>Aucun comptes warn</h4>
    <?php endif; ?>
</section>