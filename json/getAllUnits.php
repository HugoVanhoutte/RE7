<?php

use App\Model\Entity\Unit;
use App\Model\Manager\UnitManager;

//Generates a JSON file containing All Units in DB
$data = (new UnitManager())->getAll();

$array = [];

foreach ($data as $unitObject) /* @var Unit $ingredientObject */ {
    $array[] = [
        'id' => $unitObject->getId(),
        'name' => $unitObject->getName()
    ];
}

header('Content-Type: application/json');
echo json_encode($array);