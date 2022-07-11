<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Topic;
use App\Models\Comment;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
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
        return Inertia::render('Home', 
            ['topics' => Topic::query()
            ->when(request('search'), function ($query, $search){
                    $query->where('name', 'like', '%'.$search.'%');
                })
            ->latest()
            ->paginate(12)
            ->withQueryString()
            ->through(fn($top) => ['name' => $top->name, 'file' => $top->file, 'id' => $top->id]),
            'requests' => request()

        ]);
    });

    Route::get('/topic/create', function () {
        return Inertia::render('Topics/Create');
    });

    Route::post('/topic/create', function () {
        $atr = request();
        $atr = $atr->validate([
            'name' => 'required',
            'file' => [Rule::excludeIf($atr['file'] == ""), 'image', 'max:99000']
        ]);
        if (isset($atr['file'])){
            $atr['file'] = request()->file('file')->store('topic_thumbnails', 'public');
        }
        Topic::create($atr);
        return redirect("/")->with('message', 'Success!');
    });

    Route::get('/topic/{topic:id}', function (Topic $topic) {
        $search = request('search');
        return Inertia::render('Topics/Index', 
            ['topic' => 
                ['name' => $topic->name, 
                'file' => $topic->file,
                'id' => $topic->id ], 
            'requests' => request(), 
            'comments' => Comment::query()
            ->with('user')
            ->where('topic_id', $topic->id)
            ->where(function ($query) use ($search) {
                $query->where('body', 'like', '%'.$search.'%')
                ->orWhereHas('user', function ($user) use ($search){
                    $user->where('name', 'like', '%'.$search.'%');
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString()
            ->through(fn($top) => ['body' => $top->body, 'user' => $top->user, 'id' => $top->id, 'file' => $top->file, 'updated_at' => $top->updated_at]), 
            'requests' => request(),
            'user' => ['id' => auth()->user()->id ]
        ]);
    });

    Route::post('/comment/{topic:id}', function (Topic $topic) {
        $atr = request();
        $atr = $atr->validate([
            'body' => 'required|string',
            'file' => [Rule::excludeIf($atr['file'] == ""), 'file', 'max:99000'],
        ]);
        if (isset($atr['file'])){
            $atr['file'] = request()->file('file')->store('comment_attachments', 'public');
        }
        $atr['topic_id'] = $topic->id;
        $atr['user_id'] = auth()->user()->id;
        Comment::create($atr);
        return back()->with('message', 'Success!');
    });

    Route::post('/comment/edit/{comment:id}', function (Comment $comment) {
        if (auth()->user()->id != $comment->user->id){
            return back()->with('message', 'Forbidden');
        }
        $atr = request();
        $atr = $atr->validate([
            'body' => 'required|string'
        ]);
        $comment->body = $atr['body'];
        $comment->save();
        return back()->with('message', 'Success!');
    });

    Route::post('/comment/delete/{comment:id}', function (Comment $comment) {
        if (auth()->user()->id != $comment->user->id){
            return back()->with('message', 'Forbidden');
        }
        if (isset($comment->file)){
            Storage::delete('public/'.$comment->file);
        }
        $comment->delete();
        return back()->with('message', 'Success!');
    });

    Route::get('/users', [UserController::class, 'index']);

    Route::get('/users/create', function () {
        return Inertia::render('Users/Create');
    })->middleware('can:create,App\Models\User');

    Route::post('/users/create', [UserController::class, 'create']);

    Route::get('/user/{user:id}/edit', function (User $user) {
        if (auth()->user()->canNot('update', $user)){
            return back()->with('message', 'Forbidden');
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