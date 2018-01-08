<?php

return [
    'role_structure' => [
        'admin' => [
        ],
        'editor' => [
        ],
        'user' => [
        ],
        'guest'=>[
        ]
    ],
    'permission_structure' => [
        'cru_user' => [
            'profile' => 'c,r,u'
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
