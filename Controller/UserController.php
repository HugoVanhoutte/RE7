<?php

namespace App\Controller;

class UserController extends AbstractController implements ControllerInterface
{
    public function index(array $params = []): void
    {
        switch ($params['action']) {
            case 'profile' : {
                //Displays user profile
                if (!isset($params['id'])) {
                    //If no id is set: sends the user to an error 404 page
                    $this->displayError(404);
                    die();
                }

                $this->display('user/profile', "profil de "); //TODO GET USERNAME

            }
            default : {
                //Default action if no action is set in query string: send user to homepage
                (new RootController())->index();
            }
        }
    }
}