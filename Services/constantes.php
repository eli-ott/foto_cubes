<?php

class Constants
{
    /**
     * @var array TYPE_PHOTOS les different types de photos
     */
    const TYPE_PHOTOS = [
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
    const TYPES_MESSAGES = [
        'info' => 'info',
        'warning' => 'warning',
        'error' => 'error',
        'success' => 'success'
    ];

    /**
     * @var string DELETE_CONFIRMATION La phrase pour confirmer la suppression de son compte
     */
    const DELETE_CONFIRMATION = 'SUPPRIMER MON COMPTE';

    /**
     * @var int IMAGES_PAR_PAGE Le nombre d'images visible par page
     */
    const IMAGES_PAR_PAGE = 10;

    /**
     * @var string URL_DOCUMENT L'url om sont situés les documents
     */
    const URL_DOCUMENT = 'Public/assets/uploads/';

    /**
     * @var array EXTENSIONS_ACCEPTEES Les extensions acceptées
     */
    const EXTENSIONS_ACCEPTEES = [
        'jpeg',
        'jpg',
        'png',
        'webp'
    ];
}
