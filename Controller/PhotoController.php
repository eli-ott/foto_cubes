<?php

require_once("Model/PhotoManager.php");
require_once("Model/CompteManager.php");

class PhotoController
{
    /**
     * @var PhotoManager $photoManager Le manager pour les photos
     */
    private $photoManager;
    /**
     * @var CompteManager $compteManager Le manager pour les comptes
     */
    private $compteManager;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->photoManager = new PhotoManager;
        $this->compteManager = new CompteManager;
    }

    /**
     * Permet d'ajouter une nouvelle photo
     */
    public function addPhoto(): void
    {
        if (empty($_COOKIE['token'])) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        $photo = new Photo(
            titre: Securite::secureHTML($_POST['titre']),
            tag: Securite::secureHTML($_POST['tag']),
            source: Securite::secureHTML($_POST['source']),
            datePriseVue: Securite::secureHTML($_POST['datePriseVue']),
            photographe: $this->compteManager->getUserInfo($_COOKIE['id'])
        );

        try {
            $this->photoManager->addPhoto($photo);
        } catch (Exception $e) {
            Utils::newAlert('Erreur lors de la sauvegarde de la photo', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'upload');
        }
    }

    /**
     * Permet de supprimer une photo
     */
    public function deletePhoto(): void
    {
        if (empty($_COOKIE['token'])) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        $photo = new Photo(
            titre: Securite::secureHTML($_POST['titre']),
            tag: Securite::secureHTML($_POST['tag']),
            source: Securite::secureHTML($_POST['source']),
            datePriseVue: Securite::secureHTML($_POST['datePriseVue']),
            photographe: $this->compteManager->getUserInfo(Securite::secureHTML($_POST['idUser']))
        );

        try {
            $this->photoManager->deletePhoto($photo);
        } catch (Exception $e) {
            Utils::newAlert('Erreur lors de la suppression de la photo', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil/1');
        }
    }

    /**
     * Permet de modifier une photo
     */
    public function updatePhoto(): void
    {
        if (empty($_COOKIE['token'])) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        $photo = new Photo(
            titre: Securite::secureHTML($_POST['titre']),
            tag: Securite::secureHTML($_POST['tag']),
            source: Securite::secureHTML($_POST['source']),
            datePriseVue: Securite::secureHTML($_POST['datePriseVue']),
            photographe: $this->compteManager->getUserInfo($_COOKIE['id'])
        );

        try {
            $this->photoManager->updatePhoto($photo);
        } catch (Exception $e) {
            Utils::newAlert('Erreur lors de la modification de la photo', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil/1');
        }
    }

    /**
     * Permet de récupérer les photos
     * 
     * @return ?array Les photos
     */
    public function getPhotos(): ?array
    {
        try {
            $url = explode('/', $_GET['page']);
            return $this->photoManager->getPhotos(Securite::secureHTML(end($url)) ?? 1);
        } catch (Exception $e) {
            Utils::newAlert('Erreur lors de la récupération des photos', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'galerie');
        }
    }

    /**
     * Permet de récupérer les photos d'un utilisateur
     * 
     * @return ?array Les photos de l'utilisateur
     */
    public function getPhotosByUser(): ?array
    {
        if (empty($_COOKIE['id'])) {
            Utils::newAlert('L\'utilisateur n\'a pas été trouvé', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'erreur');
        }

        try {
            $url = explode('/', $_GET['page']);
            return $this->photoManager->getPhotosByUser(Securite::secureHTML(end($url)) ?? 1, Securite::secureHTML($_COOKIE['id']));
        } catch (Exception $e) {
            Utils::newAlert('Erreur lors de la récupération des photos de l\'utilisateur', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil/1');
        }
    }
}
