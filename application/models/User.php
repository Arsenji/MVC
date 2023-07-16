<?php

namespace application\models;

use application\core\Model;

require_once 'application/core/Model.php';

class User extends Model
{
    public $data;
    private $conn;
    public $result;
    public $login;
    public $password;
    public $registrationDate;
    public $sql;
    private $hash_password;

    /**
     * @var false|string|null
     */

    public function dbConnect($data)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $config = require 'application/config/db.php';
            $this->conn = mysqli_connect($config['host'], $config['user'], $config['password'], $config['dbname']);

            if (!$this->conn) {
                die('Ошибка подключения к базе данных: ' . mysqli_connect_error());
            }
            $this->login = $data['login'];
            $this->password = $data['password'];
            $this->registrationDate = date('Y-m-d');
        }
        $this->hashPassword($this->password);
    }
    public function createUser($login)
    {
        $this->login = $login;
        $this->dbConnect($this->data);
        $this->sql = "INSERT INTO tasklist.users (login, password, created_at) VALUES ('$login', '$this->hash_password', '$this->registrationDate')";
        mysqli_query($this->conn, $this->sql);
        $user_id = mysqli_insert_id($this->conn);
        $_SESSION['user_id'] = $user_id;
    }
    public function getUserByUsername($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
        $this->dbConnect($this->data);
        $this->sql = "SELECT * FROM tasklist.users WHERE login = '$login'";
        $this->result = mysqli_query($this->conn, $this->sql);
        if (mysqli_num_rows($this->result) == 1) {
            $row = mysqli_fetch_assoc($this->result);
            $storedHash = $row['password'];
            if (password_verify($password, $storedHash)) {
                // Авторизация успешна
                $_SESSION['login'] = $login;
                $_SESSION['password'] = $password;
                header("location: main/index");
                exit();
            }
        } else {
            echo 'Пользователь не найден';
        }
        debug($this->conn);
    }


    public function authenticated()
    {
        $authenticated = true;
        $_SESSION['authenticated'] = $authenticated;
    }

    public function hashPassword($password)
    {
        $this->password = $password;
        if ($password !== null) {
            $this->hash_password = password_hash($password, PASSWORD_BCRYPT);
            $this->createUser($this->login);
        }
    }

}