<?php


Route::get('/', array(
            'as' => 'home',
            'uses' => 'HomeController@home'
));

//authenticated group
Route::group(array('before' => 'auth'), function(){

        //csrf protection group
            Route::group(array('before' => 'csrf'), function(){

               Route::post('/donation/add-donation-manual', array(
                    'as' => 'donation-add-manual-post',
                    'uses' => 'DonationController@postManualAdd'
                ));

               Route::post('/balanced/create-account', array(
                    'as' => 'balanced-create-account-post',
                    'uses' => 'BalancedController@postCreateAccount'
                ));

                Route::post('/account/settings',array(
                    'as' => 'account-settings-post',
                    'uses' => 'AccountController@postChangeSettings'
                ));
                Route::post('/account/create-account',array(
                    'as' => 'create-account-post',
                    'uses' => 'AccountController@postCreate'
                ));
                Route::post('/account/account-general-settings', array(
                    'as' => 'account-general-settings-post',
                    'uses' => 'AccountController@postChangeGeneralSettings'
                ));
                Route::post('/account/account-change-icon', array(
                    'as' => 'account-change-icon-post',
                    'uses' => 'AccountController@postChangeIcon'
                ));
                Route::post('/account/account-add-fund', array(
                    'as' => 'account-add-fund-post',
                    'uses' => 'AccountController@postAddFund'
                ));
                Route::post('/account/account-remove-fund', array(
                    'as' => 'account-remove-fund-post',
                    'uses' => 'AccountController@postRemoveFund'
                ));
                Route::post('/account/account-financial-settings', array(
                    'as' => 'account-financial-settings-post',
                    'uses' => 'AccountController@postChangeFinancialSettings'
                ));
                Route::post('/account/account-communication-settings', array(
                    'as' => 'account-communication-settings-post',
                    'uses' => 'AccountController@postChangeCommunicationSettings'
                ));
                Route::post('/account/account-payment-settings', array(
                    'as' => 'account-payment-settings-post',
                    'uses' => 'AccountController@postChangePaymentSettings'
                ));

                Route::post('/balanced/create-bank-account', array(
                    'as' => 'balanced-create-bank-account-post',
                    'uses' => 'AccountController@postCreateBankAccount'
                ));
                Route::post('/balanced/submit-account-verification', array(
                    'as' => 'balanced-submit-account-verification-post',
                    'uses' => 'AccountController@postSubmitAccountVerification'
                ));

                Route::post('/user/user-change-password', array(
                    'as' => 'user-change-password-post',
                    'uses' => 'UserController@postChangePassword'
                ));

                Route::post('/user/user-change-email', array(
                    'as' => 'user-change-email-post',
                    'uses' => 'UserController@postChangeEmail'
                ));

                Route::post('/user/user-change-info', array(
                    'as' => 'user-change-info-post',
                    'uses' => 'UserController@postChangeInfo'
                ));

                Route::post('/user/user-change-financial-settings', array(
                    'as' => 'user-change-financial-settings-post',
                    'uses' => 'UserController@postChangeFinancialSettings'
                ));

                Route::post('/user/user-search', array(
                    'as' => 'user-user-search',
                    'uses' => 'UserController@postUserList'
                ));

                Route::post('/user/user-change-icon', array(
                    'as' => 'user-change-icon-post',
                    'uses' => 'UserController@postChangeIcon'
                ));

                Route::post('/user/add-user-manual', array(
                    'as' => 'user-add-user-manual-post',
                    'uses' => 'UserController@postAddUser'
                ));

                Route::post('/user/user-list-post', array(
                    'as' => 'user-list-post',
                    'uses' => 'UserController@postUserList'
                ));  

            });

       Route::get('/donation/list-donations', array(
            'as' => 'donation-list-donations',
            'uses' => 'DonationController@getDonationList'
        ));

       Route::get('/account/change-settings', array(
            'as' => 'account-change-settings',
            'uses' => 'AccountController@getChangeSettings'
        ));

       Route::get('/account/dashboard', array(
            'as' => 'account-dashboard',
            'uses' => 'AccountController@getDashboard'
        ));

       Route::get('/account/funds-list', array(
            'as' => 'funds-list',
            'uses' => 'AccountController@getFundList'
        ));

       Route::get('/account/create-account', array(
            'as' => 'create-account',
            'uses' => 'AccountController@getCreate'
        ));

        Route::get('/user/user-list', array(
            'as' => 'user-list',
            'uses' => 'UserController@getUserList'
        ));  

        Route::get('/user/profile/{username}', array(
            'as' => 'user-view-profile',
            'uses' => 'UserController@getUserProfile'
        )); 

        Route::get('/user/sign-out', array(
            'as' => 'sign-out',
            'uses' => 'UserController@getSignOut'
        ));  

        Route::get('/user/change-settings', array(
            'as' => 'user-change-settings',
            'uses' => 'UserController@getChangeSettings'
        ));

        Route::get('/user/add-user-manual', array(
            'as' => 'user-add-user-manual',
            'uses' => 'UserController@getAddUser'
        ));

});

//UNauthenticated group
Route::group(array('before' => 'guest'), function() {

        //csrf protection group
        Route::group(array('before' => 'csrf'), function() {

                //create user (post)
                Route::post('/user/create', array(
                    'as' => 'user-create-post',
                    'uses' => 'UserController@postCreate'
                ));

                //sign-in (post)
                Route::post('/user/sign-in', array(
                    'as' => 'user-sign-in-post',
                    'uses' => 'UserController@postSignIn'
                ));

        });

            Route::get('/form/{subdomain}', array(
                'as' => 'form-subdomain',
                'uses' => 'UserController@getIframe'
            )); 

            //create user (get)
            Route::get('/user/create', array(
                'as' => 'user-create',
                'uses' => 'UserController@getCreate'
            )); 

        	//sign-in (get)
        	Route::get('/user/sign-in', array(
                'as' => 'user-sign-in',
                'uses' => 'UserController@getSignIn'
        	)); 

});


