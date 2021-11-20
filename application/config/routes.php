<?php

return [
    // MainController
    '' => [
        'controller' => 'main',
        'action' => 'index',
    ],
    '{code:\w+}' => [
        'controller' => 'main',
        'action' => 'shorten',
    ],
    'about' => [
        'controller' => 'main',
        'action' => 'about',
    ],
    'contacts' => [
        'controller' => 'main',
        'action' => 'contacts',
    ],
    'help' => [
        'controller' => 'main',
        'action' => 'help',
    ],
    // UserController
    'user/login' => [
        'controller' => 'user',
        'action' => 'login',
    ],
    'user/signup' => [
        'controller' => 'user',
        'action' => 'signup',
    ],
    'user/recovery' => [
        'controller' => 'user',
        'action' => 'recovery',
    ],
    'user/confirm/{token:w+}' => [
        'controller' => 'user',
        'action' => 'confirm',
    ],
    'user/reset/{token:w+}' => [
        'controller' => 'user',
        'action' => 'reset',
    ],
    'user/logout' => [
        'controller' => 'user',
        'action' => 'logout',
    ],
];