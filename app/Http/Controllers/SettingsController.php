<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function store(){
        $atr = request();
        $user = auth()->user();
        $atr->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => [Rule::excludeIf($atr['password'] == null), 'min:7', 'max:200'],
        ]);
        $user = auth()->user();
        $user->name = $atr['name'];
        $user->email = $atr['email'];
        if($atr['password']!=null){
            $user->password = $atr['password'];
        }
        $user->save();
        
        return redirect("/settings")->with('message', 'Success!');
    }

    public function destroy() {
        $user = auth()->user();
        (new SessionController)->destroy(request());
        $user->delete();
        return;
    }
}
