<?php

return [
    'payments'  => [
        'deposit'       => [
            'icon'  => 'fa-briefcase',
            'title' => 'Платежный продукт: Инвестиционный Токен',
            'body'  => 'Сумма: :amount USD</br> Имя: :name <br>Метод платежа: :method',
        ],
        'active_member' => [
            'icon'  => 'fa-user',
            'title' => 'Активация на год',
            'body'  => 'Сумма: :amount USD</br> Активировано до: :active_at <br>Метод платежа: :method',
        ],
        'shares'        => [
            'icon'  => 'fa-file-text',
            'title' => 'Покупка акций',
            'body'  => 'Сумма: :amount USD</br> Количество: :number_of <br>Метод платежа: :method',
        ],
    ],
    'transfers' => [
        'deposit'          => [
            'icon'  => 'fa-briefcase',
            'title' => 'Вывод из пакета',
            'body'  => 'Пакет №: :id <br> Сумма: :amount USD<br> Выведено на: :to',
        ],
        'shares'           => [
            'icon'  => 'fa-files-o',
            'title' => 'Продажа акций',
            'body'  => 'Количество: :number_of <br> Сумма: :amount USD<br> Выведено на: :to',
        ],
        'user_from-amount' => [
            'icon'  => 'fa-exchange',
            'title' => 'Перевод пользователю',
            'body'  => 'Пользователь: :username <br> Сумма: :amount USD<br> Комиссия: :cost_amount USD<br> Тип баланса: :method',
        ],
        'user_to-amount'   => [
            'icon'  => 'fa-exchange',
            'title' => 'Перевод от пользователя',
            'body'  => 'Пользователь: :username <br> Сумма: :amount USD<br> Тип баланса: :method',
        ],
        'exchange'         => [
            'icon'  => 'fa-random',
            'title' => 'Обмен',
            'body'  => 'Обмен: :method => :to <br> Сумма: :amount USD',
        ],
        'charities'        => [
            'icon'  => 'fa-heart',
            'title' => 'Благотворительность',
            'body'  => 'Сумма: :amount USD<br> Метод: :method',
        ],

    ],
    'profits'   => [
        'deposit'         => [
            'icon'  => 'fa-briefcase',
            'title' => 'Продукт выплат: инвестиционный токен',
            'body'  => 'ID : :id <br>Имя : :name <br> Количество: :number_of <br> Процентов в месяц: :percent %<br> Сумма: :amount USD<br> Выведено на: :to',
        ],
        'direct'          => [
            'icon'  => 'fa-gift',
            'title' => 'Подсчитанный бонус: Прямой',
            'body'  => 'Бонус: :bonus % <br> Сумма: :amount USD<br> Выведено на: :to',
        ],
        'compute_rewards' => [
            'icon'  => 'fa-gift',
            'title' => 'Начисленные вознаграждения',
            'body'  => '
                <span class="">Начисление  №:number_of</span>
                <table class="table no-margin-bottom"><thead>
                <tr>
                 <th>Тип</th>
                  <th>Еженедельный оборот</th>
                  <th>%</th>
                  <th>Выведено на</th>
                  <th>Сумма</th>
                </tr></thead><tbody>
                <tr>
                  <td>Бинарный бонус</td>
                  <td>:binary-point_left | :binary-point_right</td>
                  <td>:binary-bonus</td>
                  <td>:binary-to</td>
                  <td>:binary-amount USD</td>
                </tr>
                <tr>
                  <td>Прямой бонус</td>
                  <td>:direct-reward</td>
                  <td>:direct-bonus</td>
                  <td>:direct-to</td>
                  <td>:direct-amount USD</td>
                </tr>
            </tbody></table>',
        ],
        'binary'          => [
            'icon'  => 'fa-gift',
            'title' => 'Подсчитанный бонус: Бинарный',
            'body'  => 'Еженедельный оборот: :point_l | :point_r <br> Бонус: :bonus %  <br> Сумма: :amount USD <br> Выведено на: :to',
        ],
        'sponsor-deposit' => [
            'icon'  => 'fa-gift',
            'title' => 'Реферальный бонус: Пакет',
            'body'  => 'User: :name <br> Level : :level <br> Сумма: :amount USD<br> Выведено на: :to',
        ],
        'sponsor-shares'  => [
            'icon'  => 'fa-gift',
            'title' => 'Реферальный бонус: Акции',
            'body'  => 'Пользователь: :name <br> Уровень : :level <br> Сумма: :amount USD<br> Выведено на: :to',
        ],
        'rank'            => [
            'icon'  => 'fa-gift',
            'title' => 'Бонус за новый ранг',
            'body'  => 'Ранг: :rank<br> Сумма: :amount USD<br> Выведено на: :to',
        ],
    ],
    'requests'  => [
        'replenishment'       => [
            'icon'  => 'fa-money',
            'title' => 'Пополнение',
            'body'  => 'Сумма: :amount USD<br> Тип баланса: :method <br> Тип баланса: :method',
        ],
        'withdraw-processing' => [
            'icon'  => 'fa-btc',
            'title' => 'Withdraw',
            'body'  => 'Сумма: :amount USD<br> Адрес кошелька: :wallet_address <br> Снятие: :method => :to',
        ],
        'withdraw-success'    => [
            'icon'  => 'fa-btc',
            'title' => 'Снятие: успешно',
            'body'  => 'ID: :id <br> Сумма: :amount USD<br> Выведено на: :to<br> Txid: :tx',
        ],
        'withdraw-rejection'  => [
            'icon'  => 'fa-btc',
            'title' => 'Снятие: отклонено',
            'body'  => 'ID: :id <br> Сумма: :amount USD<br> Выведено на: :to',
        ],
    ],
];
