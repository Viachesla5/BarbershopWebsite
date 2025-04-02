<?php

require_once(__DIR__ . "/../models/HairdresserModel.php");

class HomeController
{
    private $hairdresserModel;

    public function __construct()
    {
        $this->hairdresserModel = new HairdresserModel();
    }

    public function index()
    {
        $hairdressers = $this->hairdresserModel->getAll();
        require(__DIR__ . "/../views/pages/index.php");
    }
} 