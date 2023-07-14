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

    public function __construct()
    {
        $this->userModel = new User(); // Создание экземпляра модели User
        $this->authView = new View($this->route); // Создание экземпляра представления View
    }

    public function loginAction()
    {
        $data = [
            'login' => $_POST['login'],
        'password' => $_POST['password'],
        ];
        // Проверка существования пользователя в базе данных
        $user = $this->userModel->getUserByUsername();

        if ($user) {
            // Пользователь существует
            if (password_verify($data['password'], $user['password'])) {
                // Успешная аутентификация
                $_SESSION['login'] = $data['login'];
              header('Location: /index.php'); // Перенаправляем на страницу после успешной аутентификации
                exit();
        }
            else
            {
            // Пользователь не существует, добавляем его автоматически
            $this->userModel->hashPassword($data);

            // Успешная аутентификация
            $_SESSION['login'] = $this->userModel->login;
            $this->userModel->authenticated();
            header('Location: /index.php'); // Перенаправляем на страницу после успешной аутентификации
            }
            exit();
        }
    }
}

