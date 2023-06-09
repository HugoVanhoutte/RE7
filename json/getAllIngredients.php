<?php

use App\Model\Entity\Ingredient;
use App\Model\Manager\IngredientManager;

//Generates a JSON file containing All ingredients in DB

$data = (new IngredientManager())->getAll();

$array = [];

foreach ($data as $ingredientObject) /* @var Ingredient $ingredientObject */ {
    $array[] = [
        'id' => $ingredientObject->getId(),
        'name' => $ingredientObject->getName()
    ];
}

header('Content-Type: application/json');
echo json_encode($array);