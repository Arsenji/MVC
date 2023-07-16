<?php
namespace application\models;
use application\core\Model;
use PDO;

class Main extends Model
{
    public function __construct()
    {
        $config = require 'application/config/db.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";

        try {
            $this->db = new PDO($dsn, $config['user'], $config['password']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Выбор базы данных
            $this->db->query("USE {$config['dbname']}");
        } catch (PDOException $e) {
            die('Ошибка подключения к базе данных: ' . $e->getMessage());
        }
    }

    public function addTask($description)
    {
        $user_id = $_SESSION['user_id'];
        $created_at = date('Y-m-d');
        $status = 'Невыполнено';

        if (!empty($user_id) && !empty($description)) {
            $sql = "INSERT INTO tasks (user_id, description, created_at, status) VALUES ('$user_id', '$description', '$created_at', '$status')";
            $this->db->query($sql);
        }
    }

    public function updateTaskStatus($task_id, $status)
    {
        $sql = "UPDATE tasks SET status = '$status' WHERE id = '$task_id'";
        $this->db->query($sql);
    }

    public function deleteTask($task_id)
    {
        $sql = "DELETE FROM tasks WHERE id = '$task_id'";
        $this->db->query($sql);
    }

    public function deleteAllTasks()
    {
        $user_id = $_SESSION['user_id'];
        $sql = "DELETE FROM tasks WHERE user_id = '$user_id'";
        $this->db->query($sql);
    }

    public function getAllTasks()
    {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM tasks WHERE user_id = '$user_id'";
        $stmt = $this->db->query($sql);

        // Используйте fetchAll() на объекте PDOStatement
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}