<?php

namespace App\Controller;

use App\Model\MailUtil;
use App\Model\Manager\UserManager;
use App\Model\Entity\User;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

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
                break;
            }

            case 'validateRegistration' : //Checks registration infos and send mail
            {
                $this->validateRegistration($_POST);
                break;
            }

            case 'emailValidation' :
            {
                $this->emailValidation($params);
                break;
            }

            case 'login' :
            {
                $this->login();
                break;
            }

            case 'validateLogin' :
            {
                $this->validateLogin($_POST);
                break;
            }

            case 'logout' :
            {
                $this->logout();
                break;
            }

            case 'profile' :
            {
                if (isset($params['id'])){
                    $this->profile($params['id']);
                } else {
                    $this->displayError(404);
                }
                break;
            }

            case 'edit' :
            {
                if (isset($params['id'])){
                    $this->edit($params['id']);
                } else {
                    $this->displayError(404);
                }
                break;
            }

            case 'validateEdit' :
            {
                $this->validateEdit($_POST, $params['id']);
                break;
            }

            case 'passwordReset' :
            {
                $this->passwordReset();
                break;
            }

            case 'passwordResetSendMail' :
            {
                $this->resetPasswordSendMail($_POST['email']);
                break;
            }

            case 'newPassword' :
            {
                $this->newPassword($params['id'], $params['token']);
                break;
            }

            case 'validatePasswordReset' :
            {
                $this->validatePasswordReset($params['id'], $params['token']);
                break;
            }

            default:
            {
                $this->displayError(404);
                break;
            }
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
                'message' => 'Ce nom d\'utilisateur est déjà utilisé'
            ]);
        }

        elseif($userManager->checkEmailAlreadyInDB($registrationInfo['email']))
        {
            //Display Message on registration page that email already taken
            $this->display('user/register', 'S\'enregistrer', [                                           //If true: an email is already used in DB
                'message' => 'Cette adresse mail est déjà utilisé'
            ]);
        }

        elseif (!($registrationInfo['password'] === $registrationInfo['passwordConfirm']))                              //If true: password and password confirmation doesn't match
            //Display Error Message (Generic)
            //TODO Make generic: can be checked on front end
            $this->display('user/registration', 'S\'enregistrer', [
                'message' => 'Les mots de passe ne correspondent pas'
            ]);

        elseif (!$userManager->validateEmail($registrationInfo['email']))                                               //If true: email is not valid
        {
            //Display Error Message (Generic)
            //TODO Make generic: can be checked in front
            $this->display('user/register', 'S\'enregistrer', [
                'message' => 'L\'adresse email n\'est pas correcte'
            ]);
        }

        elseif(!$userManager->validateUsername($registrationInfo['username']))                                          //If true: username is not valid
        {
            //Display Error Message (Generic)
            //TODO Make Generic: can be checked in front
            $this->display('user/register', 'S\'enregister', [
                'message' => 'Le nom d\'utilisateur n\'est pas valide'
            ]);
        }

        elseif (!$userManager->validatePassword($registrationInfo['password']))                                         //If true: password is not valid
        {
            //Display Error Message (Generic)
            //TODO Make Generic: can be checked in front
            $this->display('user/register', 'S\'enregistrer', [
                'message' => 'Le mot de passe n\'est pas valide'
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

            if((new MailUtil())->sendmail([$newUser->getEmail()], '[RE7] Confirmation de votre compte', "
                <h1>Bienvenue sur RE7</h1>
                <p>Cliquez sur ce lien pour confirmer votre adresse mail</p>
                <a href='localhost/RE7/public/index.php/user?action=emailValidation&id=$id&token=$token'>Confirmer mon adresse Mail</a>    
            ")) {
                $this->display('home/generic_display', 'Compte créé', [
                    'message' => 'votre compte a été créé, un e-mail de confirmation vous a été envoyé, vous pouvez fermer cette page.'
                ]);
            }
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
                'role_id' => 4,
                'token' => null
            ];
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
    private function validateLogin(array $data): void
    {
        if(empty($data)) {
            exit();                                                                                                     //Prevent error messages
        }
        $userManager = new UserManager();
        if ($userManager->checkEmailAlreadyInDB($data['email'])) {                                                     //Email exists, get user, check PW
            $user = $userManager->get($userManager->getIdFromEmail($data['email']));
            if (password_verify($data['password'], $user->getPassword())) {                                            //Password correct, start session

                $_SESSION['user_id'] = $user->getId();

                $this->display('home/index', 'Accueil', [
                    'message' => 'Connecté avec succès !'
                ]);

            } else {                                                                                                    //Wrong Password
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

    /**
     * @param int $id
     * @return void
     */
    private function profile(int $id): void
    {
        $user = (new UserManager())->get($id);
        $username = $user->getUsername();
        $this->display('user/profile', "Profil de $username", [
            'user' => $user
        ]);
    }

    /**
     * @param int $id
     * @return void
     */
    private function edit(int $id): void
    {
        $this->display('user/edit', 'Modifier', [
            'id' => $id
        ]);
    }

    /**
     * @param array $data
     * @param int $id
     * @return void
     */
    private function validateEdit(array $data, int $id): void
    {
        //gets infos from data array, checks if they are valid, and then updates DB
        //TODO
        $userManager = new UserManager();
        $user = $userManager->get($id);
        //Check if email entered in form is identical to the one already in DB:
        if ($user->getEmail() !== $data['email']) {
            //If email changed, check if new email is not already in DB
            if ($userManager->checkEmailAlreadyInDB($data['email'])) {
                //If new email is already in DB: display message
                $this->display('user/edit', 'Modifier', [
                    'message' => 'Cet adresse email est déjà utilisée'
                ]);
            } else { //If email is valid, check same things for username
                if ($user->getUsername() !== $data['username']) {
                    if (!$userManager->checkUsernameAlreadyInDB($data['username'])) {
                        $this->display('user/edit', 'Modifier', [
                            'message' => 'Ce nom d\'utilisateur est déjà utilisé'
                        ]);
                    }
                }
            }
        }
        //If nothing happens, check if input are valid
        if ($userManager->validateEmail($data['email']) && $userManager->validateUsername($data['username'])) {
            //UPDATE
            $data = [
                'username' => trim($data['username']),
                'email' => strtolower(trim($data['email']))
            ];
            $userManager->update($id, $data);
            $this->profile($id);
        } else {
            $this->display('user/edit', 'Modifier', [
                'message' => 'Erreur' //Generic error: avoidable in front
            ]);
        }
    }

    /**
     * @return void
     */
    private function passwordReset(): void
    {
        $this->display('user/password_reset', 'Mot de passe oublié');
    }

    /**
     * @param string $email
     * @return void
     */
    private function resetPasswordSendMail(string $email): void
    {
        $userManager = new UserManager();
        if (!$userManager->validateEmail($email)) { //If email address not valid: error
            $this->display('user/password_reset', 'Mot de passe oublié', [
                'message' => 'Cette adresse e-mail n\'est pas valide'
            ]);
        }

        if (!$userManager->checkEmailAlreadyInDB($email)) { //If email address not in DB: error message
            $this->display('user/password_reset', 'Mot de passe oublié', [
                'message' => 'Cette adresse e-mail n\'est associée à aucun compte'
            ]);
        }
        //If everything is correct: get user from DB by email address and send password changing mail.
        $user = $userManager->get($userManager->getIdFromEmail($email));

        $id = $user->getId();
        $username = $user->getUsername();
        $token = uniqid("", true);

        $body = "
                <h1>Bonjour $username</h1>
                <p>Cliquez sur ce lien pour changer votre mot de passe</p>
                <a href='localhost/RE7/public/index.php/user?action=newPassword&id=$id&token=$token'>Changer mon mot de passe</a> 
                <p>Si vous n'êtes pas à l'origine de cette action, ne cliquez pas sur le lien</p>
            ";

        if((new MailUtil())->sendmail([$email], '[RE7] Récupération de votre mot de passe', $body)) {//If mail successfully sent, update user token in DB

            $userManager->update($id, ['token'=>$token]);

            $this->display('home/generic_display', 'E-mail envoyé', [
                'message' => 'email envoyé avec succès, vous pouvez fermer cette page.'
            ]);
        } else {
            $this->display('user/password_reset', 'Récupération mot de passe', [
                'message' => 'Erreur lors de l\'envoi du mail, veuillez réessayer ultérieurement'
            ]);
        }
    }

    private function newPassword(int $id, string $token)
    {
            $this->display('user/new_password', 'Changer mot de passe', [
                'id' => $id,
                'token' => $token
                ]);
    }

    private function validatePasswordReset(int $id, string $token)
    { //Check if user token matches sent token
        $userManager = new UserManager();
        $user = $userManager->get($id);
        if ($token !== $user->getToken()) {
            (new RootController())->displayError(403);
        } else {
            if ($userManager->validatePassword($_POST['password']) && $_POST['password'] === $_POST['passwordConfirm']) {
                //If both password matches and password is valid, update password and reset token

                $userData['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $userData['token'] = null;

                $userManager->update($id, $userData);
                $this->display('user/login', 'Se connecter', [
                    'message' => 'Mot de passe changé avec succès, vous pouvez vous connecter'
                ]);
            }
        }
    }
}
