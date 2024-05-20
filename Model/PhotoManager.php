<?php

require_once('Services/Model.php');

class PhotoManager extends Model
{

    /**
     * Permet de récupérer les previews pour la page d'accueil
     * 
     * @return array Les 5 dernières photos ajoutées
     */
    public function getPreviews(): array
    {
        $sql = "SELECT * FROM photo ORDER BY date_publication DESC LIMIT 5";

        $request = $this->getBDD()->prepare($sql);
        $request->execute();
        $data = $request->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * Récupère les photos en fonction de la page. Retourne 10 photos au maximum
     *
     * @param int $page La page actuelle pour calculer les photos à récupérer
     * @return array Le tableau d'images
     */
    public function getPhotos(int $page): array
    {
        $offset = (($page - 1) * 10);
        $limit = 10;

        $sql = "SELECT photo.id_user, photo.id_photo, photo.titre, photo.tag, photo.source, photo.date_prise_vue, photo.date_publication, photographe.nom, photographe.prenom, photographe.pseudo, photographe.email 
        FROM photo 
        LEFT JOIN utilisateur as photographe ON photo.id_user = photographe.id_user 
        LIMIT :limit_photo OFFSET :from_offset;";

        $req = $this->getBDD()->prepare($sql);
        $req->bindValue('limit_photo', $limit, PDO::PARAM_INT);
        $req->bindValue('from_offset', $offset, PDO::PARAM_INT);
        $req->execute();

        $photos = [];
        while ($row = $req->fetch((PDO::FETCH_ASSOC))) {
            list($width, $height) = getimagesize($row["source"]);

            $photos[] = new Photo(
                intval($row['id_photo']),
                $row['titre'],
                $row['tag'],
                $row['source'],
                $row['date_prise_vue'],
                $row['date_publication'],
                new Photographe(
                    intval($row['id_user']),
                    null,
                    $row['nom'],
                    $row['prenom'],
                    $row['pseudo'],
                    $row['email']
                ),
                $width / $height > 1 ? 'horizontal' : 'vertical'
            );
        }

        $req->closeCursor();

        $getPages = "SELECT COUNT(id_user) as pages FROM photo";

        $reqPages = $this->getBDD()->prepare($getPages);
        $reqPages->execute();

        if (!$req) {
            throw new Exception('Erreur lors de la récupération des photos', 500);
        }

        return [
            'pages' => ceil((int)$reqPages->fetch(PDO::FETCH_ASSOC)['pages'] / Constants::IMAGES_PAR_PAGE),
            'photos' => $photos
        ];
    }

    /**
     * Récupère les photos de l'utilisateur en fonction de la page
     * 
     * @param int $page La page actuel du paginator
     * @param int $idUser L'id du user
     * @return array Les photos du user
     */
    public function getPhotosByUser(int $page, int $idUser): array
    {
        $offset = (($page - 1) * 10);
        $limit = 10;

        $sql = "SELECT photo.id_user, photo.id_photo, photo.titre, photo.tag, photo.source, photo.date_prise_vue, photo.date_publication, photographe.nom, photographe.prenom, photographe.pseudo, photographe.email 
        FROM photo 
        LEFT JOIN utilisateur as photographe ON photo.id_user = photographe.id_user
        WHERE photo.id_user = :idUser 
        LIMIT :limitPhoto OFFSET :fromOffset;";

        $req = $this->getBDD()->prepare($sql);
        $req->bindValue('idUser', $idUser, PDO::PARAM_INT);
        $req->bindValue('limitPhoto', $limit, PDO::PARAM_INT);
        $req->bindValue('fromOffset', $offset, PDO::PARAM_INT);
        $req->execute();

        $photos = [];
        while ($row = $req->fetch((PDO::FETCH_ASSOC))) {
            list($width, $height) = getimagesize($row["source"]);

            $photos[] = new Photo(
                intval($row['id_photo']),
                $row['titre'],
                $row['tag'],
                $row['source'],
                $row['date_prise_vue'],
                $row['date_publication'],
                new Photographe(
                    intval($row['id_user']),
                    null,
                    $row['nom'],
                    $row['prenom'],
                    $row['pseudo'],
                    $row['email']
                ),
                $width / $height > 1 ? 'horizontal' : 'vertical'
            );
        }

        $req->closeCursor();

        $getPages = "SELECT COUNT(id_user) as pages FROM photo WHERE id_user = :idUser";

        $reqPages = $this->getBDD()->prepare($getPages);
        $reqPages->bindValue("idUser", $idUser, PDO::PARAM_INT);
        $reqPages->execute();

        if (!$req) {
            throw new Exception("Erreur lors de la récupération des photos de l'utilisateur id " . $idUser, 500);
        }

        return [
            'pages' => ceil($reqPages->fetch(PDO::FETCH_ASSOC)['pages'] / Constants::IMAGES_PAR_PAGE),
            'photos' => $photos
        ];
    }

    /**
     * Permet d'ajouter une photo
     * 
     * @param Photo $photo La photo à ajouter
     * @return int Le code statut de la requête
     */
    public function addPhoto(Photo $photo): int
    {
        $sql = "INSERT INTO photo (id_user, titre, date_prise_vue, source, tag) VALUES (:idUser, :titre, :datePriseVue, :source, :tag)";

        $req = $this->getBDD()->prepare($sql);

        $req->bindValue("idUser", $photo->getPhotographe()->getId(), PDO::PARAM_INT);
        $req->bindValue("titre", $photo->getTitre(), PDO::PARAM_STR);
        $req->bindValue("datePriseVue", $photo->getDatePriseVue(), PDO::PARAM_STR);
        $req->bindValue("source", $photo->getSource(), PDO::PARAM_STR);
        $req->bindValue("tag", $photo->getTag(), PDO::PARAM_STR);

        $req->execute();

        if ($req) {
            $status = 200;
        } else {
            throw new Exception('Erreur lors de la sauvegarde de la photo', 500);
        }

        return $status;
    }

    /**
     * Permet de supprimer une photo
     * 
     * @var Photo $photo La photo à supprimer
     * @return int Le code statut de la requête
     */
    public function deletePhoto(Photo $photo): int
    {
        Utils::deleteFile($photo->getSource());

        $sql = "DELETE FROM photo WHERE id_photo = :idPhoto";

        $req = $this->getBDD()->prepare($sql);
        $req->bindValue("idUser", $photo->getPhotographe()->getId());
        $req->execute();

        if ($req) {
            $status = 200;
        } else {
            throw new Exception('Erreur lors de la suppression de la photo id ' . $photo->getId(), 500);
        }

        return $status;
    }

    /**
     * Permet de mettre à jour le titre et le tag d'une photo 
     * 
     * @var Photo $photo La photo avec les informations à mettre à jour
     * @return int Le code statut de la requête
     */
    public function updatePhoto(Photo $photo): int
    {

        $sql = "UPDATE photo SET titre = :titre, tag = :tag WHERE id_photo = :idPhoto";

        $req = $this->getBDD()->prepare($sql, [
            "titre" => $photo->getTitre(),
            "tag" => $photo->getTag(),
            "idPhoto" => $photo->getId()
        ]);
        $req->execute();

        if ($req) {
            $status = 200;
        } else {
            throw new Exception('Erreur lors de l\'a mise à jour de la photo id ' . $photo->getId(), 500);
        }

        return $status;
    }
}
