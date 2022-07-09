<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index() {
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
    }

    public function create(){
        $atr = request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:7', 'max:200'],
            'admin' => ['required', 'boolean']
        ]);
        $atr['created_by'] = auth()->user()->id;
        User::create($atr);
        return redirect('/users')->with('message', 'Success!');
    }

    public function store(User $user){
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
    }

    public function destroy(User $user){
        if (auth()->user()->canNot('delete', $user)){
            abort(403);
        }
        $user->delete();
        return redirect('/users')->with('message', 'Success!');
    }
}
