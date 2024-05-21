<?php
session_start();
define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://" . $_SERVER['HTTP_HOST'] . $_SERVER["PHP_SELF"]));

require_once('Services/types/Photographe.php');
require_once('Services/Securite.php');
require_once("Services/types/Photo.php");
require_once("./controller/MainController.php");

require_once('Model/Render.php');
require_once("Model/CompteManager.php");
require_once('Services/types/Photo.php');
require_once("./controller/MainController.php");
require_once("./controller/CompteController.php");
require_once("./controller/MessageController.php");
require_once("./controller/PhotoController.php");
require_once("./controller/PasswordController.php");
require_once("./controller/ConnexionController.php");

$mainController = new MainController();
$compteController = new CompteController();
$messageController = new MessageController();
$photoController = new PhotoController();
$passwordController = new PasswordController();
$connexionController = new ConnexionController();
$compteManager = new CompteManager();

//Permet de récupérer le bon URL
if (empty($_GET['page'])) {
    $page = "accueil";
} else {
    $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);
    $page = $url[0];
    if (!empty($url[1])) {
        $param = $url[1];
    }
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
            if (!Utils::userConnected()) {
                Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
                Utils::redirect(URL . 'connexion');
            }

            $mainController->profil();
            break;
        case 'connexion':
            if (Utils::userConnected()) {
                Utils::newAlert('Un utilisateur est déjà connecté', Constants::TYPES_MESSAGES['error']);
                Utils::redirect(URL . 'profil/1');
            } else {
                $mainController->connexion();
            }

            $mainController->connexion();
            break;
        case 'inscription':
            if (Utils::userConnected()) {
                Utils::newAlert('Un utilisateur est déjà connecté', Constants::TYPES_MESSAGES['error']);
                Utils::redirect(URL . 'profil/1');
            } else {
                $mainController->inscription();
            }

            $mainController->inscription();
            break;
        case 'ajouter':
            if (!Utils::userConnected()) {
                Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
                Utils::redirect(URL . 'connexion');
            }

            $mainController->ajouter();
            break;
        case 'valider':
            if (!Utils::userConnected()) {
                Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
                Utils::redirect(URL . 'connexion');
            }

            $mainController->validateEmail();
            break;
        case 'mdp-oublie':
            if (Utils::userConnected()) {
                Utils::newAlert('Un utilisateur est déjà connecté', Constants::TYPES_MESSAGES['error']);
                Utils::redirect(URL . 'profil/1');
            }

            $mainController->resetMdp();
            break;
        case 'form':
            switch ($param) {
                case 'connexion':
                    $passwordController->validateConnection();
                case 'signUp':
                    $compteController->addCompte();
                    break;
                case 'disconnect':
                    $connexionController->disconnect();
                    break;
                case 'delete-account':
                    $compteController->deleteCompte();
                    break;
                case 'ajouter-photo':
                    $photoController->addPhoto();
                    break;
                case 'delete-photo':
                    $photoController->deletePhoto();
                    break;
                case 'modify-photo':
                    $photoController->updatePhoto();
                    break;
                case 'validate-email':
                    $compteController->validateEmail();
                    break;
                case 'revalidate-email':
                    try {
                        Utils::verifMail($_POST['mail']);

                        Utils::redirect(URL . 'valider');
                    } catch (Exception $e) {
                        Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
                        Utils::redirect(URL . 'profil/1');
                    }
                    break;
                case 'reset-mdp':
                    $compteController->resetMdp();
                    break;
            }
            break;
        default:
            // throw new Exception('Aucune page trouvé', 404);
    }
} catch (Exception $e) {
    Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
    Utils::redirect(URL . 'error');
}
