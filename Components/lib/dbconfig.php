<?php

$GLOBALS['config'] = [
    'mysql' => [
        'driver' => 'mysql', // тип базы данных, с которой мы будем работать
        'host' => 'localhost', // альтернатива '127.0.0.1' - адрес хоста, в нашем случае локального
        'username' => 'root',  // имя пользователя для базы данных
        'password' => '', // пароль пользователя
        'database' => 'user_management_system', // имя базы данных
        'charset' => 'utf8', // кодировка по умолчанию

    ],
    'session' => [
        'token_name' => 'token', // временое имя токена при отправки данных
        'user_session' => 'user', //  временная сессия пользователя c запись id при авторизации до выхода из сайта
    ],
    'cookie' => [
        'cookie_name' => 'hash', // имя cookie присваеваемо пользователю при активном чек боксе remember me
        'cookie_expiry' => 604800 // время жизни куки
    ],

    'links' => [
        'home' => '/index.php',
        'user_profile' => '/user_profile.php',
        'login' => '/login.php',
        'register' => '/register.php',
        'profile' => '/profile.php',
        'change_password' => 'changepassword.php',
        'admin' => ['index' => '/users/index.php',
            'edit' => '/users/edit.php',
            'group' => '/users/change-group.php',
            'delete' => '/users/delete.php',

        ],

    ]


];


