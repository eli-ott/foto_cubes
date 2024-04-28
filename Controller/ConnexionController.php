<?php

require_once('Model/CompteManager.php');
require_once('Model/MessageManager.php');

class ConnexionController
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
     * Constructeur
     */
    public function __construct()
    {
        $this->passwordManager = new PasswordManager;
        $this->compteManager = new CompteManager;
    }

    /**
     * Permet de valider la connection
     * 
     * @param int $idUser L'identifiant de l'utilisateur
     * @param string $password Le mot de passe
     * @return ?int Le code status si aucune erreur
     */
    public function validateConnection(int $idUser, string $password): ?int
    {
        $idUser = Securite::secureHTML($idUser);
        $password = Securite::secureHTML($password);

        $hash = $this->passwordManager->getPassword($idUser)->getHash();

        if (password_verify($password, $hash)) {
            if ($this->compteManager->compteActif($idUser)) {
                return 200;
            } else {
                throw new Exception('Le compte n\'est pas validé', 405);
            }
        } else {
            throw new Exception('Pseudo ou mot de passe incorrect', 405);
        }
    }

    /**
     * Permet de déconnecter l'utilisateur
     */
    public function disconnect(): void
    {
        if (empty($_COOKIE['token'])) {
            Utils::newAlert('Aucun utilisateur connecté', 405);
            Utils::redirect(URL . 'connexion');
        }

        unset($_COOKIE['token']);
        unset($_COOKIE['id']);
        setcookie('token', '', 1, '/');
        setcookie('id', '', 1, '/');
    }
}
