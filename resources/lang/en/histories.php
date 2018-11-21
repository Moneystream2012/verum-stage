<?php

return [
    'payments'  => [
        'deposit'       => [
            'icon'  => 'fa-briefcase',
            'title' => 'Payment product: Investment Token USD',
            'body'  => 'Invest: :amount</br>Payment method: :method',
        ],
        'trading'       => [
            'icon'  => 'fa-briefcase',
            'title' => 'Payment product: Trading',
            'body'  => 'Invest: :amount</br>Payment method: :method',
        ],
        'ico'       => [
            'icon'  => 'fa-globe',
            'title' => 'ICO Investment',
            'body'  => 'ICO: :name<br>Amount: :amount USD</br>Payment method: :method',
        ],
    ],
    'transfers' => [
        'deposit'          => [
            'icon'  => 'fa-briefcase',
            'title' => 'Output from the package',
            'body'  => 'Package №: :id<br>Amount: :amount USD<br>Output to: :to',
        ],
        'user_from-amount' => [
            'icon'  => 'fa-exchange',
            'title' => 'Transfer to user',
            'body'  => 'User: :username<br>Amount: :amount USD<br>Commission: :cost_amount USD<br>Type balance: :method',
        ],
        'user_to-amount'   => [
            'icon'  => 'fa-exchange',
            'title' => 'The transfer of user',
            'body'  => 'User: :username<br>Amount: :amount USD<br>Type balance: :method',
        ],
        'exchange'         => [
            'icon'  => 'fa-random',
            'title' => 'Exchange',
            'body'  => ':method => :to<br>Amount: :amount USD',
        ],

    ],
    'profits'   => [
        'deposit'         => [
            'icon'  => 'fa-briefcase',
            'title' => 'Payout product: Investment Token USD',
            'body'  => 'ID : :id<br>Invest: :name<br>Number of: :number_of<br>Percent: :percent %<br>Amount: :amount<br>Output to: :to',
        ],
        'trading'         => [
            'icon'  => 'fa-briefcase',
            'title' => 'Payout product: Global',
            'body'  => 'ID : :id<br>Invest: :name<br>Number of: :number_of<br>Percent: :percent %<br>Amount: :amount<br>Output to: :to',
        ],
        'direct'          => [
            'icon'  => 'fa-gift',
            'title' => 'Calculate bonus: Direct',
            'body'  => 'Bonus: :bonus %<br>Amount: :amount USD<br>Output to: :to',
        ],
        'compute_rewards' => [
            'icon'  => 'fa-gift',
            'title' => 'Compute rewards',
            'body'  => '
                <table class="table table-responsive-xl"><thead>
                <tr>
                 <th>Type</th>
                  <th>Weekly turnover</th>
                  <th>%</th>
                  <th>Output to</th>
                  <th>Amount</th>
                </tr></thead><tbody>
                <tr>
                  <td>Binary bonus</td>
                  <td>:binary-point_left | :binary-point_right</td>
                  <td>:binary-bonus</td>
                  <td>:binary-to</td>
                  <td>:binary-amount USD</td>
                </tr>
                <tr>
                  <td>Direct bonus</td>
                  <td>:direct-reward</td>
                  <td>:direct-bonus</td>
                  <td>:direct-to</td>
                  <td>:direct-amount USD</td>
                </tr>
            </tbody></table>',
        ],
        'binary'          => [
            'icon'  => 'fa-gift',
            'title' => 'Calculate bonus: Binary',
            'body'  => 'Weekly turnover: :point_l | :point_r<br>Bonus: :bonus % <br>Amount: :amount USD<br>Output to: :to',
        ],
        'sponsor-deposit' => [
            'icon'  => 'fa-gift',
            'title' => 'Referral bonus: Investment Token USD',
            'body'  => 'User: :sponsor_username<br>Level: :level<br>Invest: :invest<br>Percent: :percent %<br>Amount: :amount<br>Output to: :to',
        ],
        'sponsor-trading' => [
            'icon'  => 'fa-gift',
            'title' => 'Referral bonus: Global',
            'body'  => 'User: :sponsor_username<br>Level: :level<br>Invest: :invest<br>Percent: :percent %<br>Amount: :amount<br>Output to: :to',
        ],
        'rank'            => [
            'icon'  => 'fa-gift',
            'title' => 'Bonus for new rank',
            'body'  => 'Rank: :rank<br>Amount: :amount USD<br>Output to: :to',
        ],
        'matching_bonus' => [
            'icon'  => 'fa-gift',
            'title' => 'Matching Bonus',
            'body'  => 'Compute №:number_of<br>Amount: :amount USD<br>Output to: :to',
        ]
    ],
    'requests'  => [
        'replenishment'       => [
            'icon'  => 'fa-money',
            'title' => 'Replenishment',
            'body'  => 'Amount: :amount USD<br>Type balance: :method<br>Type balance: :method',
        ],
        'withdraw-processing' => [
            'icon'  => 'fa-btc',
            'title' => 'Withdraw',
            'body'  => 'Amount: :amount USD<br>Wallet Address: :wallet_address<br>Withdraw: :method => :to',
        ],
        'withdraw-success'    => [
            'icon'  => 'fa-btc',
            'title' => 'Withdraw: success',
            'body'  => 'ID: :id<br>Amount: :amount USD<br>Output to: :to<br>Txid: :tx',
        ],
        'withdraw-rejection'  => [
            'icon'  => 'fa-btc',
            'title' => 'Withdraw: rejection',
            'body'  => 'ID: :id<br>Amount: :amount USD<br>Output to: :to',
        ],
    ],
];
