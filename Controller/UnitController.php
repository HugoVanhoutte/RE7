<?php

namespace App\Controller;

class UnitController extends AbstractController implements ControllerInterface
{

    /**
     * @inheritDoc
     */
    public function index(array $params = []): void
    {
        switch ($params['action'])
        {
            case 'getAll':
            {
                $this->getAll();
                break;
            }

            default :
            {
                $this->displayError(404);
                break;
            }
        }
    }

    private function getAll(): void
    {
        $this->getJson("getAllUnits");
    }
}