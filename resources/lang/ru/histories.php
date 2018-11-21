<?php

return [
    'payments'  => [
        'deposit'       => [
            'icon'  => 'fa-briefcase',
            'title' => 'Payment product: Investment Token',
            'body'  => 'Amount: :amount USD</br> Name: :name <br>Payment method: :method',
        ],
        'active_member' => [
            'icon'  => 'fa-user',
            'title' => 'Activation for a year',
            'body'  => 'Amount: :amount USD</br> Activation to: :active_at <br>Payment method: :method',
        ],
        'shares'        => [
            'icon'  => 'fa-file-text',
            'title' => 'The purchase of shares',
            'body'  => 'Amount: :amount USD</br> Number of: :number_of <br>Payment method: :method',
        ],
    ],
    'transfers' => [
        'deposit'          => [
            'icon'  => 'fa-briefcase',
            'title' => 'Output from the package',
            'body'  => 'Package №: :id <br> Amount: :amount USD<br> Output to: :to',
        ],
        'shares'           => [
            'icon'  => 'fa-files-o',
            'title' => 'Sell Shares',
            'body'  => 'Number of: :number_of <br> Amount: :amount USD<br> Output to: :to',
        ],
        'user_from-amount' => [
            'icon'  => 'fa-exchange',
            'title' => 'Transfer to user',
            'body'  => 'User: :username <br> Amount: :amount USD<br> Commission: :cost_amount USD<br> Type balance: :method',
        ],
        'user_to-amount'   => [
            'icon'  => 'fa-exchange',
            'title' => 'The transfer of user',
            'body'  => 'User: :username <br> Amount: :amount USD<br> Type balance: :method',
        ],
        'exchange'         => [
            'icon'  => 'fa-random',
            'title' => 'Exchange',
            'body'  => 'Exchange: :method => :to <br> Amount: :amount USD',
        ],
        'charities'        => [
            'icon'  => 'fa-heart',
            'title' => 'Сharity',
            'body'  => 'Amount: :amount USD<br> Method: :method',
        ],

    ],
    'profits'   => [
        'deposit'         => [
            'icon'  => 'fa-briefcase',
            'title' => 'Payout product: Investment Token',
            'body'  => 'ID : :id <br>Name : :name <br> Number of: :number_of <br> Percent per month: :percent %<br> Amount: :amount USD<br> Output to: :to',
        ],
        'direct'          => [
            'icon'  => 'fa-gift',
            'title' => 'Calculate bonus: Direct',
            'body'  => 'Bonus: :bonus % <br> Amount: :amount USD<br> Output to: :to',
        ],
        'compute_rewards' => [
            'icon'  => 'fa-gift',
            'title' => 'Compute rewards',
            'body'  => '
                <span class="">Compute  №:number_of</span>
                <table class="table no-margin-bottom"><thead>
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
            'body'  => 'Weekly turnover: :point_l | :point_r <br> Bonus: :bonus %  <br> Amount: :amount USD <br> Output to: :to',
        ],
        'sponsor-deposit' => [
            'icon'  => 'fa-gift',
            'title' => 'Referral bonus: Package',
            'body'  => 'User: :name <br> Level : :level <br> Amount: :amount USD<br> Output to: :to',
        ],
        'sponsor-shares'  => [
            'icon'  => 'fa-gift',
            'title' => 'Referral bonus: Shares',
            'body'  => 'User: :name <br> Level : :level <br> Amount: :amount USD<br> Output to: :to',
        ],
        'rank'            => [
            'icon'  => 'fa-gift',
            'title' => 'Bonus for new rank',
            'body'  => 'Rank: :rank<br> Amount: :amount USD<br> Output to: :to',
        ],
    ],
    'requests'  => [
        'replenishment'       => [
            'icon'  => 'fa-money',
            'title' => 'Replenishment',
            'body'  => 'Amount: :amount USD<br> Type balance: :method <br> Type balance: :method',
        ],
        'withdraw-processing' => [
            'icon'  => 'fa-btc',
            'title' => 'Withdraw',
            'body'  => 'Amount: :amount USD<br> Wallet Address: :wallet_address <br> Withdraw: :method => :to',
        ],
        'withdraw-success'    => [
            'icon'  => 'fa-btc',
            'title' => 'Withdraw: success',
            'body'  => 'ID: :id <br> Amount: :amount USD<br> Output to: :to<br> Txid: :tx',
        ],
        'withdraw-rejection'  => [
            'icon'  => 'fa-btc',
            'title' => 'Withdraw: rejection',
            'body'  => 'ID: :id <br> Amount: :amount USD<br> Output to: :to',
        ],
    ],
];
