<?php

Route::get('administrator/o38oRuD745/sign_in', 'Administrator\Auth\LoginController@showLoginForm')->name('login');
Route::post('administrator/o38oRuD745/sign_in', 'Administrator\Auth\LoginController@login')->name('login.post');

//Route::get('register', 'Administrator\Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Administrator\Auth\RegisterController@register')->name('register.post');
//
//Route::post('password/email', 'Administrator\Auth\ForgotPasswordController@sendResetLinkEmail');
//Route::post('password/reset', 'Administrator\Auth\ResetPasswordController@reset');
//Route::get('password/reset', 'Administrator\Auth\ForgotPasswordController@showLinkRequestForm');
//Route::get('password/reset/{token}', 'Administrator\Auth\ResetPasswordController@showResetForm');
//

Route::group([
    'prefix'     => 'administrator/o38oRuD745',
    'middleware' => [
        'auth:administrator',
    ],
], function () {
    Route::match(['get', 'post'], 'logout', 'Administrator\Auth\LoginController@logout')->name('logout');

    Route::get('/', 'Administrator\DashboardController@index')->name('dashboard');

    Route::group([
        'prefix' => 'users',
        'as'     => 'users.',
    ], function () {
        Route::get('/', 'Administrator\UsersController@index')->name('index');
        Route::get('/{id}', 'Administrator\UsersController@show')->name('show');
        Route::post('update', 'Administrator\UsersController@update')->name('update');
        Route::post('send_notice', 'Administrator\UsersController@send_notice')->name('send_notice');
        Route::get('remove_social_account/{provider}/{id}', 'Administrator\UsersController@remove_social_account')->name('remove_social_account');
    });

    Route::group([
        'prefix' => 'replenishments',
        'as'     => 'replenishments.',
    ], function () {
        Route::get('/{user_id?}', 'Administrator\ReplenishmentsController@index')->name('index');
        Route::post('replenish/{user}', 'Administrator\ReplenishmentsController@replenish')->name('replenish');
        Route::post('subtract/{user}', 'Administrator\ReplenishmentsController@subtract')->name('subtract');
    });

    Route::group([
        'prefix' => 'withdraws',
        'as'     => 'withdraws.',
    ], function () {
        Route::get('/{user_id?}', 'Administrator\WithdrawsController@index')->name('index');
        Route::get('payout/{id}/{tx}', 'Administrator\WithdrawsController@payout')->name('payout');
        Route::get('rejection/{id}', 'Administrator\WithdrawsController@rejection')->name('rejection');
    });

    Route::group([
        'prefix' => 'transfers',
        'as'     => 'transfers.',
    ], function () {
        Route::get('/{user_id?}', 'Administrator\TransfersController@index')->name('index');
        Route::get('have/{user_id?}', 'Administrator\TransfersController@have')->name('have');
    });

    Route::group([
        'prefix' => 'exchanges',
        'as'     => 'exchanges.',
    ], function () {
        Route::get('/{user_id?}/{from_method?}', 'Administrator\ExchangesController@index')->name('index');
    });

    Route::group([
        'prefix' => 'deposits',
        'as'     => 'deposits.',
    ], function () {
        Route::get('/{user_id?}', 'Administrator\DepositsController@index')->name('index');
        Route::get('update', 'Administrator\DepositsController@update')->name('update');
        Route::post('update/percent', 'Administrator\DepositsController@updatePercent')->name('update.percent.post');
        Route::get('closed/{deposit}', 'Administrator\DepositsController@closed')->name('closed');
    });

    Route::group([
        'prefix' => 'shares',
        'as'     => 'shares.',
    ], function () {
        Route::get('/{user_id?}', 'Administrator\SharesController@index')->name('index');
    });

    Route::group([
        'prefix' => 'charities',
        'as'     => 'charities.',
    ], function () {
        Route::get('/{user_id?}', 'Administrator\CharitiesController@index')->name('index');
    });

    Route::group([
        'prefix' => 'rewards',
        'as'     => 'rewards.',
    ], function () {
        Route::get('/{user_id?}', 'Administrator\RewardsController@index')->name('index');
    });

    Route::group([
        'prefix' => 'issues',
        'as'     => 'issues.',
    ], function () {
        Route::get('/new', 'Administrator\IssuesController@showNew')->name('new');
        Route::post('new', 'Administrator\IssuesController@created');
        Route::get('/{status?}', 'Administrator\IssuesController@index')->name('index');
        Route::get('dialog/{id}', 'Administrator\IssuesController@dialog')->name('dialog');
        Route::post('dialog/{id}', 'Administrator\IssuesController@send');
        Route::get('dialog/closed/{id}', 'Administrator\IssuesController@closed')->name('closed');
    });

    Route::get('notification', 'Administrator\NotificationController@show')->name('notification');
    Route::group([
        'prefix' => 'settings',
        'as'     => 'settings.',
    ], function () {
        Route::get('/', 'Administrator\SettingsController@index')->name('index');
        Route::get('up', 'Administrator\SettingsController@up')->name('up');
        Route::get('down', 'Administrator\SettingsController@down')->name('down');
    });

    Route::group([
        'prefix' => 'changelog',
        'as'     => 'changelog.',
    ], function () {
        Route::get('/', 'Administrator\ChangelogController@index')->name('index');
        Route::get('add', 'Administrator\ChangelogController@add')->name('add');
        Route::post('add', 'Administrator\ChangelogController@addPost')->name('add.post');
        Route::get('active/{id}', 'Administrator\ChangelogController@active')->name('active');
        Route::get('remove/{id}', 'Administrator\ChangelogController@remove')->name('remove');
    });

    Route::group([
        'prefix' => 'ico',
        'as'     => 'ico.',
    ], function () {
        Route::get('/{user_id?}', 'Administrator\InitialCoinOfferingController@index')->name('index');
    });

    Route::group([
        'prefix' => 'news',
        'as'     => 'posts.',
    ], function () {
        Route::get('/', 'Administrator\PostsController@index')->name('index');
        Route::get('create', 'Administrator\PostsController@create')->name('create');
        Route::post('/', 'Administrator\PostsController@store')->name('store');
        Route::get('/{post}/edit', 'Administrator\PostsController@edit')->name('edit');
        Route::patch('/{post}', 'Administrator\PostsController@update')->name('update');
        Route::get('destroy/{post}', 'Administrator\PostsController@destroy')->name('destroy');
    });
    Route::group([
        'prefix' => 'verifications',
        'as'     => 'verifications.',
    ], function () {
        Route::get('/{status?}/{user_id?}', 'Administrator\VerificationController@index')->name('index');
        Route::get('/verified/{id}/{verified}', 'Administrator\VerificationController@verified')->name('verified');
    });

    Route::group([
        'prefix' => 'trading',
        'as'     => 'trading.',
    ], function () {
        Route::get('/{user_id?}', 'Administrator\TradingController@index')->name('index');
        Route::get('update', 'Administrator\TradingController@update')->name('update');
        Route::get('closed/{trading}', 'Administrator\TradingController@closed')->name('closed');
        Route::post('update/percent', 'Administrator\TradingController@updatePercent')->name('update.percent.post');
    });

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});
