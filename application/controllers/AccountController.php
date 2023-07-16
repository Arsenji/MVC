<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\models\User;

require_once 'application/core/Controller.php';
require_once 'application/models/User.php'; // Подключаем модель пользователя
require_once 'application/views/account/login.php'; // Подключаем представление авторизации

class AccountController extends Controller
{
    public $authView;
    public $userModel;
    public $data;

    public function __construct()
    {
        $this->userModel = new User(); // Создание экземпляра модели User
        $this->authView = new View($this->route); // Создание экземпляра представления View
    }

    public function loginAction()
    {
        if (isset($_POST['login']) && isset($_POST['password'])) {
            $this->data = [
                'login' => $_POST['login'],
                'password' => $_POST['password'],
            ];
            $this->userModel->dbConnect($this->data);
            $this->userModel->getUserByUsername($this->data['login'], $this->data['password']);
            exit;
        }
        else
        {
            $this->userModel->createUser($this->userModel->login);
            $_SESSION['login'] = $this->userModel->login;
        }
        $this->userModel->authenticated();
    }
}


