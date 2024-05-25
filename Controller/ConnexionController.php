<?php

/**
 * Le controller pour les comptes
 */
class ConnexionController
{
    /**
     * @var PasswordManager $passwordManager Le manager pour les mots de passes
     */
    private PasswordManager $passwordManager;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->passwordManager = new PasswordManager;
    }

    /**
     * Permet de valider la connection
     *
     * @param int $idUser L'identifiant de l'utilisateur
     * @param string $password Le mot de passe
     * @return int Le code status si aucune erreur
     * @throws Exception
     */
    public function validateConnection(int $idUser, string $password): int
    {
        $idUser = Securite::secureHTML($idUser);
        $password = Securite::secureHTML($password);

        $hash = $this->passwordManager->getPassword($idUser)->getHash();

        if (password_verify($password, $hash)) {
            return 200;
        } else {
            throw new Exception('Pseudo ou mot de passe incorrect', 405);
        }
    }

    /**
     * Permet de déconnecter l'utilisateur
     */
    public function disconnect(): void
    {
        if (!Utils::userConnected()) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        unset($_COOKIE['token']);
        unset($_COOKIE['id']);
        unset($_COOKIE['isAdmin']);
        setcookie('token', '', 1, '/');
        setcookie('id', '', 1, '/');
        setcookie('isAdmin', '', 1, '/');

        Utils::newAlert('Vous êtes déconnecté', Constants::TYPES_MESSAGES['success']);
        Utils::redirect(URL . 'connexion');
    }
}
