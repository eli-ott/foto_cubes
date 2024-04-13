<?php
session_start();
define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://" . $_SERVER['HTTP_HOST'] . $_SERVER["PHP_SELF"]));

require_once("./controller/MainController.controller.php");
$mainController = new MainController();

try {
    if (empty($_GET['page'])) {
        $page = "accueil";
    } else {
        $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);
        $page = $url[0];
    }
    switch ($page) {
        case 'accueil':
            // echo 'this is test';
            break;
        case 'galerie':
            // echo 'this is test';
            break;
        case 'profil':
            // echo 'this is test';
            break;
        case 'inscription':
            // echo 'this is test';
            break;
        default:
            throw new Exception('404: Aucune page trouvé');
    }
} catch (Exception $e) {
    $page_description = "Il y a eu une erreur";
    $page_title = "Oops il y a eu une erreur";
    $page_content = $e->getMessage();
}
require_once("View/base.php");