<?php

/**
 * La classe pour les stats de la page administrateur
 */
class StatsAdmin implements JsonSerializable
{
    /**
     * @var int $photosPostees Le nombre total de photos postées
     */
    private int $photosPostees;
    /**
     * @var int $comptesTotal Le nombre total de comptes créés
     */
    private int $comptesTotal;
    /**
     * @var int $comptesValides Le nombre total de comptes validés
     */
    private int $comptesValides;
    /**
     * @var int $comptesWarn Le nombre total de comptes warn
     */
    private int $comptesWarn;

    /**
     * Le constructeur
     */
    public function __construct(
        int $photosPostees,
        int $comptesTotal,
        int $comptesValides,
        int $comptesWarn
    )
    {
        $this->photosPostees = $photosPostees;
        $this->comptesTotal = $comptesTotal;
        $this->comptesValides = $comptesValides;
        $this->comptesWarn = $comptesWarn;
    }

    /**
     * Permet de récupérer le nombre de photos postées
     *
     * @return int Le nombre de photos postées
     */
    public function getPhotosPostees(): int
    {
        return $this->photosPostees;
    }

    /**
     * Permet de récupérer le nombre de comptes créés
     *
     * @return int Le nombre total de comptes
     */
    public function getComptesTotal(): int
    {
        return $this->comptesTotal;
    }

    /**
     * Permet de récupérer le nombre de comptes validés
     *
     * @return int Le nombre de comptes validés
     */
    public function getComptesValides(): int
    {
        return $this->comptesValides;
    }

    /**
     * Permet de récupérer le nombre de comptes wars
     *
     * @return int Le nombre de comptes warn
     */
    public function getComptesWarn(): int
    {
        return $this->comptesWarn;
    }

    /**
     * Sérialization des données en un tableau associatif
     *
     * @return array Le tableau associatif des données
     */
    public function jsonSerialize(): array
    {
        return [
            "photosPostees" => $this->photosPostees,
            "comptesTotal" => $this->comptesTotal,
            "comptesValides" => $this->comptesValides,
            "comptesWarn" => $this->comptesWarn
        ];
    }
}