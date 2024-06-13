<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\InertiaTestController;

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
//下記はcontrollerをスキップしてvueを呼び出している
Route::get('/inertia-test', function () {
    return Inertia::render('InertiaTest');
    }
);

//コントローラークラスのindex関数を呼び出している
//名前付きルートとする
Route::get('/inertia/index', [InertiaTestController::class, 'index'])->name('inertia.index');
//コントローラークラスのcreate関数を呼び出している
Route::get('/inertia/create', [InertiaTestController::class, 'create'])->name('inertia.create');

//DBに保存するからPOSTメソッドに変更
Route::post('/inertia', [InertiaTestController::class, 'store'])->name('inertia.store');
Route::get('/inertia/show/{id}', [InertiaTestController::class, 'show'])->name('inertia.show');
//deleteはメソッド名
Route::delete('/inertia/{id}', [InertiaTestController::class, 'delete'])->name('inertia.delete');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//下記はauthミドルウェアが/profileに適用されることを意味する
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//controllerスキップしてそのままvueに行く
Route::get('/component-test', function(){
    return Inertia::render('ComponentTest');
});


require __DIR__.'/auth.php';
