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

    </table>
</div>
</body>
</html>