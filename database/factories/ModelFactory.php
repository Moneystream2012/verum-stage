<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Administrator::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => bcrypt($faker->password),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Amount::class, function (Faker\Generator $faker) {
    return [
        'type'   => $faker->word,
        'amount' => $faker->randomFloat(),
    ];
});

$factory->define(App\Charity::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'method'  => $faker->word,
        'amount'  => $faker->randomFloat(),
    ];
});

$factory->define(App\Count::class, function (Faker\Generator $faker) {
    return [
        'type'  => $faker->word,
        'count' => $faker->randomNumber(),
    ];
});

$factory->define(App\Deposit::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'plan'        => $faker->boolean,
        'number_of'         => $faker->boolean,
        'profit'            => $faker->randomFloat(),
        'withdrawal_amount' => $faker->randomFloat(),
        'active'            => $faker->boolean,
        'withdrawal_at'     => $faker->dateTimeBetween(),
        'calculate_at'      => $faker->dateTimeBetween(),
        'final_at'          => $faker->dateTimeBetween(),
    ];
});

$factory->define(App\Exchange::class, function (Faker\Generator $faker) {
    return [
        'user_id'     => $faker->randomNumber(),
        'from_method' => $faker->word,
        'to_method'   => $faker->word,
        'amount'      => $faker->randomFloat(),
    ];
});

$factory->define(App\History::class, function (Faker\Generator $faker) {
    return [
        'user_id'  => $faker->randomNumber(),
        'type'     => $faker->word,
        'category' => $faker->boolean,
        'data'     => $faker->text,
    ];
});

$factory->define(App\Issue::class, function (Faker\Generator $faker) {
    return [
        'title'   => $faker->word,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'support_id'   => $faker->randomNumber(),
        'support_type' => $faker->word,
        'status'       => $faker->boolean,
    ];
});

$factory->define(App\IssueDialog::class, function (Faker\Generator $faker) {
    return [
        'issue_id'   => $faker->randomNumber(),
        'is_support' => $faker->boolean,
        'read'       => $faker->boolean,
        'body'       => $faker->text,
    ];
});

$factory->define(App\Replenishment::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'method'      => $faker->word,
        'to'          => $faker->word,
        'amount'      => $faker->randomFloat(),
        'cost_amount' => $faker->randomFloat(),
        'status'      => $faker->boolean,
        'done_at'     => $faker->dateTimeBetween(),
    ];
});

$factory->define(App\Share::class, function (Faker\Generator $faker) {
    return [
        'user_id'   => $faker->randomNumber(),
        'method'    => $faker->word,
        'number_of' => $faker->randomNumber(),
        'amount'    => $faker->randomFloat(),
        'price'     => $faker->randomFloat(),
        'is_refund' => $faker->boolean,
    ];
});

$factory->define(App\SocialAccount::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'provider_user_id' => $faker->word,
        'provider'         => $faker->word,
    ];
});

$factory->define(App\Transfer::class, function (Faker\Generator $faker) {
    return [
        'user_id'       => $faker->randomNumber(),
        'to_id'         => $faker->randomNumber(),
        'from_username' => $faker->word,
        'to_username'   => $faker->word,
        'amount'        => $faker->randomFloat(),
        'cost_amount'   => $faker->randomFloat(),
    ];
});

$factory->define(App\Turnover::class, function (Faker\Generator $faker) {
    return [
        'user_id'     => $faker->randomNumber(),
        'level'       => $faker->boolean,
        'total_left'  => $faker->randomFloat(),
        'total_right' => $faker->randomFloat(),
        'total'       => $faker->randomFloat(),
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'username'             => $faker->userName,
        'sponsor_id'           => $faker->randomNumber(),
        'leg'                  => $faker->boolean,
        'side_leg'             => $faker->boolean,
        'rank'                 => $faker->boolean,
        'active'               => $faker->boolean,
        'balance'              => $faker->randomFloat(),
        'mining_balance'  => $faker->randomFloat(),
        'verified_email'       => $faker->boolean,
        'token_email'          => $faker->word,
        'first_name'           => $faker->firstName,
        'last_name'            => $faker->lastName,
        'email'                => $faker->safeEmail,
        'mobile_number'        => $faker->word,
        'country'              => $faker->country,
        'avatar'               => $faker->word,
        'password'             => bcrypt($faker->password),
        'transaction_password' => $faker->word,
        'settings'             => $faker->text,
        'last_login_at'        => $faker->dateTimeBetween(),
        'active_at'            => $faker->dateTimeBetween(),
        'remember_token'       => str_random(10),
    ];
});

$factory->define(App\Withdraw::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'from_method' => $faker->word,
        'to_method'   => $faker->word,
        'amount'      => $faker->randomFloat(),
        'cost_amount' => $faker->randomFloat(),
        'status'      => $faker->boolean,
        'done_at'     => $faker->dateTimeBetween(),
    ];
});
