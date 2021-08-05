<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

if (config('app.env') === 'production' or config('app.env') === 'staging') {
    // asset()やurl()がhttpsで生成される
    URL::forceScheme('https');
}

// メール認証
Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('auth.login');
});

// お問い合わせ
Route::get('/contact/create', 'ContactController@create')->name('contact.create');
Route::post('/contact/store', 'ContactController@store')->name('contact.store');

// ログイン後の通常のユーザー画面
Route::middleware(['verified'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('/post', 'PostController');
    Route::post('/post/comment/store', 'CommentController@store')->name('comment.store');
    Route::get('/mypost', 'HomeController@mypost')->name('home.mypost');
    Route::get('/mycomment', 'HomeController@mycomment')->name('home.mycomment');

    // 管理者用画面
    Route::middleware(['can:admin'])->group(function () {
        Route::get('/profile/index', 'ProfileController@index')->name('profile.index');
        Route::delete('/profile/delete/{user}', 'ProfileController@delete')->name('profile.delete');

        Route::put('/roles/{user}/attach', 'RoleController@attach')->name('role.attach');
        Route::put('/roles/{user}/detach', 'RoleController@detach')->name('role.detach');
    });


    //プロファイルの編集
    Route::get('/profile/{user}/edit', 'ProfileController@edit')->name('profile.edit');
    Route::put('/profile/{user}', 'ProfileController@update')->name('profile.update');

    //管理者用
    Route::middleware(['can:admin'])->group(function () {
        //ユーザ一覧
        Route::get('/profile/index', 'ProfileController@index')->name('profile.index');
        Route::delete('/profile/{user}', 'ProfileController@delete')->name('profile.delete');
    });
});
