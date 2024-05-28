<?php

/**
 * Le controller pour les comptes
 */
class CompteController
{
    /**
     * @var CompteManager $compteManager Le manager pour le compte
     */
    private CompteManager $compteManager;

    /**
     * @var PasswordManager $passwordManager Le controller pour les mots de passes
     */
    private PasswordManager $passwordManager;
    /**
     * @var ConnexionController $connexionController Le controller pour les connexions
     */
    private ConnexionController $connexionController;
    /**
     * @var PhotoManager Le manager pour les photos
     */
    private PhotoMAnager $photoManager;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->compteManager = new CompteManager;
        $this->passwordManager = new PasswordManager;
        $this->connexionController = new ConnexionController;
        $this->photoManager = new PhotoManager;
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
        if (!empty($_POST['honeypot'])) {
            Utils::newAlert('Robot détecté, le formulaire ne sera pas envoyé', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'erreur');
        }

        if (Utils::userConnected()) {
            Utils::newAlert('Un utilisateur est déjà connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil/1');
        }

        try {
            $data = Utils::verifFields(['nom', 'prenom', 'pseudo', 'email', 'age', 'typePhotoPref', 'password', 'passwordValidation']);

            $photographe = new Photographe(
                $data['nom'],
                $data['prenom'],
                $data['pseudo'],
                $data['email'],
                age: $data['age'],
                typePhotoPref: $data['typePhotoPref'],
            );

            if ($data['password'] !== $data['passwordValidation']) {
                Utils::newAlert('Les mots de passes ne sont pas identiques', Constants::TYPES_MESSAGES['error']);
                Utils::redirect(URL . 'inscription');
            }

            //vérifie que le pseudo est unique
            if ($this->pseudoUtilise($photographe->getPseudo())) {
                throw new Exception('Le pseudo est déjà utilisé, veuillez en choisir un autre ou vous connecter', 405);
            }

            $passwordId = $this->passwordManager->createPassword(Utils::hashPassword($data['password']));

            $photographe->setIdMdp($passwordId);

            $newPhotographe = $this->compteManager->addUser($photographe);

            setcookie('token', Utils::generateToken(), time() + Utils::hoursToSeconds(24), '/');
            setcookie('id', $newPhotographe->getId(), time() + Utils::hoursToSeconds(24), '/');
            setcookie('isAdmin', (int)$this->compteManager->isAdmin($newPhotographe->getId()), time() + Utils::hoursToSeconds(24), '/');

            Utils::verifMail($photographe->getEmail());

            Utils::newAlert('Compte créée avec succès', Constants::TYPES_MESSAGES['success']);
            Utils::redirect(URL . 'valider');
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
        if (!Utils::userConnected()) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        try {
            $passwordToDelete = $this->passwordManager->getPassword($_COOKIE['id'])->getId();

            $this->photoManager->deleteUserPhotos($_COOKIE['id']);
            $this->compteManager->deleteUser($_COOKIE['id']);
            $this->passwordManager->deletePassword($passwordToDelete);

            unset($_COOKIE['token']);
            unset($_COOKIE['id']);
            unset($_COOKIE['isAdmin']);
            setcookie('token', '', 1, '/');
            setcookie('id', '', 1, '/');
            setcookie('isAdmin', '', 1, '/');

            Utils::newAlert('Votre compte a été supprimé avec succès', Constants::TYPES_MESSAGES['success']);
            Utils::redirect(URL . 'accueil');
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil/1');
        }
    }

    /**
     * Permet de mettre à jour les infos de l'utilisateur
     */
    public function updateInfosUser(): void
    {
        if (!Utils::userConnected()) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        try {
            $data = Utils::verifFields(['field', 'value']);

            $this->compteManager->updateUser($data['field'], $data['value'], $_COOKIE['id']);

            Utils::newAlert($data['field'] . ' modifié avec succès', Constants::TYPES_MESSAGES['success']);
            Utils::redirect(URL . 'profil/1');
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil/1');
        }
    }

