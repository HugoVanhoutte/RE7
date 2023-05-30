<?php

namespace App\Model\Entity;

class Recipe extends AbstractPost
{
private array $ingredients;
private int $preparation_time_minutes;
private int $cooking_time_minutes;
}