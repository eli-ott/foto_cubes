<?php

require_once("Services/Model.php");

class CompteManager extends Model
{
    /**
     * Permet de créer un nouveau compte
     *
     * @return Photographe Le dernier compte ajouté
     * @var int L'id du mot de passe
     * @var Photographe $photographe
     */
    public function addUser(Photographe $photographe): Photographe
    {
        $addUserSql = "INSERT INTO utilisateur (id_mot_de_passe, pseudo, nom, prenom, email, age, type_photo_pref) 
            VALUES (:idMdp, :pseudo, :nom, :prenom, :email, :age, :typePhotoPref)";

        $addUserReq = $this->getBDD()->prepare($addUserSql);

        $addUserReq->bindValue("idMdp", $photographe->getIdMdp(), PDO::PARAM_INT);
        $addUserReq->bindValue("pseudo", $photographe->getPseudo(), PDO::PARAM_STR);
        $addUserReq->bindValue("nom", $photographe->getNom(), PDO::PARAM_STR);
        $addUserReq->bindValue("prenom", $photographe->getPrenom(), PDO::PARAM_STR);
        $addUserReq->bindValue("email", $photographe->getEmail(), PDO::PARAM_STR);
        $addUserReq->bindValue("age", $photographe->getAge(), PDO::PARAM_INT);
        $addUserReq->bindValue("typePhotoPref", $photographe->getTypePhotoPref(), PDO::PARAM_STR);

        $addUserReq->execute();

        if ($addUserReq) {
            $lastInsertedRowSql = "SELECT * FROM utilisateur ORDER BY id_user DESC LIMIT 1";

            $lastInsertedRowReq = $this->getBDD()->prepare($lastInsertedRowSql);
            $lastInsertedRowReq->execute();
            if ($lastInsertedRowReq) {
                $data = null;
                while ($row = $lastInsertedRowReq->fetch(PDO::FETCH_ASSOC)) {
                    $data = new Photographe(
                        (int)$row['id_user'],
                        (int)$row['id_mot_de_passe'],
                        $row['nom'],
                        $row['prenom'],
                        $row['pseudo'],
                        $row['email'],
                        (int)$row['age'],
                        $row['type_photo_pref'],
                        $row['date_creation'],
                        (bool)$row['warn'],
                    );
                }

                return $data;
            } else {
                throw new Exception('Erreur lors de la récupération du dernier compte ajouté', 500);
            }
        } else {
            throw new Exception('Erreur lors de la création du compte', 500);
        }
    }

    /**
     * Mets à jour un compte d'un photographe
     *
     * @param int $idUser L'identifiant de l'utilisateur
     * @return int Le code statut
     */
    public function validateAccount(int $idUser): int
    {
        $sql = "UPDATE utilisateur SET compte_valide = 1 WHERE id_user = :idUser";

        $req = $this->getBDD()->prepare($sql);
        $req->bindValue("idUser", $idUser, PDO::PARAM_INT);
        $req->execute();

        if ($req) {
            $status = 200;
        } else {
            throw new Exception('Erreur lors de la mise à jour du compte utilisateur', 500);
        }

        return $status;
    }

    /**
     * Permet de supprimer un compte
     *
     * @param int $idUser L'identifiant de l'utilisateur à supprimer
     * @return int Le code statut
     */
    public function deleteUser(int $idUser): int
    {
        $sql = "DELETE FROM utilisateur WHERE id_user = :idUser";

        $req = $this->getBDD()->prepare($sql);
        $req->bindValue('idUser', $idUser, PDO::PARAM_INT);
        $req->execute();

        if ($req) {
            $status = 200;
        } else {
            throw new Exception('Erreur lors de la suppression du compte id ' . $idUser, 500);
        }

        return $status;
    }

    /**
     * Permet de récupérer les informations de l'utilisateur
     *
     * @param int $idUser L'identifiant de l'utilisateur
     * @return Photographe Les informations de l'utilisateur
     */
    public function getUserInfo(int $idUser): Photographe
    {
        $sql = "SELECT id_user, id_mot_de_passe, nom, prenom, email, pseudo, date_creation, type_photo_pref, age, warn, compte_valide 
            FROM utilisateur WHERE id_user = :idUser";

        $req = $this->getBDD()->prepare($sql);
        $req->bindValue('idUser', $idUser, PDO::PARAM_INT);
        $req->execute();

        $data = null;
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $data = new Photographe(
                (int)$row['id_user'],
                (int)$row['id_mot_de_passe'],
                $row['nom'],
                $row['prenom'],
                $row['pseudo'],
                $row['email'],
                (int)$row['age'],
                $row['type_photo_pref'],
                $row['date_creation'],
                (bool)$row['warn'],
                (bool)$row['compte_valide'],
            );
        }

