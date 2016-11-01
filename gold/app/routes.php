<?php
/*
|**************************************** HOME PAGE ROUTES **************************************************************************|
*/	
		//Index Route
		Route::get('/',array('uses'=>'HomeController@index'));
		
		//How-to Route
		Route::get('/how-it-works',array('uses'=>'HomeController@howItWorks'));

		//About route
		Route::get('/about-us',array('uses'=>'HomeController@aboutUs'));

		//contact Route
		Route::get('/contact-us',array('uses'=>'HomeController@contactUs'));

		//Register View
		Route::get('/register', array('uses'=>'HomeController@registerView'));

		//Process register
		Route::post('/register',array('uses'=>'HomeController@register'));

		//After registration is complete (success message)
		Route::get('/register/success',array('uses'=>'HomeController@registerSuccess'));

		//login View
		Route::get('/login',array('uses'=>'HomeController@loginView'));

		//processing login
		Route::post('/login',array('uses'=>'HomeController@logIn'));

		//processing log_out
		Route::get('/log-out',array('uses'=>'HomeController@logOut'));

		//privacy policy Route
		Route::get('/privacy-policy',array('uses'=>'HomeController@privacyPolicy'));

		//terms and condition Route
		Route::get('/terms-and-conditions',array('uses'=>'HomeController@termsCondition'));

		//Password recovery View
		Route::get('/login/password-recovery',array('uses'=>'HomeController@passwordRecovery'));

		//Password recovery Check token
		Route::get('/login/token/check',array('uses'=>'HomeController@checkToken'));

		//Password recovery generate Token
		Route::post('/login/password-recovery',array('uses'=>'HomeController@getToken'));

		//Password recovery Change password View
 		Route::get('/login/password-recovery/new-password',array('uses'=>'HomeController@newPasswordView'));

		//Password recovery Change password
		Route::post('/login/password-recovery/new-password',array('uses'=>'HomeController@newPassword'));

		//Password recovery status
		Route::get('/login/password-recovery/status',array('uses'=>'HomeController@recoveryStatus'));

		Route::get('/sitemap',array('uses'=>'HomeController@sitemap'));

		Route::get('/robots',array('uses'=>'HomeController@robots'));

/*
|******************************************UTILITY ROUTES***********************************************************************|
*/
		//Currency drop down
		Route::get('/utility/currency-drop-down',array('uses'=>'HomeController@getCurrencyDropDown'));

		//Banks drop down
		Route::get('/utility/get-banks',array('uses'=>'HomeController@getBanks'));

/*
|**************************************** USER ROUTES **************************************************************************|
*/

		//Summary View
		Route::get('/users/summary',array('uses'=>'UserController@summary'));

		//Buy and Sell View
		Route::get('/users/exchange-currencies',array('uses'=>'UserController@buySellView'));

		//Buy - post
		Route::post('/users/exchange-currencies/buy',array('uses'=>'UserController@buy'));

		//Sell - post
		Route::post('/users/exchange-currencies/sell',array('uses'=>'UserController@sell'));

		//Transactions View
		Route::get('/users/transactions',array('uses'=>'UserController@transactions'));

		//Transaction view
		Route::get('/users/transactions/{id}',array('uses'=>'UserController@viewTransaction'))->where(array('id'=>'[0-9]+'));

		//Settings view
		Route::get('/users/settings',array('uses'=>'UserController@userSettingsView'));

		//Edit Bio Data - post
		Route::post('/users/settings/info',array('uses'=>'UserController@editInfo'));

		//Edit Password - Post
		Route::post('/users/settings/password',array('uses'=>'UserController@editPassword'));

		//Edit e-currency - Post
		Route::post('/users/settings/e-wallets',array('uses'=>'UserController@editECurrencies'));

		//Edit bank account - Post
		Route::post('/users/settings/bank-details',array('uses'=>'UserController@editBankDetails'));


/*
|**************************************** ADMIN ROUTES **************************************************************************|
*/

		//Summary
		Route::get('/admin/summary',array('uses'=>'AdminController@summary'));

		//Transactions View
		Route::get('/admin/transactions/',array('uses'=>'AdminController@transactions'));

		//Transaction
		Route::get('/admin/transactions/{id}',array('uses'=>'AdminController@viewTransaction'))->where(array('id'=>'[0-9]+'));

		//Transaction Process - post
		Route::post('/admin/transactions/process/{id}',array('uses'=>'AdminController@editAdvert'))->where(array('id'=>'[0-9]+'));

		//Transaction Cancel - post
		Route::post('/admin/transactions/cancel/{id}',array('uses'=>'AdminController@createWorkChop'))->where(array('id'=>'[0-9]+'));

		//Users
		Route::get('/admin/users',array('uses'=>'AdminController@users'));

		//View User
		Route::get('/admin/users/{id}',array('uses'=>'AdminController@viewUser'))->where(array('id'=>'[0-9]+'));

		//User Account Status
		Route::post('/admin/users/status/',array('uses'=>'AdminController@createAdView'));

		//Reports View
		Route::get('/admin/reports/',array('uses'=>'AdminController@reports'));

		//Reports view by date
		Route::post('/admin/reports/view',array('uses'=>'AdminController@deleteAd'));

		//Config Page
		Route::get('/admin/configuration/',array('uses'=>'AdminController@configuration'));

		//Config setup - post
		Route::post('/admin/configuration/process',array('uses'=>'AdminController@configuration'));

		//Settings view
		Route::get('/admin/settings',array('uses'=>'AdminController@settings'));

		//Edit Bio Data - post
		Route::post('/admin/settings/info',array('uses'=>'AdminController@editInfo'));

		//Edit Password - Post
		Route::post('/admin/settings/password',array('uses'=>'AdminController@editPassword'));


  // *********************************************************************************************************************************


	