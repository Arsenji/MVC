<!DOCTYPE html>
<html>
<head>
    <link href="/style/style.css">
    <title>Task List</title>
</head>
<body>
<div class="container">
    <h2>Мои задачи</h2>

    <form method="POST" action="">
        <input type="text" name="description" placeholder="Введите задачу">
        <button type="submit" name="addTask" id="addTask">Добавить задачу</button>
        <button type="submit" name="delete_all">Удалить все</button>
    </form>

    <table>
        <tr>
            <th>Задача</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?php echo $task['description']; ?></td>
                <td>
                    <?php if ($task['status'] == 'Выполнено'): ?>
                        <span class="status-circle completed"></span>
                    <?php else: ?>
                        <span class="status-circle not-completed"></span>
                    <?php endif; ?>
                    <?php echo $task['status']; ?>
                </td>
                <td>
                    <a class="btn" href="/main/updateTaskStatus?task_id=<?php echo $task['id']; ?>&status=<?php echo ($task['status'] == 'Выполнено') ? 'Невыполнено' : 'Выполнено'; ?>">
                        <?php echo ($task['status'] == 'Выполнено') ? 'Невыполнено' : 'Выполнено'; ?>
                    </a>
                    <a class="delete" href="/main/deleteTask?task_id=<?php echo $task['id']; ?>">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
