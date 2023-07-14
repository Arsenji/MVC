<?php
namespace application\models;
use application\core\Model;

class Main extends Model
{
    public function getStatus()
    {
        if (isset($_GET['task_id']) && isset($_GET['status']) && isset($_SESSION['user_id'])) {
            $task_id = $_GET['task_id'];
            $status = $_GET['status'];

            $sql = "UPDATE tasks SET status = '$status' WHERE id = '$task_id'";
            mysqli_query($this->db, $sql);
        }
    }

    public function getDelete()
    {
        if (isset($_GET['delete_task_id']) && isset($_SESSION['user_id'])) {
            $task_id = $_GET['delete_task_id'];

            $sql = "DELETE FROM tasklist.tasks WHERE id = '$task_id'";
            mysqli_query($this->db, $sql);
        }
    }

    public function getDeleteAll()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_all'])) {
            require_once("includes/connection.php");

            $user_id = $_SESSION['user_id'];

            $sql = "DELETE FROM tasks WHERE user_id = '$user_id'";
            mysqli_query($this->db, $sql);
        }
    }
}