        return $data;
    }

    /**
     * Permet de récupérer l'identifiant d'un utilisateur à partir de son pseudo
     *
     * @param string $pseudo Le pseudo
     * @return int L'identifiant de l'utilisateur
     */
    public function getUserId(string $pseudo): int
    {
        $sql = "SELECT id_user, pseudo FROM utilisateur WHERE pseudo = :pseudo";

        $req = $this->getBDD()->prepare($sql);
        $req->bindValue('pseudo', $pseudo, PDO::PARAM_STR);
        $req->execute();

        $idSelected = $req->fetch(PDO::FETCH_ASSOC)['id_user'];

        if (is_int($idSelected)) {
            return $idSelected;
        } else {
            throw new Exception('Aucun utilisateur associé au pseudo', 400);
        }
    }

    /**
     * Permet de récupérer si un compte est actif ou non
     *
     * @param int $idUser L'identifiant de l'utilisateur
     * @return bool Si le compte est actif ou non
     */
    public function compteActif(int $idUser): bool
    {
        $sql = "SELECT compte_valide, id_user FROM utilisateur WHERE id_user = :idUser";

        $req = $this->getBDD()->prepare($sql);
        $req->bindValue('idUser', $idUser, PDO::PARAM_INT);
        $req->execute();

        return $req->fetch(PDO::FETCH_ASSOC)['compte_valide'];
    }

    /**
     * Récupère le nombre d'utilisateur utilisant le pseudo
     * Ce nombre est toujours censé être 0 ou 1
     *
     * @param string $pseudo
     * @return int Le nombre d'user utilisant le $pseudo
     */
    public function nbPseudo(string $pseudo): int
    {
        $sql = 'SELECT COUNT(id_user) as nombre FROM utilisateur WHERE `pseudo` = :pseudo';

        $req = $this->getBDD()->prepare($sql);
        $req->bindValue('pseudo', $pseudo, PDO::PARAM_STR);
        $req->execute();

        return $req->fetch(PDO::FETCH_ASSOC)['nombre'];
    }

    /**
     * Permet de savoir si un utilisateur est admin ou non
     *
     * @param int $idUser L'identifiant de l'utilisateur
     * @param bool Si l'utilisateur est admin ou non
     */
    public function isAdmin(int $idUser): bool
    {
        $sql = 'SELECT is_admin FROM utilisateur WHERE id_user = :idUser';

        $req = $this->getBdd()->prepare($sql);
        $req->bindValue('idUser', $idUser, PDO::PARAM_INT);
        $req->execute();

        return $req->fetch(PDO::FETCH_ASSOC)['is_admin'];
    }

    /**
     * Permet de récupérer l'email de l'utilisateur en fonction de son id_mot_de_passe
     *
     * @param int $idUser L'identifiant de l'utilisateur
     * @return string Son email
     */
    public function getUserEmail(int $idUser): string
    {
        $sql = 'SELECT email FROM utilisateur WHERE id_user = :idUser';

        $req = $this->getBDD()->prepare($sql);
        $req->bindValue('idUser', $idUser, PDO::PARAM_INT);
        $req->execute();

        return $req->fetch(PDO::FETCH_ASSOC)['email'];
    }

    /**
     * Permet d'ajouter un flag à un utilisateur
     *
     * @param int $idUSer L'identifiant de l'utilisateur à Flag
     * @return ?int Le code status
     */
    public function flagUser(int $idUSer): ?int
    {
        $sql = 'UPDATE utilisateur SET warn = 1 WHERE id_user = :idUser';

        $req = $this->getBDD()->prepare($sql);
        $req->bindValue('idUser', $idUSer, PDO::PARAM_INT);
        $req->execute();

        if ($req) {
            return 200;
        } else {
            throw new Exception('Erreur lors de l\'ajout du warn');
        }
    }

    /**
     * Permet de passer un utilisateur administrateur
     *
     * @param int $idUser L'identifiant de l'utilisateur
     * @return ?int Le code status
     */
    public function makeUserAdmin(int $idUser): ?int
    {
        $sql = 'UPDATE utilisateur SET id_admin = 1 WHERE id_user = :idUser';

        $req = $this->getBDD()->prepare($sql);
        $req->bindValue('idUser', $idUser, PDO::PARAM_INT);
        $req->execute();

        if ($req) {
            return 200;
        } else {
            throw new Exception('Erreur lors de l\'ajout de l\'utilisateur comme administrateur');
        }
    }

    /**
     * Permet de mettre à jour les infos de l'utilisateur
     *
     * @param int $idUSer L'identifiant de l'utilisateur
     * @param string $field Le champs à mettre à jour
     * @param string $value La nouvelle valeur
     * @return ?int Le code status
     */
    public function updateUser(string $field, string $value, int $idUser,): ?int
    {
        $column = '';

        switch ($field) {
            case 'nom':
                $column = 'nom';
                break;
            case 'prenom':
                $column = 'prenom';
                break;
            case 'pseudo':
                $column = 'pseudo';
                break;
            case 'email':
                $column = 'email';
                break;
            case 'mail':
                $column = 'email';
                break;
            case 'age':
                $column = 'age';
                break;
            default:
                throw new Exception('La colonne choisit n\'existe pas', 400);
        }

        $sql = 'UPDATE utilisateur SET (' . $column . ') VALUES (:newVal) WHERE id_user = :idUser';

        $req = $this->getBDD()->prepare($sql);
        $req->bindValue('newVal', $value);
        $req->bindValue('idUser', $idUser, PDO::PARAM_INT);
        $req->execute();

        if ($req) {
            return 200;
        } else {
            throw new Exception('Erreur lors de la mise à jour de la colonne ' . $field, 500);
        }
    }

    /**
     * Permet de récupérer les stats de la page admin
     *
     * @param int $idUser L'identifiant de l'utilisateur
     * @return StatsAdmin Les stats admin
     * @throws Exception
     */
    public function getStatsAdmin(int $idUser): StatsAdmin
    {
        $nbComptesSql = "SELECT COUNT(id_user) as nbComptes FROM utilisateur";
        $nbComptesValidesSql = "SELECT COUNT(id_user) as nbComptesValides FROM utilisateur WHERE compte_valide = 1";
        $nbComptesWarn = "SELECT COUNT(id_user) as nbComptesWarn FROM utilisateur WHERE warn = 1";

        $reqTotalComptes = $this->getBDD()->prepare($nbComptesSql);
        $reqTotalComptes->execute();
        $nbComptes = $reqTotalComptes->fetch(PDO::FETCH_ASSOC)['nbComptes'];
        $reqTotalComptes->closeCursor();

        $reqComptesValides = $this->getBDD()->prepare($nbComptesValidesSql);
        $reqComptesValides->execute();
        $nbComptesValides = $reqComptesValides->fetch(PDO::FETCH_ASSOC)['nbComptesValides'];
        $reqComptesValides->closeCursor();

        $reqComptesWarn = $this->getBDD()->prepare($nbComptesWarn);
        $reqComptesWarn->execute();
        $nbComptesWarn = $reqComptesWarn->fetch(PDO::FETCH_ASSOC)['nbComptesWarn'];
        $reqComptesWarn->closeCursor();

        $photosSql = "SELECT COUNT(id_photo) as nbPhotos FROM photo";

        $reqPhotos = $this->getBDD()->prepare($photosSql);
        $reqPhotos->execute();
        $valPhotos = $reqPhotos->fetch(PDO::FETCH_ASSOC);

        return new StatsAdmin(
            $valPhotos['nbPhotos'],
            $nbComptes,
            $nbComptesValides,
            $nbComptesWarn
        );
    }

    /**
     * Permet de récupérer les comptes warns
     *
     * @return Photographe[] Les comptes Warn
     * @throws Exception
     */
    public function getComptesWarn(): array
    {
        $sql = "SELECT nom, prenom, pseudo, email FROM utilisateur WHERE warn = 1";

        $req = $this->getBDD()->prepare($sql);
        $req->execute();

        $data = [];
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new Photographe(
                nom: $row['nom'],
                prenom: $row['prenom'],
                pseudo: $row['pseudo'],
                email: $row['email']
            );
        }

        return $data;
    }
}
