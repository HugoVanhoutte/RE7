<?php

namespace App\Tests\Model\Manager;
require __DIR__ . "/../../../vendor/autoload.php";
require __DIR__ . "/../../../Model/Manager/RoleManager.php";
require __DIR__ . "/../../../Model/DB.php";


use App\Model\Entity\User;
use App\Model\Manager\RoleManager;
use PHPUnit\Framework\TestCase;

class RoleManagerTests extends TestCase
{
    private RoleManager $roleManager;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->roleManager = new RoleManager();
    }

    /**
     * Testing User::getId()
     * @return void
     */
    public function testGetRole(): void
    {
        $result = $this->roleManager->getRole(6);
        $this->assertEquals("Non-Validé", $result);
        $this->assertIsString($result);
    }
}