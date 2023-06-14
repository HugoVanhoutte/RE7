<?php

use App\Model\Entity\Recipe;
use App\Model\Manager\RecipeManager;
//Generates a JSON file containing All Recipes in DB

$data = (new RecipeManager())->getAll();

$array = [];

foreach ($data as $recipeObject) /* @var Recipe $recipeObject */ {
    $array[] = [
        'id' => $recipeObject->getId(),
        'title' => $recipeObject->getTitle()
    ];
}

header('Content-Type: application/json');
echo json_encode($array);