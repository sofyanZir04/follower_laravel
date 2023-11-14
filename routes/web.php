<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['auth'])->group(function(){
    Route::get('/', function () {
        $users = User::all();
        return view('welcome')->with(
            ['users'=>$users]
        );
    });
    Route::post('/logout',[UserController::class,'logout'])->name('logout');
    Route::get('user/{follow_id}/follow}',[UserController::class,'follow'])->name('follow');
    
});

Route::get('/register',[UserController::class,'registerForm'])->name('register');
Route::get('/login',[UserController::class,'loginForm'])->name('login');

Route::post('/register',[UserController::class,'store'])->name('register');
Route::post('/login',[UserController::class,'auth'])->name('login');

