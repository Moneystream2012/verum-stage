<?php

return [
    'title' => 'Withdraw',
    'description' => 'Withdraw of balances',
    'icon' => 'icon-monetization_on',

    'wallet_address' => 'Wallet Address',
    'txid' => 'Txid',
    'processed' => 'Processed',

    'alert_info' => 'Requests for withdrawal of funds are processed by the operator up to '. config('mlm.withdraws.min_day').' working days.',
    'alert_danger' => 'Withdraw is forbidden without <a href="'.route('personal-office.verification.index').'" class="btn-link"><strong>verification profile!</strong></a>',
    'error_msg' => 'Sorry, only VMC address output.',
    'success_msg' => 'A withdrawal request has been sent to.',
];
