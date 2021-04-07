<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('logout', function() {
	auth()->logout();
	return redirect()->route('login');
})->name('logout');

Route::group(['prefix' => 'auth', 'namespace' => 'App\Http\Controllers', 'middleware' => 'guest'], function() {
    Route::get('login', function() {
		return view('auth.login');
	})->name('login');

	Route::post('login', [
		'as' => 'login',
		'uses' => 'UserController@login'
	]);

	Route::get('register', function() {
		return view('auth.register');
	})->name('register');

	Route::post('register', [
		'as' => 'register',
		'uses' => 'UserController@register'
	]);

	Route::get('forgot-password', [
		'as' => 'forgot-password',
		'uses' => 'UserController@forgotPassword'
	]);

	Route::post('password-email', [
		'as' => 'password.email',
		'uses' => 'UserController@passwordEmail'
	]);

	Route::get('password-reset-form/{token}', [
		'as' => 'password.resetform',
		'uses' => 'UserController@resetPasswordForm'
	]);

	Route::post('password-reset/{token}', [
		'as' => 'password.reset',
		'uses' => 'UserController@resetPassword'
	]);

	Route::post('verification-resend-mail', [
		'as' => 'verification.resend',
		'uses' => 'UserController@resendResetPasswordEmail'
	]);
});

