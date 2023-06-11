<?php

use App\Model\Entity\Unit;
use App\Model\Manager\UnitManager;

$data = (new UnitManager())->getAll();

$array = [];

foreach ($data as $unitObject)
    /* @var Unit $ingredientObject */ {
    $array[] = [
        'id' => $unitObject->getId(),
        'name' => $unitObject->getName()
    ];
}

header('Content-Type: application/json');
echo json_encode($array);