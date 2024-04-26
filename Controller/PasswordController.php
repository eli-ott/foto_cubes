<?php

require_once("Model/PasswordManager.php");
require_once("Model/CompteManager.php");
require_once("Model/CompteController.php");

//TODO: Au lieu de retourner le code status, directement redirigé en mettant dans la session comme dans le pdf une toolbox pour afficher si tout c'est bien passé ou non

class PasswordController
{
    /**
     * @var PasswordManager $passwordManager Le manager pour les mots de passes
     */
    private $passwordManager;
    /**
     * @var CompteController $compteController Le controller pour les comptes
     */
    private $compteController;
    /**
     * @var CompteManager $compteManager Le manager pour les comptes
     */
    private $compteManager;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->compteController = new CompteController;
        $this->compteManager = new CompteManager;
        $this->passwordManager = new PasswordManager;
    }

    /**
     * Permet de valider la connection
     * 
     * @param ?string $pseudoParam Le pseudo
     * @param ?string $passwordParam Le mot de passe
     * @return int Le code status
     */
    public function validateConnection(?string $pseudoParam = null, ?string $passwordParam = null): int
    {
        $pseudo = $pseudoParam ?? Securite::secureHTML($_POST['pseudo']);
        $password = $passwordParam ?? Securite::secureHTML($_POST['password']);

        $idUser = $this->compteController->getUserId($pseudo);

        $ret = $this->passwordManager->getPassword($idUser);
        if (password_verify($password, $ret['password']->getHash())) {

            if ($this->compteController->compteActif($ret['userId']) === 200) { //TODO: Créer le manager pour le compte
                setcookie('token', Utils::generateToken(), time() + Utils::hoursToSeconds(24));
                setcookie('id', $ret['userId'], time() + Utils::hoursToSeconds(24));

                return 200;
            } else {
                throw new Exception('Le compte n\'a pas été validé', 405);
            }
        } else {
            return 405;
        }
    }

    /**
     * Permet d'ajouter un nouveau mot de passe
     * 
     * @param string $password Le mot de passe
     * @param string $passwordValidation La validation du mot de passe
     * @return int Le code status
     */
    public function addPassword(string $password, string $passwordValidation): int
    {
        $password = Securite::secureHTML($password);
        $passwordValidation = Securite::secureHTML($passwordValidation);

        if ($password === $passwordValidation) {
            return $this->passwordManager->createPassword(password_hash($password, PASSWORD_DEFAULT));
        } else {
            return 405;
        }
    }

    /**
     * Permet de mettre à jour un mot de passe
     * 
     * @param ?string $pseudoParam Le pseudo
     * @param ?string $passwordParam Le mot de passe actuel
     * @param ?string $newPassParam Le nouveau mot de passe
     * @param ?string $newPassValidationParam La validation du nouveau mot de passe
     * @return int Le code status
     */
    public function updatePassword(
        ?string $pseudoParam = null,
        ?string $passwordParam = null,
        ?string $newPassParam = null,
        ?string $newPassValidationParam = null
    ): int {
        $pseudoParam = $pseudoParam ?? Securite::secureHTML($_POST['pseudo']);
        $passwordParam = $passwordParam ??  Securite::secureHTML($_POST['password']);
        $newPassParam = $newPassParam ?? Securite::secureHTML($_POST['newPass']);
        $newPassValidationParam = $newPassValidationParam ?? Securite::secureHTML($_POST['newPassValidation']);

        if (empty($_COOKIE['token'])) {
            throw new Exception('Aucun utilisateur connecté', 405);
        }

        if ($this->validateConnection($pseudoParam, $passwordParam) === 200 && $newPassParam === $newPassValidationParam) {
            return $this->passwordManager->updatePassword(password_hash($newPassParam, PASSWORD_DEFAULT), $_COOKIE['id']);
        } else {
            return 405;
        }
    }

    /**
     * Permet de supprimer un mot de passe
     * 
     * @param ?string $pseudoParam Le pseudo
     */
    public function deletePassword(?string $pseudoParam = null): void
    {
        $pseudo = $pseudoParam ?? Securite::secureHTML($_POST['pseudo']);
        
        $idUser = $this->compteManager->getUserId($pseudo);

        if(empty($_COOKIE['token'])) {
            throw new Exception('Aucun utilisateur connecté',405); //TODO: Redirigé directement ou ajouter une alerte comme quoi personne n'est connecté
        } else {
            if($this->passwordManager->deletePassword($idUser) === 200) {
                //TODO: Redirigé vers la page d'accueil avec un message comme quoi tout s'est bien passé
            } else {
                //TODO: Bah l'inverse finalement, resté sur la page et dire que ça c'est mal passé
            }
        }
    }
}
