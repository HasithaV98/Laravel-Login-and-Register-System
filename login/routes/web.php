<?php

use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;

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

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('register');
});

//Route::get('/dashboard',[HomeController::class,'redirect'])->name('dashboard');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [ViewController::class, 'dashboard'])->name('dashboard');
});

Route::post('/get-user-details', [AjaxController::class, 'getAllUsers'])->name('get-user-details');
Route::post('/user-status-changer', [AjaxController::class, 'statusChanger'])->name('user-status-changer');
Route::post('/update-user', [AjaxController::class, 'updateUser'])->name('update-user');

