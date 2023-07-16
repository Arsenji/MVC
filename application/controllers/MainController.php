<?php
namespace application\controllers;

use application\core\Controller;

class MainController extends Controller
{
        public function indexAction()
    {
        // Проверяем состояние аутентификации пользователя
        if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
            // Пользователь не аутентифицирован, перенаправляем на страницу входа или другую страницу
            header("location: index.php");
            exit();
        }

        // Обработка добавления новой задачи
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $description = $this->sanitize($_POST['description']);
            $this->model->addTask($description);
        }

        // Обработка изменения статуса задачи
        if (isset($_GET['task_id']) && isset($_GET['status'])) {
            $task_id = $_GET['task_id'];
            $status = $_GET['status'];
            $this->model->updateTaskStatus($task_id, $status);
        }

        // Обработка удаления задачи
        if (isset($_GET['delete_task_id'])) {
            $task_id = $_GET['delete_task_id'];
            $this->model->deleteTask($task_id);
        }

        // Обработка удаления всех задач
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_all'])) {
            $this->model->deleteAllTasks();
        }

        // Получаем список задач
        $tasks = $this->model->getAllTasks();

        // Передаем данные в представление
        $vars = [
            'tasks' => $tasks
        ];
    }
}
