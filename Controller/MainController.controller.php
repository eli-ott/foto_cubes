<?php

require_once("./Model/Render.php");
require_once("./Model/MainManager.php");
require_once("./Model/PhotoManager.php");

class MainController extends Render
{
    private $mainManager;
    private $photoManager;

    public function __construct()
    {
        parent::__construct(Render::class);
        $this->mainManager = new MainManager;
        $this->photoManager = new PhotoManager;
    }

    public function test()
    {
        return $this->photoManager->getPhotos(0);
    }
}
