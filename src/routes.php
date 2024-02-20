<?php
return [
// Вывод отдельной статьи
    '~^articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'], 

// Редактирование статьи
    '~^articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],

// Добавление статьи
    '~^articles/add$~' => [\MyProject\Controllers\ArticlesController::class, 'add'],

// Регистрация пользователей
    '~^users/register$~' => [\MyProject\Controllers\UsersController::class,'signUp'],

//  Login пользователя
    '~^users/login$~' => [\MyProject\Controllers\UsersController::class, 'login'],

// Авторизация пользователя
    '~^users/(\d+)/activate/(.+)$~' => [\MyProject\Controllers\UsersController::class,'activate'],

// Реализация разлогинивания
    '~^users/logout$~' =>  [\MyProject\Controllers\UsersController::class,'logout'],

// Удаление статьи
    '~^articles/(\d+)/delete$~' => [\MyProject\Controllers\ArticlesController::class, 'delete'],

// Главная страница
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main'],
];
?>