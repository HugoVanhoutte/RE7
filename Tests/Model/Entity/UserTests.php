<?php

namespace App\Tests\Model\entity;
require __DIR__ . "/../../../vendor/autoload.php";
require __DIR__ . "/../../../Model/Entity/User.php";
require __DIR__ . "/../../../Model/Manager/UserManager.php";
require __DIR__ . "/../../../Model/DB.php";

use App\Model\Entity\User;
use App\Model\Manager\UserManager;
use PHPUnit\Framework\TestCase;

class UserTests extends TestCase
{
    private User $user;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->user = (new UserManager())
            ->get(7);
    }

    /**
     * Testing User::getId()
     * @return void
     */
    public function testGetRoleId(): void
    {
        $result = $this->user->getRoleId();
        $this->assertEquals(4, $result);
        $this->assertIsInt($result);
    }

    public function testGetEmail(): void
    {
        $result = $this->user->getEmail();
        $this->assertEquals("hugo.vanhoutte.pro@gmail.com", $result);
        $this->assertIsString($result);
    }
}