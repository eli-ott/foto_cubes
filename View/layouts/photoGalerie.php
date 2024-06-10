<?php

// Inclure l'autoloader de Composer
require 'vendor/autoload.php';

// Inclure la configuration de Glide
$server = require 'Services/glide-config.php';

// Récupérer les paramètres de la requête
$path = isset($_GET['path']) ? $_GET['path'] : '';
$width = isset($_GET['w']) ? $_GET['w'] : null;
$height = isset($_GET['h']) ? $_GET['h'] : null;

$options = [];
if ($width) {
    $options['w'] = $width;
}
if ($height) {
    $options['h'] = $height;
}
$options['fit'] = 'crop';

try {
    // Vérifier si le fichier existe
    $fullPath = __DIR__ . '/Public/assets/uploads/' . $path;
    if (!file_exists($fullPath)) {
        throw new Exception("Le fichier spécifié n'existe pas : " . $fullPath);
    }

    // Vérifier les permissions du dossier cache
    $cacheDir = __DIR__ . "/Public/cache";
    if (!is_writable($cacheDir)) {
        throw new Exception("Le dossier de cache n'est pas accessible en écriture : " . $cacheDir);
    }

    // Log avant l'appel à outputImage
    error_log('Avant outputImage : ' . $fullPath);

    // Générer et afficher l'image
    $server->outputImage($path, $options);

    // Log après l'appel à outputImage
    error_log('Après outputImage : ' . $fullPath);
} catch (Exception $e) {
    // Afficher l'erreur
    header("Content-Type: text/plain");
    echo 'Erreur : ' . $e->getMessage();
}
?>

<?php foreach ($photos["photos"] as $photo) : ?>
    <figure id="photo-<?= $photo->getId(); ?>"
            class="image-container <?= $photo->getOrientation(); ?> flex column start">
        <div onclick="showModal('<?= URL . $photo->getSource(); ?>', '<?= $photo->getTitre(); ?>', '<?= $photo->getPhotographe()->getPseudo(); ?>', '<?= $photo->getTag(); ?>', '<?= $photo->getPhotographe()->getEmail(); ?>')"
             class="image">
            <img src="<?= URL ?><?= $photo->getSource(); ?>?w=100&h=100" alt="image galerie"/>
        </div>
        <!-- PHOTO FOR PROFIL PAGE -->
        <?php if (isset($compteActif) && $compteActif) : ?>
            <form action="<?= URL ?>form/delete-photo" method="post" class="hide"
                  id="delete-form-<?= $photo->getId() ?>">
                <input type="text" name="idPhoto" value="<?= $photo->getId(); ?>">
                <input type="text" name="titre" value="<?= $photo->getTitre(); ?>">
                <input type="text" name="tag" value="<?= $photo->getTag(); ?>">
                <input type="text" name="source" value="<?= $photo->getSource(); ?>">
                <input type="text" name="datePriseVue" value="<?= $photo->getDatePriseVue(); ?>">
                <input type="text" name="idUser" value="<?= $photo->getPhotographe()->getId(); ?>">
            </form>
            <form action="<?= URL ?>form/modify-photo" method="post" id="modify-form-<?= $photo->getId(); ?>"
                  style="display: none;"
                  class="flex column modify-form">
                <div class="inputs flex column">
                    <input type="text" name="idPhoto" value="<?= $photo->getId(); ?>"
                           class="hide">
                    <input type="text" name="titre" value="<?= $photo->getTitre(); ?>">
                    <select name="tag" required>
                        <?php foreach (Constants::TYPE_PHOTOS as $typePhoto) : ?>
                            <option value="<?= $typePhoto ?>" <?= $photo->getTag() === $typePhoto ? 'selected' : 'none' ?>>
                                <?= $typePhoto ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="actions flex row">
                    <button type="button" onclick="toggleModifyForm(false, <?= $photo->getId(); ?>)">Annuler</button>
                    <button type="submit">Valider</button>
                </div>
            </form>
            <p class="description flex">
                <span class="title" style="cursor: pointer; color: red" onclick="deletePhoto(<?= $photo->getId(); ?>)">
                    Supprimer
                </span>
                <span class="author" style="cursor: pointer" onclick="toggleModifyForm(true, <?= $photo->getId(); ?>)">
                    Modifier
                </span>
            </p>
        <?php else : ?>
            <!-- PHOTO FOR GALLERY -->
            <p class="description flex">
                <span class="title">
                    <?= $photo->getTitre(); ?>
                </span>
                <span class="author">
                    <?= $photo->getPhotographe()->getPseudo() ?>
                </span>
            </p>
        <?php endif; ?>
    </figure>
<?php endforeach; ?>
<?php require_once("popupGalerie.php"); ?>

<script lang="text/javascript">
    sessionStorage.setItem('photos', '<?= json_encode($photos["photos"]); ?>');
</script>
