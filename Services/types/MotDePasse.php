<?php
class MotDePasse implements JsonSerializable
{
    /**
     * @var int $id L'identifiant du mot de passe
     */
    private $id;
    /**
     * @var string hash Le hash du mot de passe
     */
    private $hash;
    /**
     * @var int nb_essais Le nombre d'essais de connexion
     */
    private $nbEssais;
    /**
     * @var ?string $dateReinitialisation La dernière date de réinitialisation
     */
    private $dateReinitialisation;

    /**
     * Le constructeur
     * 
     * @param int $id L'id du mot de passe
     * @param string $hash Le hash du mot de passe
     * @param int $nbEssais Le nombre d'essais de connexion
     * @param ?string $dateReinitialisation La dernière date de réinitialisation
     */
    public function __construct(
        int $id = null,
        string $hash,
        int $nbEssais,
        ?string $dateReinitialisation = null
    ) {
        $this->id = $id;
        $this->hash = $hash;
        $this->nbEssais = $nbEssais;
        $this->dateReinitialisation = $dateReinitialisation;
    }

    /**
     * Récupère l'id du mot de passe
     * 
     * @return int L'id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Récupère le hash du mot de passe
     * 
     * @return string Le hash
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * Récupère le nombre d'essais de connexion
     * 
     * @return int Le nombre d'essais
     */
    public function getNbEssais(): int
    {
        return $this->nbEssais;
    }

    /**
     * Récupère la dernière date de réinitialisation du mot de passe
     * 
     * @return string La date de réinitialisation
     */
    public function getDateReinitialisation(): string
    {
        return $this->dateReinitialisation;
    }

    /**
     * Sérialise les données en json
     * 
     * @return array Tableau associatif des données
     */
    public function jsonSerialize(): array
    {
        return [
            "id" => $this->id,
            "hash" => $this->hash,
            "nbEssais" => $this->nbEssais,
            "dateReinitialisation" => $this->dateReinitialisation
        ];
    }
}
