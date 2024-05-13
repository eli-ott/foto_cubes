<?php

require_once('Services/Utils.php');
require_once('Services/constantes.php');
require_once("Model/Render.php");
require_once("Model/PhotoManager.php");
require_once("Model/CompteManager.php");

class MainController extends Render
{
    /** 
     * @var PhotoManager Le manager pour les photos 
     */
    private $photoManager;
    /** 
     * @var CompteManager Le manager pour le compte 
     */
    private $compteManager;

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct(Render::class);
        $this->photoManager = new PhotoManager;
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
            "pageCss" => ['galerie', 'filtres', 'paginator', 'photoGalerie', 'nav', 'footer'],
            "photos" => $this->photoManager->getPhotos(1),
            "view" => "View/layouts/galerie.php",
            "template" => 'View/base.php'
        ]);
    }

    /**
     * Permet d'afficher le profil utilisateur
     */
    public function profil(): void
    {
        if (empty($_COOKIE['token'])) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        $this->render([
            "title" => 'Profil',
            "description" => 'Profil d\'un utilisateur de Foto',
            "showFooter" => true,
            "showHeader" => true,
            "pageCss" => ['profil', 'galerie', 'filtres', 'paginator', 'photoGalerie', 'nav', 'footer'],
            "infos" => $this->compteManager->getUserInfo($_COOKIE['idUser']),
            'view' => 'View/layouts/profil.php',
            'template' => 'View/base.php'
        ]);
    }

    /**
     * Permet d'afficher la page d'inscription
     */
    public function inscription(): void
    {
        if (!empty($_COOKIE['token'])) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
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
}
