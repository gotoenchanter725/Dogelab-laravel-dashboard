<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/cron', 'CronController@runCron')->name('cron');
Route::post('ipn/coinpayment.deposit', 'PaymentController@ipnDeposit')->name('ipn.coinpayment.deposit');

/*
|--------------------------------------------------------------------------
| Start Admin Area
|--------------------------------------------------------------------------
*/

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::post('/', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');
        // Admin Password Reset
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify-code');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.change-link');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
    });

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
        Route::get('profile', 'AdminController@profile')->name('profile');
        Route::post('profile', 'AdminController@profileUpdate')->name('profile.update');
        Route::get('password', 'AdminController@password')->name('password');
        Route::post('password', 'AdminController@passwordUpdate')->name('password.update');

        Route::get('notification/read/{id}','AdminController@notificationRead')->name('notification.read');
        Route::get('notifications','AdminController@notifications')->name('notifications');


        //Report Bugs
        Route::get('request-report','AdminController@requestReport')->name('request.report');
        Route::post('request-report','AdminController@reportSubmit');

        Route::get('system-info','AdminController@systemInfo')->name('system.info');


        // Account

        Route::name('account.')->prefix('account')->group(function(){
            Route::get('all', 'ManageAccountController@index')->name('index');
            Route::get('active', 'ManageAccountController@active')->name('active');
            Route::get('banned', 'ManageAccountController@banned')->name('banned');
            Route::get('referred', 'ManageAccountController@referred')->name('referred');
            Route::get('single/{id}', 'ManageAccountController@single')->name('single');
            Route::post('action/{id}', 'ManageAccountController@action')->name('action');
            Route::get('deposits/{id}', 'ManageAccountController@deposits')->name('deposits');
            Route::get('withdrawals/{id}', 'ManageAccountController@withdrawals')->name('withdrawals');
        });




        // Deposit Gateway
        Route::name('gateway.')->prefix('gateway')->group(function(){
            // Automatic Gateway
            Route::get('deposit', 'GatewayController@deposit')->name('deposit');
            Route::get('withdraw', 'GatewayController@withdraw')->name('withdraw');

            Route::post('store/{gateway}', 'GatewayController@update')->name('update');
        });


        // DEPOSIT SYSTEM
        Route::name('deposit.')->prefix('deposit')->group(function(){
            Route::get('/', 'ManageDepositController@index')->name('index');
            Route::get('/search', 'ManageDepositController@depositSearch')->name('search');
            Route::get('date-search/', 'ManageDepositController@dateSearch')->name('dateSearch');

        });

        Route::get('miningtracks', 'ManageDepositController@miningTracks')->name('mining.track');
        Route::get('referral-bonus/log', 'ManageAccountController@referralLog')->name('referral.log');



        // WITHDRAW SYSTEM
        Route::name('withdraw.')->prefix('withdrawals')->group(function(){
            Route::get('/', 'ManageWithdrawalController@index')->name('index');
            Route::get('search', 'ManageWithdrawalController@search')->name('search');
            Route::get('date-search', 'ManageWithdrawalController@dateSearch')->name('dateSearch');
        });


        // Mining Tracks

        // Language Manager
        Route::get('/language', 'LanguageController@langManage')->name('language.manage');
        Route::post('/language', 'LanguageController@langStore')->name('language.manage.store');
        Route::post('/language/delete/{id}', 'LanguageController@langDel')->name('language.manage.del');
        Route::post('/language/update/{id}', 'LanguageController@langUpdatepp')->name('language.manage.update');
        Route::get('/language/edit/{id}', 'LanguageController@langEdit')->name('language.key');
        Route::post('/language/import', 'LanguageController@langImport')->name('language.import_lang');



        Route::post('language/store/key/{id}', 'LanguageController@storeLanguageJson')->name('language.store.key');
        Route::post('language/delete/key/{id}', 'LanguageController@deleteLanguageJson')->name('language.delete.key');
        Route::post('language/update/key/{id}', 'LanguageController@updateLanguageJson')->name('language.update.key');



        // General Setting
        Route::get('general-setting', 'GeneralSettingController@index')->name('setting.index');
        Route::post('general-setting', 'GeneralSettingController@update')->name('setting.update');

        Route::get('optimize', 'GeneralSettingController@optimize')->name('setting.optimize');

        // Logo-Icon
        Route::get('setting/logo-icon', 'GeneralSettingController@logoIcon')->name('setting.logo_icon');
        Route::post('setting/logo-icon', 'GeneralSettingController@logoIconUpdate')->name('setting.logo_icon');

        //Custom CSS
        Route::get('custom-css','GeneralSettingController@customCss')->name('setting.custom.css');
        Route::post('custom-css','GeneralSettingController@customCssSubmit');


        // Plugin
        Route::get('extensions', 'ExtensionController@index')->name('extensions.index');
        Route::post('extensions/update/{id}', 'ExtensionController@update')->name('extensions.update');
        Route::post('extensions/activate', 'ExtensionController@activate')->name('extensions.activate');
        Route::post('extensions/deactivate', 'ExtensionController@deactivate')->name('extensions.deactivate');

        //Cookie
        Route::get('cookie','GeneralSettingController@cookie')->name('setting.cookie');
        Route::post('cookie','GeneralSettingController@cookieSubmit');


        // Email Setting
        Route::get('email-template/global', 'EmailTemplateController@emailTemplate')->name('email.template.global');
        Route::post('email-template/global', 'EmailTemplateController@emailTemplateUpdate')->name('email.template.global');

        Route::get('email-template/setting', 'EmailTemplateController@emailSetting')->name('email.template.setting');

        Route::post('email-template/setting', 'EmailTemplateController@emailSettingUpdate')->name('email.template.setting');

        Route::get('email-template/index', 'EmailTemplateController@index')->name('email.template.index');
        Route::get('email-template/{id}/edit', 'EmailTemplateController@edit')->name('email.template.edit');
        Route::post('email-template/{id}/update', 'EmailTemplateController@update')->name('email.template.update');
        Route::post('email-template/send-test-mail', 'EmailTemplateController@sendTestMail')->name('email.template.sendTestMail');

        // SEO
        Route::get('seo', 'FrontendController@seoEdit')->name('seo');


        // Frontend
        Route::name('frontend.')->prefix('frontend')->group(function () {

            Route::get('templates', 'FrontendController@templates')->name('templates');
            Route::post('templates', 'FrontendController@templatesActive')->name('templates.active');

            Route::get('frontend-sections/{key}', 'FrontendController@frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'FrontendController@frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'FrontendController@frontendElement')->name('sections.element');
            Route::post('remove', 'FrontendController@remove')->name('remove');

            // Page Builder
            Route::get('manage-pages', 'PageBuilderController@managePages')->name('manage.pages');

            Route::post('manage-pages/update', 'PageBuilderController@managePagesUpdate')->name('manage.pages.update');
            Route::post('manage-pages/delete', 'PageBuilderController@managePagesDelete')->name('manage.pages.delete');
            Route::get('manage-section/{id}', 'PageBuilderController@manageSection')->name('manage.section');
            Route::post('manage-section/{id}', 'PageBuilderController@manageSectionUpdate')->name('manage.section.update');
        });
    });
});



