<?php

require_once("Services/Model.php");

class CompteManager extends Model
{
    /**
     * Permet de créer un nouveau compte
     * 
     * @var Photographe $photographe
     * @var int L'id du mot de passe 
     * @return Photographe Le dernier compte ajouté
     */
    public function addUser(Photographe $photographe): array
    {
        if (!empty($_COOKIE['token'])) {
            throw new Exception('Un utilisateur est déjà connecté', 400);
        }

        $addUserSql = "INSERT INTO user (id_mot_de_passe, pseudo, nom, prenom, email, age, type_photo_pref) 
            VALUES (:idMdp, :pseudo, :nom, :prenom, :email, :age, :typePhotoPref)";

        $addUserReq = $this->getBDD()->prepare($addUserSql, [
            "idMdp" => $photographe->getIdMdp(),
            "pseudo" => $photographe->getPseudo(),
            "nom" => $photographe->getNom(),
            "prenom" => $photographe->getPrenom(),
            "email" => $photographe->getEmail(),
            "age" => $photographe->getAge(),
            "typePhotoPref" => $photographe->getTypePhotoPref()
        ]);
        $addUserReq->execute();

        if ($addUserReq) {
            $lastInsertedRowSql = "SELECT * FROM user ORDER BY id_user DESC LIMIT 1";

            $lastInsertedRowReq = $this->getBDD()->prepare($lastInsertedRowSql);
            $lastInsertedRowReq->execute();
            if ($lastInsertedRowReq) {
                $data = [];
                while ($row = $lastInsertedRowReq->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = new Photographe(
                        intval($row->id_user),
                        intval($row->id_mot_de_passe),
                        $row->nom,
                        $row->prenom,
                        $row->pseudo,
                        $row->email,
                        intval($row->age),
                        $row->type_photo_pref,
                        $row->date_creation,
                        boolval($row->warn),
                    );
                }
            } else {
                throw new Exception('Erreur lors de la récupération du dernier compte ajouté', 500);
            }
        } else {
            throw new Exception('Erreur lors de la création du compte', 500);
        }

        return $data;
    }

    /**
     * Mets à jour un compte d'un photographe
     * 
     * @param string $field Le nom de la colonne à mettre à jour
     * @param string $newValue La valeur à mettre à jour
     * @return int Le code statut 
     */
    public function updateUser(string $field, string $newValue): int
    {
        if (empty($_COOKIE['token'])) {
            throw new Exception('Aucun utilisateur connecté', 400);
        }

        $sql = "UPDATE user SET :field = :newValue WHERE id_user = :idUser";

        $req = $this->getBDD()->prepare($sql, [
            "idUser" => $_COOKIE['id'],
            "field" => $field,
            "newValue"=> $newValue,
        ]);
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
        if (empty($_COOKIE['token'])) {
            throw new Exception('Aucun utilisateur connecté', 400);
        }

        $sql = "DELETE FROM user WHERE id_user = :idUser";

        $req = $this->getBDD()->prepare($sql, [
            "idUser" => $idUser
        ]);
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
            FROM user WHERE id_user = :idUser";

        $req = $this->getBDD()->prepare($sql, [
            "idUser" => $idUser
        ]);
        $req->execute();

        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $data = new Photographe(
                intval($row->id),
                intval($row->id_mot_de_passe),
                $row->nom,
                $row->prenom,
                $row->pseudo,
                $row->email,
                intval($row->age),
                $row->type_photo_pref,
                $row->date_creation,
                boolval($row->warn),
                boolval($row->compte_valide),
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

        $req = $this->getBDD()->prepare($sql, [
            "pseudo" => $pseudo
        ]);
        $req->execute();

        return $req->fetch(PDO::FETCH_ASSOC)->id_user;
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

        $req = $this->getBDD()->prepare($sql, [
            "idUser" => $idUser
        ]);
        $req->execute();

        return $req->fetch(PDO::FETCH_ASSOC)->compte_valide;
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
        $sql = 'SELECT COUNT(*) as nombre FROM utilisateur WHERE pseudo = :pseudo';

        $req = $this->getBDD()->prepare($sql, [
            'pseudo' => $pseudo
        ]);
        $req->execute();

        return $req->fetch(PDO::FETCH_ASSOC)->nombre;
    }
}
