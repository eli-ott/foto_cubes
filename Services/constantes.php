<?php

class Constants
{
    /**
     * @var array TYPE_PHOTOS les different types de photos
     */
    static const TYPE_PHOTOS = [
        "Nature",
        "Portrait",
        "Urbain",
        "Paysage",
        "Automobile",
        "Street",
        "Sport",
        "Animalier",
        "Sous-marine",
        "Aviation",
        "Astro-photographie",
        "Boudoir"
    ];

    /**
     * @var array TYPES_MESSAGES Les différents types de messages
     */
    static const TYPES_MESSAGES = [
        'info' => 'info',
        'warning' => 'warning',
        'error' => 'error',
        'success' => 'success'
    ];

    /**
     * @var string DELETE_CONFIRMATION La phrase pour confirmer la suppression de son compte
     */
    static const DELETE_CONFIRMATION = 'SUPPRIMER MON COMPTE';

    /**
     * @var int IMAGES_PAR_PAGE Le nombre d'images visible par page
     */
    static const IMAGES_PAR_PAGE = 10;
}