/*
|--------------------------------------------------------------------------
| Start Account Area
|--------------------------------------------------------------------------
*/



Route::name('account.')->prefix('account')->group(function () {

    Route::post('login', 'AccountController@login')->name('login');
    Route::get('/logout', 'AccountController@logout')->name('logout');

    Route::middleware('account')->group(function () {
        Route::get('dashboard', 'AccountController@home')->name('home');

        Route::get('deposit', 'AccountController@deposit')->name('deposit');
        Route::post('deposit', 'PaymentController@depositWallet')->name('deposit');

        Route::get('deposit/test', 'PaymentController@depositWallet');

        Route::get('withdraw', 'AccountController@withdraw')->name('withdraw');
        Route::post('withdraw', 'PaymentController@withdrawMoney')->name('withdraw');

        Route::get('/my-referrals', 'AccountController@myReferrals')->name('referrals');

        Route::get('/ref/{username?}', 'AccountController@referredUser')->name('invite');
    });

});


Route::get('/contact', 'SiteController@contact')->name('contact');
Route::post('/contact', 'SiteController@contactSubmit')->name('contact.send');
Route::get('/change/{lang?}', 'SiteController@changeLanguage')->name('lang');

Route::get('blogs', 'SiteController@blogs')->name('blogs');
Route::get('blog/{id}/{slug}', 'SiteController@blogDetails')->name('blog.details');

Route::get('/cookie/accept', 'SiteController@cookieAccept')->name('cookie.accept');

Route::get('placeholder-image/{size}', 'SiteController@placeholderImage')->name('placeholderImage');

Route::get('/{id}/{slug}', 'SiteController@page')->name('page');
Route::get('/', 'SiteController@index')->name('home');
