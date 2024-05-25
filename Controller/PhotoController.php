<?php

/**
 * Le controller pour toutes les photos
 */
class PhotoController
{
    /**
     * @var PhotoManager $photoManager Le manager pour les photos
     */
    private PhotoManager $photoManager;
    /**
     * @var CompteManager $compteManager Le manager pour les comptes
     */
    private CompteManager $compteManager;

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
            $data = Utils::verifFields(['titre', 'tag', 'datePriseVue']);

            $photo = new Photo(
                $data['titre'],
                $data['tag'],
                source: Utils::uploadFile($_FILES['source']),
                datePriseVue: $data['datePriseVue'],
                photographe: $this->compteManager->getUserInfo($_COOKIE['id']),
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


        try {
            $data = Utils::verifFields(['idPhoto', 'titre', 'tag', 'source', 'datePriseVue']);

            $photo = new Photo(
                $data['titre'],
                $data['tag'],
                $data['idPhoto'],
                $data['source'],
                $data['datePriseVue'],
                photographe: $this->compteManager->getUserInfo($data['idUser']),
            );

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


        try {
            $data = Utils::verifFields(['idPhoto', 'titre', 'tag']);

            $photo = new Photo(
                $data['titre'],
                $data['tag'],
                $data['idPhoto'],
            );

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
     * @return array Les photos
     */
    public function getPhotos(): array
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
     * @return array Les photos de l'utilisateur
     */
    public function getPhotosByUser(): array
    {
        if (empty($_COOKIE['id'])) {
            Utils::newAlert('L\'utilisateur n\'a pas été trouvé', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'erreur');
        }

        try {
            $url = explode('/', $_GET['page']);

            return $this->photoManager->getPhotosByUser(Securite::secureHTML(end($url)) ?? 1, $_COOKIE['id']);
        } catch (Exception $e) {
            Utils::newAlert('Erreur lors de la récupération des photos de l\'utilisateur', Constants::TYPES_MESSAGES['error']);
            Utils::redirect(URL . 'profil/1');
        }
    }
}
