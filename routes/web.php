<?php

use App\Http\Controllers\RoleController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', function () {
    return 'users';
})->middleware('can:user_index');

Route::get('/reports', function () {
    return 'reports';
})->middleware('can:reports');

Route::get('/orders', function () {
    return 'orders';
})->middleware('can:orders');

Route::get('/roles', [RoleController::class, 'index']);
Route::post('/add-roles', [RoleController::class, 'store'])->name('roles.store');
Route::post('/add-user', [RoleController::class, 'addUser'])->name('users.store');

Route::get('/auth', function () {
    $user = User::findOrFail(3);
    Auth::login($user);
    return 'done';
});
