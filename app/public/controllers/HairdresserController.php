<?php

require_once(__DIR__ . "/../models/HairdresserModel.php");

class HairdresserController
{
    private $hairdresserModel;

    public function __construct()
    {
        $this->hairdresserModel = new HairdresserModel();
    }

    public function listAll()
    {
        $hairdressers = $this->hairdresserModel->getAll();
        require(__DIR__ . "/../views/hairdressers/list.php");
    }

    public function show($id)
    {
        $hairdresser = $this->hairdresserModel->getById($id);
        require(__DIR__ . "/../views/hairdressers/show.php");
    }
}
