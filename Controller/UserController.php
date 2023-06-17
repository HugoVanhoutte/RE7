<?php

namespace App\Controller;

use App\Model\Entity\User;
use App\Model\Manager\UserManager;
use App\utils\MailUtil;

class UserController extends AbstractController implements ControllerInterface
{
    public function index(array $params = []): void
    {
        if (!isset($params['action'])) {
            $this->displayError(404);
            exit();
        }

        switch ($params['action']) {
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
                if (isset($params['id'])) {
                    $this->profile($params['id']);
                } else {
                    $this->displayError(404);
                }
                break;
            }

            case 'edit' :
            {
                if (isset($params['id'])) {
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

            case 'delete' :
            {
                $this->delete($params['id']);
                break;
            }

            case 'deletion_validated' :
            {
                $this->deletionValidated($params['id'], $_POST['deleteAll']);
                break;
            }

            case 'rgpd' :
            {
                $this->display("user/rgpd", "RGPD");
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
     */
    private function validateRegistration(array $registrationInfo): void
    {
        if (empty($_POST)) {                                                                                            //Ensures that no error message is displayed on register page before sending info
            die();
        }

        $userManager = new UserManager();

        if ($userManager->checkUsernameAlreadyInDB($registrationInfo['username']))                                       //If true: a username is already in DB
        {
            //Display Message on registration page that username already taken
            $this->display('user/register', 'S\'enregistrer', [
                'error' => 'Ce nom d\'utilisateur est déjà utilisé'
            ]);
        } elseif ($userManager->checkEmailAlreadyInDB($registrationInfo['email'])) {
            //Display Message on registration page that email already taken
            $this->display('user/register', 'S\'enregistrer', [                                           //If true: an email is already used in DB
                'error' => 'Cette adresse mail est déjà utilisé'
            ]);
        } elseif (!($registrationInfo['password'] === $registrationInfo['passwordConfirm']))                              //If true: password and password confirmation doesn't match
            //Display Error Message (Generic)
            $this->display('user/register', 'S\'enregistrer', [
                'error' => 'Une erreur s\'est produite, veuillez réessayer'
            ]);

        elseif (!$userManager->validateEmail($registrationInfo['email']))                                               //If true: email is not valid
        {
            //Display Error Message (Generic)
            $this->display('user/register', 'S\'enregistrer', [
                'error' => 'Une erreur s\'est produite, veuillez réessayer'
            ]);
        } elseif (!$userManager->validateUsername($registrationInfo['username']))                                          //If true: username is not valid
        {
            //Display Error Message (Generic)
            $this->display('user/register', 'S\'enregistrer', [
                'error' => 'Une erreur s\'est produite, veuillez réessayer'
            ]);
        } elseif (!$userManager->validatePassword($registrationInfo['password']))                                         //If true: password is not valid
        {
            //Display Error Message (Generic)
            $this->display('user/register', 'S\'enregistrer', [
                'error' => 'Une erreur s\'est produite, veuillez réessayer'
            ]);
        } else                                                                                                            //All good: create a new User and send confirmation email
        {
            $username = $userManager->sanitize($registrationInfo['username']);
            $email = $userManager->sanitize(strtolower($registrationInfo['email']));
            $password = password_hash($registrationInfo['password'], PASSWORD_BCRYPT);
            $token = uniqid("", true);

            $newUser = (new User())
                ->setUsername($username)
                ->setEmail($email)
                ->setPassword($password)
                ->setToken($token);

            $userManager->insert($newUser);
            $newUser = $userManager->get($userManager->getIdFromEmail($newUser->getEmail()));

            $id = $newUser->getId();
            $host = $_SERVER['HTTP_HOST'];

            if ((new MailUtil())->sendmail([$newUser->getEmail()], '[RE7] Confirmation de votre compte', "
                <h1>Bienvenue sur RE7</h1>
                <p>Cliquez sur ce lien pour confirmer votre adresse mail</p>
                <a href='$host/index.php/user?action=emailValidation&id=$id&token=$token'>Confirmer mon adresse Mail</a>    
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
        if ($user->getToken() === $params['token']) {
            $updateData = [
                'role_id' => 4,
                'token' => null
            ];
            $userManager->update($user->getId(), $updateData);

            $this->display('user/login', 'Connexion', [
                'message' => 'Adresse E-mail vérifié, vous pouvez vous connecter'
            ]);
        } else {
            $this->display('home/generic_display', 'Erreur', [
                'error' => 'Une erreur s\'est produite, veuillez réessayer'
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
     * @param array $data
     * @return void
     */
    private function validateLogin(array $data): void
    {
        //Prevent error messages
        if (empty($data)) {
            exit();
        }
        $userManager = new UserManager();
        //if email address exists in DB, get user Entity, check if entered password matches DB password
        if ($userManager->checkEmailAlreadyInDB($data['email'])) {
            $user = $userManager->get($userManager->getIdFromEmail($data['email']));
            if (password_verify($data['password'], $user->getPassword())) {
                //Password correct, start session
                $_SESSION['user_id'] = $user->getId();
                $this->display("home/index", "Homepage", [
                    'message' => 'Vous êtes maintenant connecté'
                ]);
            } else {
                //If password is not correct: send back to login page with error message
                $this->display('user/login', 'Connexion', [
                    'error' => 'Mot de passe incorrect'
                ]);
            }
        } else {
            //If entered email is not present in DB: sends back to login page with corresponding error message
            $this->display('user/login', 'Connexion', [
                'error' => 'Cette adresse e-mail ne correspond à aucun compte'
            ]);
        }
    }

    /**
     * destroys user session and sends back to login page with success message
     * @return void
     */
    private function logout(): void
    {
        session_destroy();
        $this->display('user/login', 'Connexion', [
            'message' => 'Vous vous êtes déconnecté avec succès'
        ]);
    }

    /**
     * displays user profile from its id: if user doesn't exist: redirects to 404
     * @param int $id
     * @return void
     */
    private function profile(int $id): void
    {
        $user = (new UserManager())->get($id);
        if (is_null($user)) {
            $this->displayError(404);
            exit;
        }
        $username = $user->getUsername();
        $this->display('user/profile', "Profil de $username", [
            'user' => $user
        ]);
    }

    /**
     * displays profile edition page if user is authorised
     * @param int $id
     * @return void
     */
    private function edit(int $id): void
    {
        $userManager = new UserManager();
        if ($userManager->isAuthor($id)) {
            $this->display('user/edit', 'Modifier', [
                'id' => $id
            ]);
        } else {
            $this->displayError(403);
        }
    }

    /**
     * Validate edited values and update DB
     * @param array $data
     * @param int $id
     * @return void
     */
    private function validateEdit(array $data, int $id): void
    {
        //gets infos from data array, checks if they are valid, and then updates DB
        $userManager = new UserManager();
        $user = $userManager->get($id);
        //Check if email entered in form is identical to the one already in DB:
        if ($user->getEmail() !== $data['email']) {
            //If email changed, check if new email is not already in DB
            if ($userManager->checkEmailAlreadyInDB($data['email'])) {
                //If new email is already in DB: display message
                $this->display('user/edit', 'Modifier', [
                    'error' => 'Cette adresse email est déjà utilisée'
                ]);
            } else { //If email is valid, check same things for username
                if ($user->getUsername() !== $data['username']) {
                    if (!$userManager->checkUsernameAlreadyInDB($data['username'])) {
                        $this->display('user/edit', 'Modifier', [
                            'error' => 'Ce nom d\'utilisateur est déjà utilisé'
                        ]);
                    }
                }
            }
        }
        //If nothing is wrong, check if input are valid
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
                'error' => 'Une erreur s\'est produite, veuillez réessayer' //Generic error: avoidable in front
            ]);
        }
    }

    /**
     * displays password reset request page
     * @return void
     */
    private function passwordReset(): void
    {
        $this->display('user/password_reset', 'Mot de passe oublié');
    }

    /**
     * sends password reset mail after checking if entered email address exists in DB
     * @param string $email
     * @return void
     */
    private function resetPasswordSendMail(string $email): void
    {
        $userManager = new UserManager();
        if (!$userManager->validateEmail($email)) { //If email address not valid: error
            $this->display('user/password_reset', 'Mot de passe oublié', [
                'error' => 'Une erreur s\'est produite, veuillez réessayer' //Generic Error: avoidable in front
            ]);
        }

        if (!$userManager->checkEmailAlreadyInDB($email)) { //If email address not in DB: error message
            $this->display('user/password_reset', 'Mot de passe oublié', [
                'error' => 'Cette adresse e-mail n\'est associée à aucun compte'
            ]);
        }
        //If everything is correct: get user from DB by email address and send password reset email.
        $user = $userManager->get($userManager->getIdFromEmail($email));

        //Gets users infos and generates new token
        $id = $user->getId();
        $username = $user->getUsername();
        $token = uniqid("", true);

        //Gets host info: useful for hosting changes: don't have to manually change host info when deploying project on another server
        $host = $_SERVER['HTTP_HOST'];

        //Email body
        $body = "
                <h1>Bonjour $username</h1>
                <p>Cliquez sur ce lien pour changer votre mot de passe</p>
                <a href='$host/index.php/user?action=newPassword&id=$id&token=$token'>Changer mon mot de passe</a> 
                <p>Si vous n'êtes pas à l'origine de cette action, ne cliquez pas sur le lien</p>
            ";

        //If mail successfully sent, update user token in DB
        if ((new MailUtil())->sendmail([$email], '[RE7] Récupération de votre mot de passe', $body)) {

            $userManager->update($id, ['token' => $token]);

            //User feedback
            $this->display('home/generic_display', 'E-mail envoyé', [
                'message' => 'email envoyé avec succès, vous pouvez fermer cette page.'
            ]);
        } else {
            $this->display('user/password_reset', 'Récupération mot de passe', [
                'error' => 'Erreur lors de l\'envoi du mail, veuillez réessayer ultérieurement'
            ]);
        }
    }

    /**
     * Checks if token in url matches token in DB and redirects to password reset page
     * @param int $id
     * @param string $token
     * @return void
     */
    private function newPassword(int $id, string $token): void
    {
        $this->display('user/new_password', 'Changer mot de passe', [
            'id' => $id,
            'token' => $token
        ]);
    }

    /**
     * validates password reset and updates password in DB
     * @param int $id
     * @param string $token
     * @return void
     */
    private function validatePasswordReset(int $id, string $token): void
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

    /**
     * redirects to user deletion confirmation page if user is authorised
     * @param int $id
     * @return void
     */
    private function delete(int $id): void
    {
        $userManager = new UserManager();
        $user = $userManager->get($id);
        if ($userManager->isAuthor($user->getId())) {
            $this->display('user/deletion_confirmation', 'Supprimer', [
                'id' => $id
            ]);
        } else {
            $this->displayError(403);
        }
    }

    /**
     * validated user deletion, if user is authorised and following user preferences set on confirmation page
     * @param $id
     * @param $deleteAll
     * @return void
     */
    private function deletionValidated($id, $deleteAll): void
    {
        $userManager = new UserManager();
        $user = $userManager->get($id);
        //Checks if current user is authorised
        if ($userManager->isAuthor($user->getId())) {
            if ($deleteAll === 'true') {
                //Call delete on user id
                $userManager->delete($id);
                session_destroy();
                $this->display('home/index', 'Accueil', [
                    'message' => 'Votre profil a été supprimé'
                ]);
            } elseif ($deleteAll === 'false') {
                //Set User to deleted
                $userManager->update($id, [
                    'username' => '[supprimé]',
                    'email' => '[supprimé]',
                    'password' => password_hash(uniqid("", true), PASSWORD_BCRYPT),
                    'registration_date_time' => '2000-01-01 00:00:00',
                    'role_id' => 5,
                    'token' => null
                ]);
                session_destroy();
                $this->display('home/index', 'Accueil', [
                    'message' => 'Votre profil a été supprimé'
                ]);
            } else {
                //error
                $this->displayError(403);
            }
        } else {
            //User not authorised: displays error
            $this->displayError(403);
        }
    }
}
