
<?php // require 'application/controllers/AccountController.php';

use application\core\Router;
?>
<html>
<head>
    <title>Страница аутентификации</title>
</head>
<body>
<h1>Страница аутентификации</h1>
<form method="POST" id="signin" action="login">
    <input type="text" id="login" name="login" placeholder="login" required autocomplete="current-login">
    <input type="password" id="password" name="password" placeholder="password" required autocomplete="current-password">
    <button type="submit" name="enter">Отправить</button>

</form>
</body>
</html>
