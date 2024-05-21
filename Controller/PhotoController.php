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
        if (!Utils::userConnected()) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        try {
            $photo = new Photo(
                id: null,
                titre: Securite::secureHTML($_POST['titre']),
                tag: Securite::secureHTML($_POST['tag']),
                source: Utils::uploadFile($_FILES['source']),
                datePriseVue: Securite::secureHTML($_POST['datePriseVue']),
                photographe: $this->compteManager->getUserInfo($_COOKIE['id']),
                datePublication: null
            );

            $this->photoManager->addPhoto($photo);

            Utils::newAlert('Photo enregistré avec succès', Constants::TYPES_MESSAGES['success']);
            Utils::redirect(URL . 'profil/1');
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'ajouter');
        }
    }

    /**
     * Permet de supprimer une photo
     */
    public function deletePhoto(): void
    {
        if (!Utils::userConnected()) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        $photo = new Photo(
            id: Securite::secureHTML($_POST['idPhoto']),
            titre: Securite::secureHTML($_POST['titre']),
            tag: Securite::secureHTML($_POST['tag']),
            source: Securite::secureHTML($_POST['source']),
            datePriseVue: Securite::secureHTML($_POST['datePriseVue']),
            datePublication: null,
            photographe: $this->compteManager->getUserInfo(Securite::secureHTML($_POST['idUser'])),
            orientation: null
        );

        try {
            $this->photoManager->deletePhoto($photo);
        } catch (Exception $e) {
            Utils::newAlert($e->getMessage(), Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil/1');
        }
    }

    /**
     * Permet de modifier une photo
     */
    public function updatePhoto(): void
    {
        if (!Utils::userConnected()) {
            Utils::newAlert('Aucun utilisateur connecté', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'connexion');
        }

        $photo = new Photo(
            id: Securite::secureHTML($_POST['idPhoto']),
            titre: Securite::secureHTML($_POST['titre']),
            tag: Securite::secureHTML($_POST['tag']),
            source: null,
            datePriseVue: null,
            datePublication: null,
            photographe: null,
            orientation: null
        );

        try {
            $this->photoManager->updatePhoto($photo);

            Utils::newAlert('Photo modifié avec succès', Constants::TYPES_MESSAGES['success']);
            Utils::redirect(URL . 'profil/1');
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