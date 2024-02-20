<?php
namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\User;

use MyProject\Models\Users\UserActivationService;
use MyProject\Models\Users\UsersAuthService;
use MyProject\Models\Users\UsersLogOutService;

use MyProject\Services\EmailSender;

class UsersController extends AbstractController
{

    public function signUp()
    {
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }

            if ($user instanceof User) {
                $code = UserActivationService::createActivationCode($user);

                EmailSender::send($user, "Активация аккаунта", 'userActivation.php', $code, [
                    'userId' => $user->getId(),
                    'code' => $code
                ]);
                $this->view->renderHtml('users/signUpSuccessful.php');
                return;
            }
        }

        $this->view->renderHtml('users/signUp.php');
    }

    public function activate(int $userId, string $activationCode)
    {
        $user = User::getById($userId);
        $isCodeValid = UserActivationService::CheckActivationCode($user, $activationCode);
        if ($isCodeValid) {
            $user->activate();
            echo "Аккаунт активирован" . ' | ' . "<a href = '/myproject/www/users/login '>Вход в аккаунт</a>";
        }
        
    }

    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /myproject/www/');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('users/login.php');
    }
    
    function logout()
    {
        UsersLogOutService::deleteToken();
        header('Location: /myproject/www/');
        $this->view->renderHtml('users/logOutSuccessful.php');
        return;
        }
    }

?>