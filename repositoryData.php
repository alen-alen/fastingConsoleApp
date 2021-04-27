<?php

use App\FastAction;


return [
    'nav' =>
    [
        1 => [
            'name' => 'Start new fast',
            'action' => 'startNew'
        ],
        2 => [
            'name' => 'Status',
            'action' => 'status'
        ],
        3 => [
            'name' => 'Stop Active Fast',
            'action' => 'stopFast'
        ],
        4 => [
            'name' => 'Edit Fast',
            'action' => 'editFast'
        ],
        5 => [
            'name' => 'Show all fasts',
            'action' => 'listAll'
        ],
        6 => [
            'name' => 'Exit',
            'action' => 'exit'
        ],

    ],
    'fastTypes' => [
        
        1 => 16,
        2 => 18,
        3 => 20,
        4 => 36
    ]


];
