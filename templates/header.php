<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой блог</title>
    <link rel="stylesheet" href="/../myproject/www/style.css">
</body>
</head>
<body>
    <table class="layout">
        <tr>
            <td colspan="2" class="header">
                Мой блог
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right">
                <?= !empty($user) ? 'Привет, '. $user->getNickname() . ' | ' . '<a href="/myproject/www/users/logout">Выйти</a>' : '<a href="/myproject/www/users/login">Вход</a>' . ' | ' .'<a href="/myproject/www/users/register">Регистрация</a>'?>
            </td>
        </tr>
        <tr>
            <td>
