<?php

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

Route::get('/', function () {
    return redirect('/login');
});
Route::get('notify', function () {
    return view('notify');
});
Route::get('/login', 'Auth\\LoginController@showLoginForm');
Route::post('/login', 'Auth\\LoginController@loginCheck');
Route::get('/logout', 'Auth\\LoginController@logout');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/main', 'IndexController@showMain');
    Route::get('/index', function () {
        return view('layouts.frame');
    });
    Route::group(['prefix' => 'system'], function () {
        Route::group(['prefix' => 'actions'], function () {
            Route::get('/list', 'SystemController@actionsList');
            Route::get('/add', 'SystemController@setAction');
            Route::get('/edit', 'SystemController@setAction');
            Route::post('/store', 'SystemController@storeAction');
            Route::get('/delete', 'SystemController@deleteAction');
        });
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/list', 'SystemController@rolesList');
            Route::get('/add', 'SystemController@setRole');
            Route::get('/edit', 'SystemController@setRole');
            Route::post('/store', 'SystemController@storeRole');
            Route::get('/delete', 'SystemController@deleteRole');
        });
        Route::group(['prefix' => 'users'], function () {
            Route::get('/list', 'SystemController@usersList');
            Route::get('/add', 'SystemController@setUsers');
            Route::get('/edit', 'SystemController@setUsers');
            Route::post('/store', 'SystemController@storeUser');
        });
        Route::group(['prefix' => 'departments'], function () {
            Route::get('/list', 'SystemController@departmentsList');
            Route::get('/get', 'SystemController@getDepartmentInfo');
            Route::get('/add', 'SystemController@setDepartment');
            Route::post('/store', 'SystemController@storeDepartment');
            Route::get('/delete', 'SystemController@deleteDepartment');
        });
        Route::group(['prefix' => 'positions'], function () {
            Route::get('/list', 'SystemController@positionsList');
            Route::get('/get', 'SystemController@getPositionInfo');
            Route::get('/add', 'SystemController@setPosition');
            Route::post('/store', 'SystemController@storePosition');
            Route::get('/delete', 'SystemController@deletePosition');
        });
    });
    Route::group(['prefix' => 'panel'], function () {
        Route::get('/init/password', 'PanelController@initPassword');
        Route::post('/init/password', 'PanelController@storeInitPassword');
        Route::get('/user/center', 'PanelController@userCenter');
        Route::get('/user/edit', 'PanelController@editProfile');
        Route::post('/user/store', 'PanelController@storeUserProfile');

    });
});

