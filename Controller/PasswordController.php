<?php

require_once("Model/PasswordManager.php");
require_once("Model/CompteManager.php");

class PasswordController
{
    /**
     * @var PasswordManager $passwordManager Le manager pour les mots de passes
     */
    private $passwordManager;
    /**
     * @var CompteManager $compteManager Le manager pour les comptes
     */
    private $compteManager;
    /**
     * @var ConnexionController $connexionController Le controller pour les connexions
     */
    private $connexionController;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->compteManager = new CompteManager;
        $this->passwordManager = new PasswordManager;
        $this->connexionController = new ConnexionController;
    }

    /**
     * Permet de valider la connection
     */
    public function validateConnection(): void
    {
        if(!empty($_COOKIE['token'])) {
            Utils::newAlert('Un utilisateur est déjà connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil');
        }
        
        $pseudo = Securite::secureHTML($_POST['pseudo']);
        $password = Securite::secureHTML($_POST['password']);

        try {
            $idUser = $this->compteManager->getUserId($pseudo);

            $this->connexionController->validateConnection($idUser, $password);

            setcookie('token', Utils::generateToken(), time() + Utils::hoursToSeconds(24), '/');
            setcookie('id', $idUser, time() + Utils::hoursToSeconds(24), '/');

            Utils::redirect(URL . 'profil');
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }
    }

    /**
     * Permet de mettre à jour un mot de passe
     */
    public function updatePassword(): void
    {
        $password = Securite::secureHTML($_POST['password']);
        $newPassword = Securite::secureHTML($_POST['newPass']);
        $newPasswordValidation = Securite::secureHTML($_POST['newPassValidation']);

        if (empty($_COOKIE['token'])) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        if ($newPassword !== $newPasswordValidation) {
            Utils::newAlert('Les deux mots de passes ne sont pas identiques', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil');
        }

        try {
            $this->connexionController->validateConnection($_COOKIE['id'], $password);

            $this->passwordManager->updatePassword(Utils::hashPassword($newPassword), $_COOKIE['id']);

            Utils::newAlert('Mot de passe changé avec succès', Constants::TYPES_MESSAGES['success']);
            Utils::redirect(URL . 'profil');
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil');
        }
    }
}
