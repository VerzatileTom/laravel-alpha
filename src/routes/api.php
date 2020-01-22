<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('users/me', function () {
        return request()->user();
    });

    Route::post('logout', 'LoginController@logout')->name('logout');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'LoginController@login')->name('login');
    Route::post('register', 'RegisterController@register')->name('register');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'ResetPasswordController@reset');
});

Route::apiResource('role', 'RoleController');
Route::delete('role', 'RoleController@destroyAll')->name('role.destroyAll');

Route::apiResource('permission', 'PermissionController');
Route::delete('permission', 'PermissionController@destroyAll')->name('permission.destroyAll');

Route::get('roles-permissions', 'RolePermissionController@index')->name('role-permission.index');
Route::post('roles-permissions/{role}/{permission}', 'RolePermissionController@update')->name('role-permission.update');


Route::get('email/resend', 'VerificationController@resend')->name('verification.resend')->middleware(['auth:api', 'throttle:60,1']);
Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->middleware(['throttle:60,1']);
