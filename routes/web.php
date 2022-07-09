<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Controllers\SessionController;
use Illuminate\Validation\Rule;

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

    Route::get('/users', function () {
        return Inertia::render('Users/Index', [
            'users' => User::query()
                ->when(request('search'), function ($query, $search){
                    $query->where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%');
                })
                ->paginate(10)
                ->withQueryString()
                ->through(function($user){
                    return ['name' => $user->name,
                            'email' => $user->email,
                            'id' => $user->id,
                            'can' => [
                                'update' => auth()->user()->can('update', $user),
                                'delete' => auth()->user()->can('delete', $user)
                            ]
                    ];
            }),
            'can' => [
                'create' => auth()->user()->can('create', User::class)
            ],

            'requests' => request(['search'])
        ]);
    });

    Route::get('/users/create', function () {
        return Inertia::render('Users/Create');
    })->middleware('can:create,App\Models\User');

    Route::get('/user/{user:id}/edit', function (User $user) {
        if (auth()->user()->canNot('update', $user)){
            abort(403);
        }
        return Inertia::render('Users/Update', ["user" => $user]);
    });

    Route::post('/user/{user:id}/edit', function (User $user) {
        if (auth()->user()->canNot('update', $user)){
            abort(403);
        }
        $atr = request();
        $atr->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => [Rule::excludeIf($atr['password'] == null), 'min:7', 'max:200'],
            'is_admin' => ['required', 'boolean']
        ]);
        $user->name = $atr['name'];
        $user->email = $atr['email'];
        $user->admin = $atr['is_admin'];
        if($atr['password']!=null){
            $user->password = $atr['password'];
        }
        $user->save();
        
        return redirect("/users")->with('message', 'Success!');
    });

    Route::post('/user/{user:id}/delete', function (User $user) {
        if (auth()->user()->canNot('update', $user)){
            abort(403);
        }
        $user->delete();
        return redirect('/users')->with('message', 'Success!');
    })->middleware('can:create,App\Models\User');

    Route::post('/users', function () {
        $atr = request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:7', 'max:200'],
            'admin' => ['required', 'boolean']
        ]);
        User::create($atr);
        return redirect('/users')->with('message', 'Success!');
    });

    Route::get('/settings', function () {
        return Inertia::render('Settings');
    });
});