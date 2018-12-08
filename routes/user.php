<?php

// Authentication Routes...
Route::get('sign_in', 'User\Auth\LoginController@showLoginForm')->name('login');
Route::post('sign_in', 'User\Auth\LoginController@login')->name('login.post');

// Registration Routes...
Route::get('sign_up', 'User\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('sign_up', 'User\Auth\RegisterController@register')->name('register.post');
Route::get('{sponsor}/sign_up', 'User\Auth\RegisterController@showRegistrationForm')->name('sponsor-register');

Route::get('confirm/{token}', 'User\Auth\RegisterController@verify')->name('verify_email');

//Social Routes
//Route::get('social/{provider}', 'User\SocialController@login')->name('login.social');
//Route::get('social/callback/{provider}', 'User\SocialController@callback')->name('login.social.callback');

// Password Reset Routes...
Route::get('password/reset', 'User\Auth\ForgotPasswordController@showLinkRequestForm')->name('password-reset');
Route::post('password/email', 'User\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password-reset.post');
Route::get('password/reset/{token}', 'User\Auth\ResetPasswordController@showResetForm')->name('password-reset-token');
Route::post('password/reset', 'User\Auth\ResetPasswordController@reset')->name('password-reset-token.post');

Route::post('replenishment/callback/{method}', 'User\ReplenishmentPayController@callback')->name('replenishment.callback');
Route::any('replenishment/success/{id}', 'User\ReplenishmentPayController@success')->name('replenishment.success');
Route::any('replenishment/fail/{id}', 'User\ReplenishmentPayController@fail')->name('replenishment.fail');
Route::any('replenishment/success/freekassa', 'User\ReplenishmentPayController@success.success_freekassa')->name('replenishment.success_freekassa');
Route::any('replenishment/fail/freekassa', 'User\ReplenishmentPayController@fail.fail_freekassa')->name('replenishment.fail_freekassa');

Route::post('replenishment/study/callback', 'User\ReplenishmentStudyController@callback')->name('replenishment.study.callback');
Route::get('replenishment/study/success/{id}', 'User\ReplenishmentStudyController@success')->name('replenishment.study.success');
Route::get('replenishment/study/fail/{id}', 'User\ReplenishmentStudyController@fail')->name('replenishment.study.fail');
Route::any('replenishment/study', 'User\ReplenishmentStudyController@replenish')->name('replenishment.study.replenish');

Route::group([
    'prefix' => 'personal-office',
    'middleware' => [
        'auth:user',
        'session_timeout',
        'user_blocked',
    ],
], function () {
    Route::get('/', 'User\DashboardController@index')->name('dashboard');

    Route::match(['get', 'post'], 'logout', 'User\Auth\LoginController@logout')->name('logout');

    //Route::get('active', 'User\ProfileController@active_member')->middleware('active_member')->name('active_member');

    Route::get('send_activation', 'User\ProfileController@send_activation')->name('send_activation');

    Route::get('profile', 'User\ProfileController@index')->name('profile');
    Route::post('profile', 'User\ProfileController@update')->name('profile.update');
//  Route::get('profile/social_account/{provider}', 'User\ProfileController@remove_social_account')->name('profile.remove_social_account');

    Route::group([
        'prefix' => 'sponsored',
        'as' => 'sponsored.',
    ], function () {
//        Route::get('/{user_id?}', 'User\SponsoredController@binary')->name('binary');
//        Route::post('/', 'User\SponsoredController@search_user')->name('search_user');
        Route::get('unilevel/{user_id?}', 'User\SponsoredController@unilevel')->name('unilevel');
        Route::get('unilevel/{user_id}/ajax', 'User\SponsoredController@unilevel_ajax')->name('unilevel_ajax');
//        Route::get('full', 'User\SponsoredController@full')->name('full');
//        Route::get('new', 'User\SponsoredController@new_member')->name('new_member');
//        Route::post('new', 'User\SponsoredController@create_member')->name('new_member.post');
    });

//    Route::get('ico/telegram', 'User\InitialCoinOfferingController@showTelegram')->name('ico.telegram');
//    Route::post('ico/invest', 'User\InitialCoinOfferingController@invest')->name('ico.invest.post');

    Route::group([
        'prefix' => 'products',
        'as' => 'products.',
    ], function () {
        Route::get('deposits/USD', 'User\DepositsController@indexUsd')->name('deposits.usd');
//        Route::post('deposits/transfer', 'User\DepositsController@transfer')->name('deposits.transfer');
        Route::post('payment', 'User\DepositsController@payment')->name('deposits.payment');
    });

    Route::group([
        'prefix' => 'replenishment',
        'as' => 'replenishment.',
    ], function () {
        Route::get('/', 'User\ReplenishmentPayController@show')->name('index');
        Route::any('/pay/{replenishment}', 'User\ReplenishmentPayController@pay')->name('pay');
        Route::post('/', 'User\ReplenishmentPayController@replenish')->name('post');
    });


    Route::group([
        'prefix' => 'finance',
        'as' => 'finance.',
    ], function () {
        Route::get('withdraw', 'User\BalanceController@withdraw_show')->name('withdraw');
        Route::get('transfer', 'User\BalanceController@transfer_show')->name('transfer');
        Route::get('exchange', 'User\BalanceController@exchange_show')->name('exchange');

        Route::post('withdraw', 'User\BalanceController@withdraw')->name('withdraw.post');
        Route::post('transfer', 'User\BalanceController@transfer')->name('transfer.post');
        Route::post('exchange', 'User\BalanceController@exchange')->name('exchange.post');
    });

    Route::group([
        'prefix' => 'settings',
        'as' => 'settings.',
    ], function () {
        Route::get('/', 'User\SettingsController@index')->name('index');
        Route::get('settings/binary_side', 'User\SettingsController@binary_side')->name('binary_side');

        Route::post('payment', 'User\SettingsController@payment')->name('payment.post');
        Route::post('password', 'User\SettingsController@password')->name('password.post');
        Route::post('transaction_password', 'User\SettingsController@transaction_password')->name('transaction_password.post');
    });

    Route::group([
        'prefix' => 'issues',
        'as' => 'issues.',
    ], function () {
        Route::get('/', 'User\IssuesController@index')->name('index');
        Route::get('new', 'User\IssuesController@new')->name('new');
        Route::post('new', 'User\IssuesController@create');
        Route::get('/{id}', 'User\IssuesController@show')->name('show');
        Route::post('/{id}', 'User\IssuesController@send');
    });

//    Route::get('notification', 'User\NotificationController@show')->name('notification');
    Route::get('blocked', 'User\ProfileController@showBlocked')->name('blocked');
    Route::get('faq', 'User\FaqController@index')->name('faq');
//    Route::get('marketing', 'User\MarketingController@index')->name('marketing');
    Route::any('history', 'User\HistoryController@index')->name('history');
//    Route::get('changelog', 'User\ChangelogController@index')->name('changelog');
    Route::get('news', 'User\PostsController@index')->name('posts');
    Route::group([
        'prefix' => 'verification',
        'as' => 'verification.',
    ], function () {
        Route::get('/', 'User\VerificationController@index')->name('index');
        Route::post('/update', 'User\VerificationController@update')->name('update');
    });
    Route::group([
        'prefix' => 'trading',
        'as' => 'trading.',
    ], function () {
        Route::get('/', 'User\TradingController@index')->name('index');
        Route::post('invest', 'User\TradingController@invest')->name('invest');
    });
});
