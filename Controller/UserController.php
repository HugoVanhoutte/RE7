<?php

namespace App\Controller;

use App\Manager\UserManager;
use User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once "../Model/Manager/UserManager.php";
require_once "../vendor/autoload.php";
require '../vendor/autoload.php';

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

            case 'register' : {
                $this->display('user/register', 'Créer un compte');
            }

            case 'validateRegister' : {
                $this->validateRegister();
            }

            case 'emailValidated' :
            {
                //TODO DEBUG
                if (isset($params['token'])) {
                    $this->validationMailConfirm($params['token']);
                } else {
                    echo "<br>Pas de token";
                }
            }

            case 'login' : {
                $this->display('user/login', 'Connexion');
            }

                case 'validateLogin' : {
                    $this->validateLogin($_POST['email'], $_POST['password']);
                }

            default : {
                //Default action if no action is set in query string: send user to homepage
                (new RootController())->index();
            }
        }
    }

    private function validateRegister() {
        $userManager = new UserManager();
        if (!$userManager->validateEmail($_POST['email'])) {
            echo "Erreur Email";
        } elseif (!$userManager->validateUsername($_POST['username'])) {
            echo "Erreur Username";
        } elseif (!$userManager->validatePassword($_POST['password'])) {
            echo "Erreur Password";
        } elseif ($_POST['password'] !== $_POST['passwordConfirm']) {
            echo "Les Passwords ne matchent pas Kevin!";
        } elseif ($userManager->checkEmailAlreadyInDB($_POST['email'])) {
            echo "Ce mail est déjà utilisé";
        } elseif($userManager->checkUsernameAlreadyInDB($_POST['username'])) {
            echo "Ce nom d'utilisateur est déjà utilisé";
        } else {
            $token = uniqid("", true);
            $user = [
                "username" => trim($_POST['username']),
                "email" => trim(strtolower($_POST['email'])),
                "password" => password_hash($_POST['password'], PASSWORD_BCRYPT),
                "token" => $token
            ];

            var_dump($user);

            $userManager->insertUnconfirmedUser($user);
            //TODO SENDMAIL


// SMTP Connection setup
            $smtpHost = 'smtp.gmail.com';
            $smtpPort = 587;
            $smtpUsername = 'noreply.re7project@gmail.com';
            $smtpPassword = 'tfvmhadennoylyhh';

// From/To
            $from = 'noreply.re7project@gmail.com';
            $to = $user['email'];

// PHPMailer object creation and configuration
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = $smtpHost;
            $mail->Port = $smtpPort;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Username = $smtpUsername;
            $mail->Password = $smtpPassword;

// Mails parameters
            $mail->setFrom($from);
            $mail->addAddress($to);
            $mail->Subject = '[RE7] Confirmation de votre compte';
            $mail->isHTML(true);
            $mail->Body = "
                <h1>Bienvenue sur RE7</h1>
                <p>Cliquez sur ce lien pour confirmer votre adresse mail</p>
                <a href='localhost/RE7/public/index.php/user?action=emailValidated&token=$token'>Confirmer mon adresse Mail</a>    
            ";

// send Email
            if ($mail->send()) {
                echo 'E-mail envoyé avec succès !';
            } else {
                echo 'Erreur lors de l\'envoi de l\'e-mail : ' . $mail->ErrorInfo;
            }

        }
    }

    private function validationMailConfirm($token): void
    {
        //When User clicked on mail link, puts user to users table.
        $userManager = new UserManager();
        $user = $userManager->getUnconfirmedUserByToken($token);
        $userManager->insert($user);
        $userManager->deleteUnconfirmedUser($user['id']);
        $this->display('user/login', 'Connexion', [
            "message" => "Votre adresse mail a bien été confirmée, vous pouvez vous connecter"
        ]);
    }

    private function validateLogin($email, $password): void
    {
        $userManager = new UserManager();
        $userId = $userManager->getIdFromEmail($email);
        $user = $userManager->get($userId);
        if ($user !== null && password_verify($password, $user->getPassword())) {
            session_start();
            $_SESSION['user_id'] = $userId;
            echo "Vous êtes connecté";
        } else {
            //TODO Manage Error
            echo "Erreur";
        }
    }
}