Route::group(['prefix' => '/', 'namespace' => 'App\Http\Controllers', 'middleware' => 'auth'], function() {
	Route::group(['prefix' => 'team'], function() {
		Route::get('join', [
			'as' => 'client.team.join',
			'uses' => 'TeamController@join'
		]);

		Route::get('add', [
			'as' => 'client.team.add',
			'uses' => 'TeamController@add'
		]);

		Route::get('create', [
			'as' => 'client.team.create',
			'uses' => 'TeamController@create'
		]);

		Route::get('view', [
			'as' => 'client.team.view',
			'uses' => 'TeamController@show'
		]);

		Route::post('store', [
			'as' => 'client.team.store.request',
			'uses' => 'TeamController@store'
		]);

		Route::post('join', [
			'as' => 'client.team.join.request',
			'uses' => 'TeamController@storeJoinMember'
		]);

		Route::post('store-mem', [
			'as' => 'client.team.storemem.request',
			'uses' => 'TeamController@storeMember'
		]);

		Route::get('renew-joincode', [
			'as' => 'client.team.renewJC',
			'uses' => 'TeamController@renewJoinCode'
		]);

		Route::post('leave', [
			'as' => 'client.team.leave.request',
			'uses' => 'TeamController@leave'
		]);

		Route::post('destroy', [
			'as' => 'client.team.destroy.request',
			'uses' => 'TeamController@destroy'
		]);

		Route::post('change-team-name', [
			'as' => 'client.team.changename.request',
			'uses' => 'TeamController@changeTeamName'
		]);

		Route::post('destroy-mem', [
			'as' => 'client.team.desMember.request',
			'uses' => 'TeamController@destroyMember'
		]);

		Route::get('get-destroy-team-md', [
			'as' => 'client.team.destroymd',
			'uses' => 'TeamController@getDestroyTeamModal'
		]);

		Route::get('get-chgcl-md', [
			'as' => 'client.team.chgclmd',
			'uses' => 'TeamController@getChgColorModal'
		]);

		Route::get('get-chgbg-md', [
			'as' => 'client.team.chgbgmd',
			'uses' => 'TeamController@getChgBgModal'
		]);	

		Route::get('get-chgname-md', [
			'as' => 'client.team.chgnamemd',
			'uses' => 'TeamController@getChgNameModal'
		]);	

		Route::get('get-leavetm-md', [
			'as' => 'client.team.leavemd',
			'uses' => 'TeamController@getLeaveTeamModal'
		]);	

		Route::get('get-desmem-md', [
			'as' => 'client.team.destroymem',
			'uses' => 'TeamController@getDestroyMemModal'
		]);

		Route::get('refresh-list-team', [
			'as' => 'client.team.refreshlist',
			'uses' => 'TeamController@refreshList'
		]);

		Route::get('refresh-team-mem', [
			'as' => 'client.team.refreshtmmem',
			'uses' => 'TeamController@refreshTeamMem'
		]);
	});

	Route::group(['prefix' => 'user'], function() {
		Route::get('get-meminfo-md', [
			'as' => 'client.user.meminfo',
			'uses' => 'UserController@getMemberInfoModal'
		]);	

	    Route::get('profile', [
	    	'as' => 'client.user.profile',
	    	'uses' => 'UserController@show'
	    ]);

	    Route::post('udt-avt', [
	    	'as' => 'client.user.udtavt.request',
	    	'uses' => 'UserController@updateAvatar'
	    ]);

	    Route::post('udt-pwd', [
	    	'as' => 'client.user.udtpwd.request',
	    	'uses' => 'UserController@updatePwd'
	    ]);

	    Route::post('udt-info', [
	    	'as' => 'client.user.udtinfo.request',
	    	'uses' => 'UserController@updateInfo'
	    ]);

	    Route::get('del-avt', [
	    	'as' => 'client.user.delavt',
	    	'uses' => 'UserController@destroyAvatar'
	    ]);
	});

	Route::group(['prefix' => 'team-user'], function() {
		Route::post('udt-nickname', [
	    	'as' => 'client.user.udtnickname.request',
	    	'uses' => 'TeamUserController@updateNickname'
	    ]);
	});

	Route::group(['prefix' => 'team-data'], function() {
		Route::post('change-color', [
			'as' => 'client.team.chgcolor.request',
			'uses' => 'TeamDataController@changeColor'
		]);

		Route::post('change-bg', [
			'as' => 'client.team.chgbg.request',
			'uses' => 'TeamDataController@changeBackground'
		]);
		Route::post('destroy-bg', [
			'as' => 'client.team.desbg',
			'uses' => 'TeamDataController@destroyBackground'
		]);
	});

	Route::group(['prefix' => 'message'], function() {
	    Route::post('store', [
	    	'as' => 'client.msg.store.request',
	    	'uses' => 'MessageController@store'
	    ]);

	    Route::post('store-img', [
	    	'as' => 'client.msg.storeimg.request',
	    	'uses' => 'MessageController@storeImg'
	    ]);

	    Route::post('store-doc', [
	    	'as' => 'client.msg.storedoc.request',
	    	'uses' => 'MessageController@storeDoc'
	    ]);

	    Route::post('store-audio', [
	    	'as' => 'client.msg.storeaudio.request',
	    	'uses' => 'MessageController@storeAudio'
	    ]);

	    Route::post('reply', [
	    	'as' => 'client.msg.reply.request',
	    	'uses' => 'MessageController@reply'
	    ]);

	    Route::post('destroy', [
	    	'as' => 'client.msg.destroy.request',
	    	'uses' => 'MessageController@destroy'
	    ]);

	    Route::get('get-desmsg-md', [
			'as' => 'client.msg.destroymsgmd',
			'uses' => 'MessageController@getDestroyMsgModal'
		]);

		Route::post('get-viewmsgimg-md', [
			'as' => 'client.msg.viewmsgimgmd',
			'uses' => 'MessageController@getViewMsgImgModal'
		]);

		Route::get('load-more-messages', [
			'as' => 'client.msg.loadmore',
			'uses' => 'MessageController@loadMoreMessage'
		]);

		Route::post('dispatch-notifi', [
			'as' => 'client.msg.dispatchNotifi',
			'uses' => 'MessageController@dispatchNotification'
		]);
	});

	Route::get('call', [
		'as' => 'client.msg.call',
		'uses' => 'MessageController@call'
	]);

	Route::post('check-user-in-team', [
		'as' => 'client.call.checkuit',
		'uses' => 'MessageController@checkUserInTeam'
	]);

});