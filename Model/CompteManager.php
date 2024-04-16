<?php

require_once("./Model/Model.php");

class CompteManager extends Model
{
    /**
     * Permet de créer un nouveau compte
     * 
     * @var Photographe $photographe
     * @var int L'id du mot de passe 
     * @return Photographe Le dernier compte ajouté
     */
    public function addUser(Photographe $photographe, int $idMdp): array
    {
        if (!empty($_COOKIE['token'])) {
            throw new Exception('Un utilisateur est déjà connecté', 400);
        }

        $addUserSql = "INSERT INTO user (id_mot_de_passe, pseudo, nom, prenom, email, age, type_photo_pref) 
            VALUES (:idMdp, :pseudo, :nom, :prenom, :email, :age, :typePhotoPref)";

        $addUserReq = $this->getBDD()->prepare($addUserSql, [
            "idMdp" => $idMdp,
            "pseudo" => $photographe->getPseudo(),
            "nom" => $photographe->getNom(),
            "prenom" => $photographe->getPrenom(),
            "email" => $photographe->getEmail(),
            "age" => $photographe->getAge(),
            "typePhotoPref" => $photographe->getTypePhotoPref()
        ]);
        $addUserReq->execute();
        $addUserReq->closeCursor();

        if ($addUserReq) {
            $lastInsertedRowSql = "SELECT * FROM user ORDER BY id_user DESC LIMIT 1";

            $lastInsertedRowReq = $this->getBDD()->prepare($lastInsertedRowSql);
            $lastInsertedRowReq->execute();

            if ($lastInsertedRowReq) {
                $data = [];
                while ($row = $lastInsertedRowReq->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = new Photographe(
                        intval($row->id_user),
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
            throw new Exception('Erreur lors de la sauvegarde de l\'utilisateur', 500);
        }

        return $data;
    }

    /**
     * Mets à jour un compte d'un photographe
     * 
     * @param Photographe $photographe Le compte à mettre à jour
     * @return int Le code statut 
     */
    public function updateUser(Photographe $photographe): int
    {
        if (empty($_COOKIE['token'])) {
            throw new Exception('Aucun utilisateur connecté', 400);
        }

        $sql = "UPDATE user SET psuedo = :pseudo, nom = :nom, prenom = :prenom, age = :age, email = :email WHERE id_user = :idUser";

        $req = $this->getBDD()->prepare($sql, [
            "idUser" => $photographe->getId(),
            "pseudo" => $photographe->getPseudo(),
            "nom" => $photographe->getPrenom(),
            "prenom" => $photographe->getPrenom(),
            "age" => $photographe->getAge(),
            "email" => $photographe->getEmail()
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
     * @param Photographe $photographe Le photographe à supprimer
     * @return int Le code statut 
     */
    public function deleteUser(Photographe $photographe): int
    {
        if (empty($_COOKIE['token'])) {
            throw new Exception('Aucun utilisateur connecté', 400);
        }

        $sql = "DELETE FROM user WHERE id_user = :idUser";

        $req = $this->getBDD()->prepare($sql, [
            "idUser" => $photographe->getId()
        ]);
        $req->execute();

        if ($req) {
            $status = 200;
        } else {
            throw new Exception('Erreur lors de la suppression du compte id ' . $photographe->getID(), 500);
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
        $sql = "SELECT id_user, nom, prenom, email, pseudo, date_creation, type_photo_pref, age FROM user WHERE id_user = :idUser";

        $req = $this->getBDD()->prepare($sql, [
            "idUser" => $idUser
        ]);
        $req->execute();

        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $data = new Photographe(
                $row->id,
                $row->nom,
                $row->prenom,
                $row->pseudo,
                $row->email,
                $row->age,
                $row->type_photo_pref,
            );
        }

        return $data;
    }
}
