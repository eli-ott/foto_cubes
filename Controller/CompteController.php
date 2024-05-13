<?php

require_once('Model/PasswordManager.php');
require_once('Model/CompteManager.php');


class CompteController
{
    /**
     * @var CompteManager $compteManager Le manager pour le compte
     */
    private $compteManager;

    /**
     * @var PasswordManager $passwordManager Le controller pour les mots de passes
     */
    private $passwordManager;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->compteManager = new CompteManager;
        $this->passwordManager = new PasswordManager;
    }

    /**
     * Permet de vérifier si un pseudo a déjà été utilisé ou non
     * 
     * @param string $pseudo Le pseudo
     * @return bool Si le pseudo a déjà été utilisé ou non
     */
    public function pseudoUtilise(string $pseudo): bool
    {
        $pseudo = Securite::secureHTML($pseudo);

        if ($this->compteManager->nbPseudo($pseudo) >= 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Permet de créer un compte
     */
    public function addCompte(): void
    {
        $photographe = new Photographe(
            null,
            null,
            Securite::secureHTML($_POST['nom']),
            Securite::secureHTML($_POST['prenom']),
            Securite::secureHTML($_POST['pseudo']),
            Securite::secureHTML($_POST['email']),
            Securite::secureHTML($_POST['age']),
            Securite::secureHTML($_POST['typePhotoPref']),
            null,
            null,
            null
        );
        $password = Securite::secureHTML($_POST['password']);
        $passwordValidation = Securite::secureHTML($_POST['passwordValidation']);

        if (!empty($_COOKIE['token'])) {
            Utils::newAlert('Un utilisateur est déjà connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil');
        }

        if ($password !== $passwordValidation) {
            Utils::newAlert('Les mots de passes ne sont pas identiques', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'inscription');
        }

        try {
            //vérifie que le pseudo est unique
            if ($this->pseudoUtilise($photographe->getPseudo())) {
                throw new Exception('Le pseudo est déjà utilisé, veuillez en choisir un autre ou vous connecter', 405);
            }

            $passwordId = $this->passwordManager->createPassword(Utils::hashPassword($password));

            $photographe->setIdMdp($passwordId);

            $newPhotographe = $this->compteManager->addUser($photographe);

            setcookie('token', Utils::generateToken(), time() + Utils::hoursToSeconds(24), '/');
            setcookie('id', $newPhotographe->getId(), time() + Utils::hoursToSeconds(24), '/');
            setcookie('isAdmin', $this->compteManager->isAdmin($newPhotographe->getId()), time() + Utils::hoursToSeconds(24), '/');

            Utils::newAlert('Compte créée avec succès', Constants::TYPES_MESSAGES['success']);
            Utils::redirect(URL . 'profil');
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'inscription');
        }
    }

    /**
     * Permet de supprimer un compte
     */
    public function deleteCompte(): void
    {
        if (empty($_COOKIE['token'])) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        try {
            $this->compteManager->deleteUser($_COOKIE['id']);

            $this->passwordManager->deletePassword($_COOKIE['id']);

            unset($_COOKIE['token']);
            unset($_COOKIE['id']);
            unset($_COOKIE['isAdmin']);
            setcookie('token', '', 1, '/');
            setcookie('id', '', 1, '/');
            setcookie('isAdmin', '', 1, '/');

            //TODO: Test if the account deletion remove the token

            Utils::newAlert('Votre compte a été supprimé avec succès', Constants::TYPES_MESSAGES['success']);
            Utils::redirect(URL . 'accueil');
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil');
        }
    }

    /**
     * Permet de mettre à jour les infos de l'utilisateur
     */
    public function updateInfosUser(): void
    {
        $field = Securite::secureHTML($_POST['info']);
        $value = Securite::secureHTML($_POST['value']);

        if (empty($_COOKIE['token'])) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        try {
            $this->compteManager->updateUser($field, $value);

            Utils::newAlert($field . ' modifié avec succès', Constants::TYPES_MESSAGES['success']);
            Utils::redirect(URL . 'profil');
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil');
        }
    }
}
