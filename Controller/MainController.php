<?php


require_once("Model/Render.php");

/**
 * Le Main controller pour gérer l'affichage des pages
 */
class MainController extends Render
{
    /**
     * @var PhotoManager Le manager pour les photos
     */
    private PhotoManager $photoManager;
    /**
     * @var CompteController Le controller pour le compte
     */
    private CompteController $compteController;
    /**
     * @var PhotoController Le controller pour les photos
     */
    private PhotoController $photoController;
    /**
     * @var CompteManager Le manager pour les comptes
     */
    private CompteManager $compteManager;

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();

        $this->photoManager = new PhotoManager;
        $this->photoController = new PhotoController;
        $this->compteController = new CompteController;
        $this->compteManager = new CompteManager;
    }

    /**
     * Permet d'afficher la page d'accueil
     */
    public function accueil(): void
    {
        $this->render([
            "title" => "Accueil",
            "description" => "Le meilleur site de partage de photo entre amateur | Foto",
            "showFooter" => true,
            "showHeader" => true,
            "pageCss" => ['accueil', 'nav', 'footer'],
            "photos" => $this->photoManager->getPreviews(),
            "view" => 'View/layouts/accueil.php',
            "template" => 'View/base.php'
        ]);
    }

    /**
     * Permet d'afficher la galerie
     */
    public function galerie(): void
    {
        $this->render([
            "title" => "Galerie",
            "description" => "Galerie de Foto",
            "showFooter" => true,
            "showHeader" => true,
            "pageScripts" => ['photoGalerie'],
            "pageCss" => ['galerie', 'filtres', 'popupGalerie', 'paginator', 'photoGalerie', 'nav', 'footer'],
            "photos" => $this->photoController->getPhotos(),
            "view" => "View/layouts/galerie.php",
            "template" => 'View/base.php'
        ]);
    }

    /**
     * Permet d'afficher le profil utilisateur
     */
    public function profil(): void
    {
        if (!Utils::userConnected()) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        };

        $this->render([
            "title" => 'Profil',
            "description" => 'Profil d\'un utilisateur de Foto',
            "showFooter" => true,
            "showHeader" => true,
            "pageScripts" => ['profil', 'photoGalerie', 'filter'],
            "pageCss" => ['profil', 'popupGalerie', 'infos', 'galerie', 'filtres', 'paginator', 'photoGalerie', 'nav', 'footer'],
            "infos" => $this->compteManager->getUserInfo($_COOKIE['id']),
            "compteActif" => $this->compteManager->compteActif($_COOKIE["id"]),
            "mailUser" => $this->compteManager->getUserEmail($_COOKIE['id']),
            "photos" => $this->photoController->getPhotosByUser(),
            'view' => 'View/layouts/profil.php',
            'template' => 'View/base.php'
        ]);
    }

    /**
     * Permet d'afficher la page admin
     */
    public function admin(): void
    {
        if (!Utils::userConnected()) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        };

        $this->render([
            "title" => 'Profil Admin',
            "description" => 'Profil administrateur d\'un utilisateur de Foto',
            "showFooter" => true,
            "showHeader" => true,
            "pageScripts" => ['profil'],
            "pageCss" => ['admin', 'infos', 'nav', 'footer'],
            "infos" => $this->compteManager->getUserInfo($_COOKIE['id']),
            "stats" => $this->compteController->getStatsAdmin(),
            "comptesWarn" => $this->compteController->getComptesWarn(),
            'view' => 'View/layouts/admin.php',
            'template' => 'View/base.php'
        ]);
    }

    /**
     * Permet d'afficher la page d'inscription
     */
    public function inscription(): void
    {
        if (Utils::userConnected()) {
            Utils::newAlert('Un utilisateur est déjà connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil');
        }

        $this->render([
            'title' => 'Inscription',
            'description' => 'Inscription à Foto',
            "showFooter" => false,
            "showHeader" => false,
            "pageCss" => ['signUp', 'nav', 'footer'],
            'view' => 'View/layouts/signUp.php',
            'template' => 'View/base.php'
        ]);
    }

    /**
     * Permet d'afficher la page de connexion
     */
    public function connexion(): void
    {
        if (!empty($_COOKIE['token'])) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        $this->render([
            'title' => 'Connexion',
            'description' => 'Connexion à Foto',
            "showFooter" => false,
            "showHeader" => false,
            "pageCss" => ['connect', 'nav', 'footer'],
            'view' => 'View/layouts/connect.php',
            'template' => 'View/base.php'
        ]);
    }

    /**
     * Permet d'afficher la page d'erreur
     *
     * @param int $code Le code d'erreur
     * @param string $message Le message d'erreur
     */
    public function error(int $code, string $message): void
    {
        $this->render([
            'title' => 'Erreur',
            'description' => 'Oups il s\'emblerait qu\'il y ai une erreur',
            "showFooter" => false,
            "showHeader" => false,
            "pageCss" => ['error', 'nav', 'footer'],
            'code' => $code,
            'message' => $message,
            'view' => 'View/layouts/error.php',
            'template' => 'View/base.php'
        ]);
    }

    /**
     * Permet d'afficher la d'upload de photo
     */
    public function ajouter(): void
    {
        $this->render([
            'title' => 'Ajouter une photo',
            'description' => 'Ajouter une photo à Foto',
            "showFooter" => false,
            "showHeader" => false,
            "pageCss" => ['upload', 'nav', 'footer'],
            'view' => 'View/layouts/upload.php',
            'template' => 'View/base.php'
        ]);
    }

    /**
     * Permet d'afficher la page de reset du mot de passe
     */
    public function resetMdp(): void
    {
        $this->render([
            'title' => 'Reinitialisation le mot de passe',
            'description' => 'Réinitialiser le mot de passe de mon compte Foto',
            'showFooter' => false,
            'showHeader' => false,
            'pageCss' => ['reset'],
            'view' => 'View/layouts/reset.php',
            'template' => 'View/base.php'
        ]);
    }

    /**
     * Permet d'afficher la page de validation d'email
     */
    public function validateEmail(): void
    {
        $this->render([
            'title' => 'Valider l\'email',
            'description' => 'Valider votre email',
            'showFooter' => false,
            'showHeader' => false,
            'pageCss' => ['validateEmail'],
            'view' => 'View/layouts/validateEmail.php',
            'template' => 'View/base.php'
        ]);
    }
}
