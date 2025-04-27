<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Routing Login
Route::get('/', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('login', [AuthController::class, 'login']);

// Routing Register
Route::get('register', function () {
    return view('auth.register');
})->name('register')->middleware('guest');

Route::post('register', [AuthController::class, 'register']);

// Routing Logout
Route::post('logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');



Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

Route::get('/feed', function () {
    return view('feed');
})->name('feed');

Route::get('/create-post', function () {
    return view('post.create');
})->name('post.create');
