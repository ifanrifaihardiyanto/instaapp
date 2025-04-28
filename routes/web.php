<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
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

Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class);
    // Feeds
    Route::get('/feed', [PostController::class, 'index'])->name('feed');
    // Create Post
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    // Like or Unlike
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');
    // Comment
    Route::post('posts/{post}/comment', [CommentController::class, 'store'])->name('posts.comment');
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
});
