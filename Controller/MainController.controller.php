<?php

require_once("./Model/MainManager.php");

class MainController extends Render
{
    private $mainManager;

    public function __construct()
    {
        parent::__construct(Render::class);
        $this->mainManager = new MainManager;
    }

    public function test()
    {
        return $this->mainManager->getPreviews();
    }
}
