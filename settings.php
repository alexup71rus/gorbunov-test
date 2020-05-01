<?php
// массив с настройками.
// ВНИМАНИЕ! Ключи (название настройки) можно изменять только в рамках всего проекта.
return [
    'db' => [
        'local' => [
            'host' => 'localhost',
            'port' => 3306,
            'login' => 'user',
            'pass' => '123',
            'db' => 'bureau',
        ],
        'production' => [
            'host' => 'localhost',
            'port' => 3306,
            'login' => 'bureau',
            'pass' => 'PvlZRgHc',
            'db' => 'bureau',
        ],
    ],
//    'users' => [
//        'admin' => [
//            'password' => '123',
//        ]
//    ]
];
