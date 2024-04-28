<?php
define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://" . $_SERVER['HTTP_HOST'] . $_SERVER["PHP_SELF"]));

require_once("./controller/MainController.controller.php");
$mainController = new MainController();

//Permet de récupérer le bon URL
if (empty($_GET['page'])) {
    $page = "accueil";
} else {
    $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);
    $page = $url[0];
}

//Le router
try {
    switch ($page) {
        case 'accueil':
            $mainController->accueil();
            break;
        case 'galerie':
            $mainController->galerie();
            break;
        case 'profil':
            $mainController->profil();
            break;
        case 'connexion':
            if (!empty($_COOKIE['token'])) {
                Utils::newAlert('Un utilisateur est déjà connecté', Constants::TYPES_MESSAGES['error']);
                Utils::redirect(URL . 'profil');
            } else {
                $mainController->connexion();
            }
        case 'inscription':
            if (!empty($_COOKIE['token'])) {
                Utils::newAlert('Un utilisateur est déjà connecté', Constants::TYPES_MESSAGES['error']);
                Utils::redirect(URL . 'profil');
            } else {
                $mainController->inscription();
            }
            break;
        case 'ajouter':
            if (empty($_COOKIE['token'])) {
                Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
                Utils::redirect(URL . 'connexion');
            } else {
                $mainController->ajouter();
            }
            break;
        default:
            throw new Exception('Aucune page trouvé', 404);
    }
} catch (Exception $e) {
    //TODO: Gérer les erreurs en PHP avec un handler qui redirect vers la page d'erreur avec le bon code et message
}
