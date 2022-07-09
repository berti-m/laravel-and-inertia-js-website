<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;

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

Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'index'])->name('login');
    Route::post('/login/user', [SessionController::class, 'create']);
});


Route::middleware('auth')->group(function () {
    Route::post('/logout', [SessionController::class, 'destroy']);

    Route::get('/', function () {
        return Inertia::render('Home');
    });

    Route::get('/users', [UserController::class, 'index']);

    Route::get('/users/create', function () {
        return Inertia::render('Users/Create');
    })->middleware('can:create,App\Models\User');

    Route::post('/users/create', [UserController::class, 'create']);

    Route::get('/user/{user:id}/edit', function () {
        if (auth()->user()->canNot('update', $user)){
            abort(403);
        }
        return Inertia::render('Users/Update', ["user" => $user]);
    });

    Route::post('/user/{user:id}/edit', [UserController::class, 'store']);

    Route::post('/user/{user:id}/delete', [UserController::class, 'destroy']);

    Route::get('/settings', function () {
        return Inertia::render('Settings/Index', ['id' => auth()->user()->id]);
    });

    Route::get('/settings/edit', function () {
        return Inertia::render('Settings/Update', ['user' => auth()->user()->only(['name', 'email'])]);
    });

    Route::post('/settings/edit', [SettingsController::class, "store"]);

    Route::post('/settings/delete', [SettingsController::class, "destroy"]);
});