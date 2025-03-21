<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
//use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
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


// お問い合わせフォーム
Route::get('/', [ContactController::class, 'index'])->name('contact.index');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/', [ContactController::class, 'store'])->name('contact.store');
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');

 // 管理者機能 (middleware で保護)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [ContactController::class, 'admin'])->name('admin.index');
        Route::get('/search', [ContactController::class, 'search'])->name('admin.search');
        Route::get('/show/{id}', [ContactController::class, 'show'])->name('admin.show');
        Route::delete('/destroy/{id}', [ContactController::class, 'destroy'])->name('admin.destroy');
        Route::get('/export', [ContactController::class, 'export'])->name('admin.export');
    });
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

//Route::post('/register', [RegisteredUserController::class, 'store'])
    //->middleware(['guest:'.config('fortify.guard')])
    //->name('register.post');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');