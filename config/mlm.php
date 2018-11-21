<?php

return [
    'replenishments' => [
        'usd' => [
            'coefficient' => 0.005,
            'min'         => 1.00,
        ],
        'btc' => [
            'coefficient' => 0.0001,
            'min'         => 0.001,
        ],
    ],
    'transfers'      => [
        'coefficient' => 0.005,
    ],
    'withdraws'      => [
        'min' => 10.00,
        'min_day' => 3,
        'usd' => [
            'coefficient' => 0.01,
        ],
        'btc' => [
            'coefficient' => 0.0001,
        ],
    ],
    'balance'        => [
        'confirm'    => 1,
        'notconfirm' => 0,
    ],
    'trading' => [
        'invest' => [
            'min' => 10.00,
            'max' => 50000.00,
        ],
    ],
    'currencies'     => [
        'VMC' => [
            'USD' => 0.15,
            'BTC' => 0.00010,
        ],
    ],
];
