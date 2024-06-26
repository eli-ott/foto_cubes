<?php

class Photographe implements JsonSerializable
{
    /**
     * @var int $id L'identifiant du photographe
     */
    private $id;
    /**
     * @var string $nom Le nom du photographe
     */
    private $nom;
    /**
     * @var string $prenom Le prénom du photographe
     */
    private $prenom;
    /**
     * @var string $pseudo Le pseudo
     */
    private $pseudo;
    /**
     * @var string $email L'email
     */
    private $email;
    /**
     * @var int $age Son age
     */
    private $age;
    /**
     * @var string $typePhotoPref Le type de photo préféré du photographe
     */
    private $typePhotoPref;
    /**
     * @var DateTime $dateCreation la date de création de son compte
     */
    private $dateCreation;
    /**
     * @var bool $warn Si le compte est warn
     */
    private $warn;

    /**
     * Constructor
     * 
     * @param int $id L'identifiant
     * @param string $nom Le nom
     * @param string $prenom Le prénom
     * @param string $pseudo Le pseudo
     * @param string $email L'email
     * @param int $age L'age
     * @param string $typePhotoPref Le type de photo préféré du photographe
     * @param DateTime $dateCreation La date de création du compte
     * @param bool $warn Si l'utilisateur est warn
     */
    public function __construct(
        int $id = null,
        string $nom,
        string $prenom,
        string $pseudo,
        string $email,
        int $age = null,
        string $typePhotoPref = null,
        DateTime $dateCreation = null,
        bool $warn = null
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->age = $age;
        $this->typePhotoPref = $typePhotoPref;
        $this->dateCreation = $dateCreation;
        $this->warn = $warn;
    }

    /**
     * Récupère l'id du photographe
     * 
     * @return int L'id du photographe
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Récupère le nom du photographe
     * 
     * @return string Le nom
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Récupère le prenom du photographe
     * 
     * @return string Le prenom
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * Récupère le pseudo du photographe
     * 
     * @return string Le pseudo
     */
    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    /**
     * Récupère le email du photographe
     * 
     * @return string Le email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Récupère le age du photographe
     * 
     * @return int L'age
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * Récupère le type de photo préféré du photographe
     * 
     * @return string Le type de photo préféré
     */
    public function getTypePhotoPref(): string
    {
        return $this->typePhotoPref;
    }

    /**
     * Récupère la date de création du compte du photographe
     * 
     * @return DateTime La date de création du compte
     */
    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }

    /**
     * Récupère si le compte est warn ou non
     * 
     * @return DateTime Si le compte est warn ou non
     */
    public function getWarn(): bool
    {
        return $this->warn;
    }

    /**
     * Serialize le tableau en objet
     * 
     * @return mixed Le tableau associatif contenant les valeurs
     */
    public function jsonSerialize(): mixed
    {
        return [
            "nom" => $this->nom,
            "prenom" => $this->prenom,
            "pseudo" => $this->pseudo,
            "email" => $this->email,
            "age" => $this->age,
            "typePhotoPref" => $this->typePhotoPref,
            "dateCreation" => $this->dateCreation,
            "warn" => $this->warn
        ];
    }
}
