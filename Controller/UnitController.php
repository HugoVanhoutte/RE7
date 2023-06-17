<?php

namespace App\Controller;

use App\Model\Manager\UnitManager;

class UnitController extends AbstractController implements ControllerInterface
{

    /**
     * @inheritDoc
     */
    public function index(array $params = []): void
    {
        switch ($params['action']) {
            case 'getAll':
            {
                $this->getAll();
                break;
            }

            case 'new':
            {
                $this->new();
                break;
            }

            case 'validateNew' :
            {
                $this->validateNew($_POST);
                break;
            }

            default :
            {
                $this->displayError(404);
                break;
            }
        }
    }

    /**
     * generates a JSON containing all units from DB
     * @return void
     */
    private function getAll(): void
    {
        $this->getJson("getAllUnits");
    }

    /**
     * redirects to unit creation page if user is authorised
     * @return void
     */
    private function new(): void
    {
        if (isset($_SESSION['user_id'])) {
            $this->display("unit/new", "Nouvelle Unité");
        } else {
            $this->display("user/login", "Connexion", [
                "error" => "Afin d'ajouter une nouvelle unité, vous devez être connecté"
            ]);
        }

    }

    /**
     * validate and insert newly created unit
     * @param $data
     * @return void
     */
    private function validateNew($data): void
    {
        (new UnitManager())->insert($data['name']);
        $this->display("home/index", 'Homepage', [
            "message" => "Votre unité a été ajoutée avec succès, vous pouvez maintenant créer une recette qui utilise cette dernière !"
        ]);
    }
}