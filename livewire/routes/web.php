<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::prefix('user')->name('user.')->group(function() {

    Route::middleware(['guest:web','PreventBackHistory'])->group(function() {
        Route::view('/login', 'auth.login')->name('login');
        Route::view('/register', 'auth.register')->name('register');
        Route::post('/create', [RegisterController::class, 'CreateUser'])->name('create');
        Route::post('/check', [LoginController::class, 'CheckUser'])->name('check');
    });

    Route::middleware(['auth:web','PreventBackHistory'])->group(function() {
        Route::view('/home', 'frontend.pages.home.index')->name('home');
        Route::view('/logout', [LoginController::class, 'UserLogout'])->name('logout');
    });

});