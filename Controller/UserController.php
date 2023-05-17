<?php

namespace App\Controller;

use App\Manager\UserManager;
use App\Model\Entity\User;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


class UserController extends AbstractController implements ControllerInterface
{
    public function index(array $params = []): void
    {
        if (!isset($params['action'])) {
            $this->displayError(404);
            exit();
        }

        switch($params['action'])
        {
            case 'register' :  //Registration page
            {
                $this->register();
            }

            case 'validateRegistration' : //Checks registration infos and send mail
            {
                $this->validateRegistration($_POST);
            }

            case 'emailValidation' :
            {
                $this->emailValidation($params);
            }

            case 'login' :
            {
                $this->login();
            }

            case 'validateLogin' :
            {
                $this->validateLogin($_POST);
            }

            case 'logout' :
                $this->logout();
        }
    }

    /**
     * @return void
     */
    private function register(): void
    {
        $this->display('user/register', 'S\'enregistrer');
    }

    /**
     * @param array $registrationInfo
     * @return void
     * @throws Exception
     */
    private function validateRegistration(array $registrationInfo): void
    {
        if (empty($_POST)) {                                                                                            //Ensures that no error message is displayed on register page before sending info
         die();
        }

        $userManager = new UserManager();

        if($userManager->checkUsernameAlreadyInDB($registrationInfo['username']))                                       //If true: a username is already in DB
        {
            //Display Message on registration page that username already taken
            $this->display('user/register', 'S\'enregistrer', [
                'error' => 'Ce nom d\'utilisateur est déjà utilisé'
            ]);
        }

        elseif($userManager->checkEmailAlreadyInDB($registrationInfo['email']))
        {
            //Display Message on registration page that email already taken
            $this->display('user/register', 'S\'enregistrer', [                                           //If true: an email is already used in DB
                'error' => 'Cette adresse mail est déjà utilisé'
            ]);
        }

        elseif (!($registrationInfo['password'] === $registrationInfo['passwordConfirm']))                              //If true: password and password confirmation doesn't match
            //Display Error Message (Generic)
            //TODO MAke generic: can be checked on front end
            $this->display('user/registration', 'S\'enregistrer', [
                'error' => 'Les mots de passe ne correspondent pas'
            ]);

        elseif (!$userManager->validateEmail($registrationInfo['email']))                                               //If true: email is not valid
        {
            //Display Error Message (Generic)
            //TODO Make generic: can be checked in front
            $this->display('user/register', 'S\'enregistrer', [
                'error' => 'L\'adresse email n\'est pas correcte'
            ]);
        }

        elseif(!$userManager->validateUsername($registrationInfo['username']))                                          //If true: username is not valid
        {
            //Display Error Message (Generic)
            //TODO Make Generic: can be checked in front
            $this->display('user/register', 'S\'enregister', [
                'error' => 'Le nom d\'utilisateur n\'est pas valide'
            ]);
        }

        elseif (!$userManager->validatePassword($registrationInfo['password']))                                         //If true: password is not valid
        {
            //Display Error Message (Generic)
            //TODO Make Generic: can be checked in front
            $this->display('user/register', 'S\'enregistrer', [
                'error' => 'Le mot de passe n\'est pas valide'
            ]);
        }

        else                                                                                                            //All good: create a new User and send confirmation email
        {
            $username = trim($registrationInfo['username']);
            $email = trim(strtolower($registrationInfo['email']));
            $password = password_hash($registrationInfo['password'], PASSWORD_BCRYPT);
            $token = uniqid("", true);

            $newUser = (new User())
                ->setUsername($username)
                ->setEmail($email)
                ->setPassword($password)
                ->setToken($token)
                ;

            $userManager->insert($newUser);
            $newUser = $userManager->get($userManager->getIdFromEmail($newUser->getEmail()));

            $id = $newUser->getId();

            //Mail Sending
            // SMTP Connection setup
            $smtpHost = 'smtp.gmail.com';
            $smtpPort = 587;
            $smtpUsername = 'noreply.re7project@gmail.com';
            $smtpPassword = 'tfvmhadennoylyhh';

// From/To
            $from = 'noreply.re7project@gmail.com';
            $to = $newUser->getEmail();

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
                <a href='localhost/RE7/public/index.php/user?action=emailValidation&id=$id&token=$token'>Confirmer mon adresse Mail</a>    
            ";

// send Email
            //TODO REMOVE DEBUG INFO
            if ($mail->send()) {
                $this->display('home/generic_display', 'Compte Créé', [
                    'message' => 'Votre compte a été créé, pour l\'activer, veuillez cliquer sur le lien d\'activation envoyé a votre boite e-mail. Vous pouvez fermer cet onglet'
                ]);
            } else {
                echo 'Erreur lors de l\'envoi de l\'e-mail : ' . $mail->ErrorInfo;
            }
            exit(); //Avoid Getting error messages

        }
    }

    /**
     * @param array $params
     * @return void
     */
    private function emailValidation(array $params): void
    {
        $userManager = new UserManager();
        $user = $userManager->get($params['id']);
        if($user->getToken() === $params['token'])
        {
            $updateData = [
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'role_id' => 4,
                'token' => null
            ];
            //TODO UPDATE USER ROLE_ID TO 4
            $userManager->update($user->getId(), $updateData);

            $this->display('user/login', 'Connexion', [
                'message' => 'Adresse E-mail vérifié, vous pouvez vous connecter'
            ]);
        } else {
            //TODO ERROR
            $this->display('home/generic_display', "ERREUR", [
                'message' => "Erreur"
            ]);
        }
    }

    /**
     * @return void
     */
    private function login(): void
    {
        $this->display('user/login', 'Connexion');
    }

    /**
     * @param array $loginInfo
     * @return void
     */
    private function validateLogin(array $loginInfo): void
    {
        if(empty($_POST)) {
            exit(); //Prevent useless error messages
        }
        $userManager = new UserManager();
        if ($userManager->checkEmailAlreadyInDB($_POST['email'])) { //Email exists, get user, check PW
            $user = $userManager->get($userManager->getIdFromEmail($_POST['email']));
            if (password_verify($_POST['password'], $user->getPassword())) { //Password correct, start session
                session_start();
                $_SESSION['user_id'] = $user->getId();
                $this->display('home/index', 'Accueil');
            } else { //Wrong Password
                $this->display('user/login', 'Connexion', [
                    'message' => 'Mot de passe incorrect'
                ]);
            }
        } else {
            $this->display('user/login', 'Connexion', [
                'message' => 'Cet E-mail ne correspond a aucun compte'
            ]);
        }
    }

    /**
     * @return void
     */
    private function logout() :void
    {
        session_destroy();
        $this->display('user/login', 'Connexion', [
            'message' => 'Vous vous êtes déconnecté avec succès'
        ]);
    }
}