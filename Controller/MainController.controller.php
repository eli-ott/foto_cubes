<?php

require_once("./Model/Render.php");
require_once("./Model/PhotoManager.php");
require_once("./Model/CompteManager.php");

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
        if (!$_COOKIE['token']) {
            throw new Exception('Aucun utilisateur connecté', 405); //! Retourne une erreur si personne n'est connecté
        }

        $this->render([
            "title" => 'Profil',
            "description" => 'Profil d\'un utilisateur de Foto',
            "infos" => $this->compteManager->getUserInfo($_SESSION['idUser']),
            'view' => 'View/layouts/profil.php',
            'template' => 'View/base.php'
        ]);
    }

    /**
     * Permet d'afficher la page d'inscription
     */
    public function inscription(): void
    {
        if ($_COOKIE['token']) {
            throw new Exception('Un utilisateur est déjà connecté', 405); //! retourne une erreur si un utilisateur est déjà connecté
        }

        $this->render([
            'title' => 'Inscription',
            'description' => 'Inscription à Foto',
            'view' => 'View/layouts/signUp.php',
            'template' => 'View/base.php'
        ]);
    }

    /**
     * Permet d'afficher la page de connexion
     */
    public function connexion(): void
    {
        if ($_COOKIE['token']) {
            throw new Exception('Un utilisateur est déjà connecté', 405); //! retourne une erreur si un utilisateur est déjà connecté
        }

        $this->render([
            'title' => 'Connexion',
            'description' => 'Connexion à Foto',
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
            'code' => $code,
            'message' => $message,
            'view' => 'View/layouts/error.php',
            'template' => 'View/base.php'
        ]);
    }
}
