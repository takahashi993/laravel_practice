<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;  // 報告用
use App\Http\Controllers\NewInfoController; // 新着情報管理用
use App\Http\Controllers\PostController;


// --- Routeの定義例 ---
// Route::{メソッド（POST、GET）}({URL}, [{コントローラ名}::class, {メソッド名}])->name({エイリアス});





// まだコントローラーが未作成のため、PostControllerに赤波線が出るけど、以後で作るので問題なし
Route::get('/admin/posts', [PostController::class, 'index'])->name('admin.posts.index');

//詳細画面
Route::get('/admin/posts/{id}/detail', [PostController::class, 'show'])->name('admin.posts.show');

//登録画面
Route::get('/admin/posts/create', [PostController::class, 'create'])->name('admin.posts.create');
Route::post('/admin/posts/store', [PostController::class, 'store'])->name('admin.posts.store');

//記事検索機能
Route::get('/admin/posts/store', [PostController::class, 'search'])->name('admin.posts.search');


//編集画面
Route::get('/admin/posts/{id}/edit', [PostController::class, 'edit'])->name('admin.posts.edit');
Route::put('/admin/posts/{id}/update', [PostController::class, 'update'])->name('admin.posts.update');

//削除画面
Route::delete('/admin/posts/{id}/destroy', [PostController::class, 'destroy'])->name('admin.posts.destroy');

// 元々new-info/input.php?mode=newという名前だったページ（登録画面）
// Route::{メソッド（POST、GET）}({URL}, [{コントローラ名}::class, {メソッド名}])->name({エイリアス});

// NewInfoControllerクラスのcreateメソッドを実行するルート。GETメソッド（もしくは単純な画面遷移）のみアクセスできる
// 名前を付けることが出来る（ドット区切りが推奨）
Route::get('/new-info/create', [NewInfoController::class, 'create'])->name('new-info.create');

// URLを変えたとしてもnameを変えてなければ、nameからurlを取得できるので、影響範囲が少なくなる
// nameはエイリアスに近い認識
// Route::get('/my-page-2', [MyPageController::class, 'index'])->name('my.page');

// use を使わない場合（クラス名を直接指定）
// Route::get('/fqcn-example', [\App\Http\Controllers\MyPageController::class, 'fqcnMethod']);

// 元々new-info/input.php?mode=edit&id=～という名前だったページ（編集画面）
// パラメータを含むルート定義 {id} の部分がパラメータ
Route::get('/new-info/edit/{id}', [NewInfoController::class, 'edit'])->name('new-info.edit');

// /new-info/edit/5 のようにアクセスすると、コントローラーの editメソッドに 5 が渡されます。
// コントローラーのメソッドは public function edit($id) のようになります。

// 以下のように、複数のパラメータをメソッドに渡すこともできます。
// Route::get('/user/{id}/{mode}', [UserController::class, 'show']);
// コントローラーのメソッドは public function show($id, $mode) のようになります。


// パラメータを任意（省略可能）にする {id?} のように ? を付ける
// /optional-user/5 や /optional-user のどちらでもアクセスできます。
// Route::get('/optional-user/{id?}', [UserController::class, 'show']); // ルートパスを optional-user に変更して区別
// コントローラーのメソッドは public function show($id = null) のようになります。


// コントローラーを使わず、直接処理を書くルート
// 簡単な処理やページ表示などに使えます
Route::get('/about', function () {
    // 直接ビューを返す例
    return view('about');
});















Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
