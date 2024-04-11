<?php
require_once('./Model/Model.php');
class MainManager extends Model
{
    public function getPreviews(): array
    {
        $sql = "SELECT * FROM photo ORDER BY date_publication DESC LIMIT 5";

        $request = $this->getBDD()->prepare($sql);
        $request->execute();
        $data = $request->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }
}
