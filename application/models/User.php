<?php
namespace application\models;
use application\core\Model;

require_once 'application/core/Model.php';
class User extends Model
{
    public $data;
    private $conn;
    public $result;
    public $stored_hash;
    public $login;
    public $password;
    public $registrationDate;
    public $sql;

    public function dbConnect()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $config = require 'application/config/db.php';
            $this->conn = mysqli_connect($config['host'], $config['user'], $config['password'], $config['dbname']);

            if (!$this->conn) {
                die('Ошибка подключения к базе данных: ' . mysqli_connect_error());
            }
        }
    }

    public function getFormData($data)
    {
        $this->login = $data['login'];
        $this->password = $data['password'];
        $this->registrationDate = date('Y-m-d');
    }

    public function getUserByUsername()
    {
        $this->dbConnect();
        $this->sql = "SELECT * FROM tasklist.users WHERE login = '$this->login'";
        $this->result = mysqli_query($this->conn, $this->sql);
    }

    public function createUser()
    {
        $this->getFormData($this->data);
        $this->dbConnect();
        $this->sql = "INSERT INTO tasklist.users (login, password, created_at) VALUES ('$this->login', '$this->hash_password', '$this->registrationDate')";
        mysqli_query($this->conn, $this->sql);
        $user_id = mysqli_insert_id($this->conn);
        $_SESSION['user_id'] = $user_id;

        //header("location: index.php");
    }

    public function authenticated()
    {
        $authenticated =true;
        $_SESSION['authenticated'] = $authenticated;
    }

    public function hashPassword($data)
    {
        $this->hash_password = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->createUser();
    }
}