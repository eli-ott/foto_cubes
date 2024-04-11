<?php

require_once("./Model/MainManager.php");

class MainController
{
    private $mainManager;

    public function __construct()
    {
        $this->mainManager = new MainManager;
    }

    public function test() {
        return $this->mainManager->getPreviews();
    }
}
