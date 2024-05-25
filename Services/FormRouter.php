<?php

global $passwordController, $compteController, $connexionController, $photoController, $messageController;

$url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);

if (!empty($url[1])) {
    $param = $url[1];
}

switch ($param) {
    case 'connexion':
        $passwordController->validateConnection();
        break;
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
    case 'contact-photographe':
        $messageController->sendMail();
        break;
    case 'warn-user':
        $compteController->flagUser();
        break;
    case 'remove-alert':
        unset($_SESSION['alert']);
        break;
    default:
        throw new Exception('Le formulaire n\'est pas valide', Constants::TYPES_MESSAGES['error']);
}