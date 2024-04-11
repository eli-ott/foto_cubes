<?php

require_once('./Model/Model.php');

class PhotoManager extends Model
{
    /**
     * Récupère les photos en fonction de la page. Retourne 10 photos au maximum
     * 
     * @param int $page La page actuelle pour calculer les photos à récupérer
     * @return Photo Le tableau d'images
     */
    public function getPhotos(int $page): array
    {
        $offset = ($page * 10) + $page;
        $limit = 10 + $page;

        $sql = "SELECT photo.id_user, photo.id_photo, photo.titre, photo.source, photo.date_prise_vue, photo.date_publication, photographe.nom, photographe.prenom, photographe.pseudo, photographe.email FROM photo 
        LEFT JOIN user as photographe ON photo.id_user = photographe.id_user 
        LIMIT :limit_photo OFFSET :from_offset;";

        $req = $this->getBDD()->prepare($sql, [
            "limit_photo" => $limit,
            "from_offset" => $offset
        ]);
        $req->execute();

        $photos = [];
        while ($row = $req->fetch((PDO::FETCH_ASSOC))) {
            $photos[] = new Photo(
                $row->id_photo,
                $row->titre,
                $row->source,
                $row->date_prise_vue,
                $row->date_publication,
                new Photographe(
                    $row->idUser,
                    $row->nom,
                    $row->prenom,
                    $row->pseudo,
                    $row->email
                )
            );
        }

        return $photos;
    }

    /**
     * Récupère les photos de l'utilisateur en fonction de la page
     * 
     * @param int $page La page actuel du paginateur
     * @param int $idUser L'id du user
     * @return array Les photos du user
     */
    public function getPhotosByUser(int $page, int $idUser): array
    {
        $offset = ($page * 10) + $page;
        $limit = 10 + $page;

        $sql = "SELECT photo.id_user, photo.id_photo, photo.titre, photo.source, photo.date_prise_vue, photo.date_publication, photographe.nom, photographe.prenom, photographe.pseudo, photographe.email FROM photo 
        LEFT JOIN user as photographe ON photo.id_user = photographe.id_user
        WHERE photo.id_user = :idUser 
        LIMIT :limitPhoto OFFSET :fromOffset;";

        $req = $this->getBDD()->prepare($sql, [
            "limitPhoto" => $limit,
            "fromOffset" => $offset,
            "idUser" => $idUser
        ]);
        $req->execute();

        $photos = [];
        while ($row = $req->fetch((PDO::FETCH_ASSOC))) {
            $photos[] = new Photo(
                $row->id_photo,
                $row->titre,
                $row->source,
                $row->date_prise_vue,
                $row->date_publication,
                new Photographe(
                    $row->idUser,
                    $row->nom,
                    $row->prenom,
                    $row->pseudo,
                    $row->email
                )
            );
        }

        return $photos;
    }

    /**
     * Permet d'ajouter une photo
     * 
     * @param Photo $photo La photo à ajouter
     * @return int $status Le code statut
     */
    public function addPhoto(Photo $photo): int
    {
        if (empty($_SESSION['id_user'])) {
            throw new Exception('Aucun utilisateur connecté', 400);
        }

        $sql = "INSERT INTO photo (id_user, titre, date_prise_vue, source) VALUES (:idUser, :titre, :datePriseVue, :source)";

        $req = $this->getBDD()->prepare($sql, [
            "idUser" => $photo->getPhotographe()->getId(),
            "titre" => $photo->getTitre(),
            "datePriseVue" => $photo->getDatePriseVue(),
            "source" => $photo->getSource()
        ]);
        $req->execute();

        // A FAIRE LA FIN DE LA REQUETE
        // VERIFIER QUE LA REQUETE A FONCTIONNER POUR RENVOYER LE STATUS

        return 0;
    }
}