    /**
     * Permet de récupérer les infos de l'utilisateur'
     *
     * @return Photographe Le photographe
     */
    public function getUserInfo(): Photographe
    {
        if (empty($_COOKIE['token'])) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        try {
            return $this->compteManager->getUserInfo($_COOKIE['id']);
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil/1');
        }
    }

    /**
     * Permet de vérifier si le code entré est le bon
     */
    public function validateEmail(): void
    {

        if (!Utils::userConnected()) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        try {
            $data = Utils::verifFields(['code']);

            if (Utils::verifCode($data['code'])) {
                $this->compteManager->validateAccount($_COOKIE['id']);

                Utils::newAlert('Compte validé avec succès', Constants::TYPES_MESSAGES['success']);
                Utils::redirect(URL . 'profil/1');
            } else {
                Utils::newAlert('Mauvais code', Constants::TYPES_MESSAGES['error']);
                Utils::redirect(URL . 'valider');
            }
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'valider');
        }
    }

    /**
     * Permet de reset le mot de passe de l'utilisateur
     */
    public function resetMdp(): void
    {
        if (!empty($_POST['honeypot'])) {
            Utils::newAlert('Robot détecté, le formulaire ne sera pas envoyé', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'erreur');
        }


        try {
            $data = Utils::verifFields(['pseudo', 'password', 'newPass', 'newPassValidation']);

            if ($data['newPass'] !== $data['newPassValidation']) {
                Utils::newAlert('Les nouveaux mots de passes ne correspondent pas', Constants::TYPES_MESSAGES['error']);
                Utils::redirect(URL . 'mdp-oublie');
            }

            $idUser = $this->compteManager->getUserId($data['pseudo']);

            if ($this->connexionController->validateConnection($idUser, $data['password'])) {
                $this->passwordManager->updatePassword(Utils::hashPassword($data['newPass']), $idUser);
            }

            Utils::newAlert('Mot de passe modifié avec succès', Constants::TYPES_MESSAGES['success']);
            Utils::redirect(URL . 'connexion');
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'mdp-oublie');
        }
    }

    /**
     * Permet d'ajouter un flag sur un Compte
     */
    public function flagUser(): void
    {

        if (!Utils::userConnected()) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        try {
            $data = Utils::verifFields(['pseudo']);

            if (Utils::userAdmin()) {
                $this->compteManager->flagUser($this->compteManager->getUserId($data['pseudo']));

                Utils::newAlert('Flag ajouté avec succès', Constants::TYPES_MESSAGES['success']);
            } else {
                Utils::newAlert('Vous n\'êtes pas administrateur', Constants::TYPES_MESSAGES['error']);
            }

            Utils::redirect(URL . 'galerie/1');
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'erreur');
        }
    }

    /**
     * Permet de passer un autre utilisateur comme étant admin
     */
    public function makeUserAdmin(): void
    {

        if (!Utils::userConnected()) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        try {
            $data = Utils::verifFields(['pseudo']);

            if (Utils::userAdmin()) {
                $this->compteManager->makeUserAdmin($this->compteManager->getUserId($data['pseudo']));

                Utils::newAlert('L\'utilisateur est maintenant admin', Constants::TYPES_MESSAGES['success']);
            } else {
                Utils::newAlert('Erreur lors de l\'ajout de l\'utilisateur comme étant admin', Constants::TYPES_MESSAGES['error']);
            }
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'erreur');
        }
    }

    /**
     * Permet de récupérer les stats de la page admin
     *
     * @return StatsAdmin Les stats
     */
    public function getStatsAdmin(): StatsAdmin
    {
        if (!Utils::userConnected()) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        if (!Utils::userAdmin()) {
            Utils::newAlert('Vous n\'êtes pas administrateur', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil');
        }

        try {
            return $this->compteManager->getStatsAdmin();
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil');
        }
    }

    /**
     * Permet de récupérer les comptes warns
     *
     * @return Photographe[] Les comptes warns
     */
    public function getComptesWarn(): array
    {
        if (!Utils::userConnected()) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        if (!Utils::userAdmin()) {
            Utils::newAlert('Vous n\'êtes pas administrateur', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil');
        }

        try {
            return $this->compteManager->getComptesWarn();
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil');
        }
    }
}
