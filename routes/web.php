<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;

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
    return Inertia::render('Home');
});

Route::get('/users', function () {
    return Inertia::render('Users', [
        'users' => User::query()
                        ->when(request('search'), function ($query, $search){
                            $query->where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%');
                        })
                        ->paginate(10)
                        ->withQueryString()
                        ->through(function($user){
                            return ['name' => $user->name,
                                    'email' => $user->email,
                                    'id' => $user->id
                            ];
                        }),

        'requests' => request(['search'])
    ]);
});

Route::get('/settings', function () {
    return Inertia::render('Settings');
});

Route::post('/logout', function () {
    dd('logging the user out '.request('foo'));
});