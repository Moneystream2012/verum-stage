<?php

return [
    'deposit' => [
        0 => 'final',
        1 => 'active',
    ],
    'withdraw' => [
        \App\Withdraw::STATUS_PROCESSING => 'processing',
        \App\Withdraw::STATUS_SUCCESS => 'success',
        \App\Withdraw::STATUS_REJECTION => 'rejection',
    ],
    'verification' => [
        \App\Verification::NOT_VERIFIED => 'not verified',
        \App\Verification::PROCESSING => 'processing',
        \App\Verification::VERIFIED => 'verified',
    ],
    'trading' => [
        \App\Trading::ACTIVE => 'active',
        \App\Trading::FINAL => 'final',
        \App\Trading::REFUND => 'refund',
    ],
];
