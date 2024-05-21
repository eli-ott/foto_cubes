<?php

class Photo implements JsonSerializable
{
    /**
     * @var ?int $id L'identifiant de la photo
     */
    private ?int $id;
    /** 
     * @var string $titre Le titre de la photo  
     */
    private string $titre;
    /**
     * @var string $tag Le tag de la photo
     */
    private string $tag;
    /**
     * @var string $source La source de la photo sous forme de blob
     */
    private ?string $source;
    /** 
     * @var string $datePriseVue La date de prise de vue
     */
    private ?string $datePriseVue;
    /**
     * @var string $datePublication La date de publication de la photo
     */
    private ?string $datePublication;
    /**
     * @var Photographe Le photographe
     */
    private ?Photographe $photographe;
    /**
     * @var string $orientation L'orientation de l'image
     */
    private ?string $orientation;

    /**
     * Le constructeur
     * 
     * @param ?int $id L'id de la photo
     * @param string $titre Le titre de la photo
     * @param string $tag Le tag de la photo
     * @param mixed $source La source de la photo
     * @param string $datePriseVue La date de la prise de vue
     * @param string $datePublication La date de publication de la photo sur le site
     * @param Photographe $photographe Le photographe
     * @param string $orientation
     */
    public function __construct(
        ?int $id = null,
        string $titre,
        string $tag,
        mixed $source = null,
        string $datePriseVue = null,
        ?string $datePublication = null,
        ?Photographe $photographe = null,
        ?string $orientation = null
    ) {
        $this->id = $id;
        $this->titre = $titre;
        $this->tag = $tag;
        $this->source = $source;
        $this->datePriseVue = $datePriseVue;
        $this->datePublication = $datePublication;
        $this->photographe = $photographe;
        $this->orientation = $orientation;
    }

    /**
     * Récupère l'id de la photo
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Récupère le titre de la photo
     * 
     * @return string Le titre
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * Récupère le tag de la photo
     * 
     * @return string Le tag
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * récupère la source de la photo en blob
     * 
     * @return mixed Le blob de l'image
     */
    public function getSource(): mixed
    {
        return $this->source;
    }

    /**
     * Récupère la date de prise de vue de la photo
     * 
     * @return string La date de prise de vue
     */
    public function getDatePriseVue(): string
    {
        return $this->datePriseVue;
    }

    /**
     * Récupère la date de publication de la photo
     * 
     * @return string La date de publication de la photo
     */
    public function getDatePublication(): string
    {
        return $this->datePublication;
    }

    /**
     * Récupère le photographe
     * 
     * @return Photographe Le photographe
     */
    public function getPhotographe(): Photographe
    {
        return $this->photographe;
    }

    /**
     * Permet de récupérer l'orientation de la photo
     * 
     * @return string L'orientation de la photo
     */
    public function getOrientation(): string
    {
        return $this->orientation;
    }

    /**
     * Sérialize le tableau associatif
     * 
     * @return mixed Le tableau associatif content les valeurs de la classe
     */
    public function jsonSerialize(): mixed
    {
        return [
            "titre" => $this->titre,
            "source" => $this->source,
            "datePriseVue" => $this->datePriseVue,
            "datePublication" => $this->datePublication,
            "photographe" => $this->photographe
        ];
    }
}
