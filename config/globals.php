<?php

return 
[
    'info'=>[
        'title' => 'Panel',
        'footer' => '2020 © WarCheats',
        'version' => '0.0.1',
        'sign-up' => 'https://warcheats.net/forum/index.php?login/login',
        'lost-password' => 'https://warcheats.net/forum/index.php?lost-password/'
    ],
    'menu' =>[
    ['text' => 'Dashboard', 'icon' => 'icon-home', 'color' => 'text-primary', 'admin' => false,

        'items'=>
            [
                [
                    'text' => 'Home',
                    'url' => '/home',
                    'icon' => ''
                ]
            ]

    ] ,
    ['text' => 'Administrator', 'icon' => 'icon-suitcase', 'color' => 'text-primary', 'admin' => true,
        'items'=>
            [
                [
                    'text' => 'Manage Users',
                    'url' => '/manage-users',
                    'icon' => ''
                ],
                [
                    'text' => 'Manage Licenses',
                    'url' => '/manage-licenses',
                    'icon' => ''
                ],
                [
                    'text' => 'Manage Products',
                    'url' => '/manage-products',
                    'icon' => ''
                ],                
                [
                    'text' => 'System Log',
                    'url' => '/system-logs',
                    'icon' => ''
                ]
            ]
    ],
    ['text' => 'Products', 'icon' => 'icon-gamepad', 'color' => 'text-primary', 'admin' => false,
        'items'=>
            [
                [
                    'text' => 'Purchase',
                    'url' => '/purchase',
                    'icon' => ''
                ],
                [
                    'text' => 'Download',
                    'url' => '/download',
                    'icon' => ''
                ]
            ]
    ],
    ['text' => 'Account', 'icon' => 'icon-user', 'color' => 'text-primary', 'admin' => false,
        'items'=>
            [
                [
                    'text' => 'Licenses',
                    'url' => '/user-licenses',
                    'icon' => ''
                ],
                [
                    'text' => 'Reset Hwid',
                    'url' => '/reset-token',
                    'icon' => ''
                ],
                [
                    'text' => 'Transactions',
                    'url' => '/user-transactions',
                    'icon' => ''
                ],
                [
                    'text' => 'Connections',
                    'url' => '/connection-log',
                    'icon' => ''
                ]
            ]
    ]
    ]
];
?>