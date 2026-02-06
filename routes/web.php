<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;  // 報告用
use App\Http\Controllers\NewInfoController; // 新着情報管理用
use App\Http\Controllers\PostController;
use App\Http\Controllers\TaskController; // タスク管理用



// --- 1. タスク管理：システム管理者(1)と管理者(2)だけが入れるグループ ---
Route::middleware(['auth', 'can:admin-task-access'])->group(function () {
    // タスク管理関連のルートをここにまとめる
    Route::get('/admin/tasks', [TaskController::class, 'index'])->name('admin.tasks.index');
    Route::get('/admin/tasks/{id}/edit', [TaskController::class, 'edit'])->name('admin.tasks.edit');
    Route::put('/admin/tasks/{id}/update', [TaskController::class, 'update'])->name('admin.tasks.update');
    Route::get('/admin/tasks/{id}/show', [TaskController::class, 'show'])->name('admin.tasks.show');
    Route::get('/admin/tasks/create', [TaskController::class, 'create'])->name('admin.tasks.create');
    Route::post('/admin/tasks/store', [TaskController::class, 'store'])->name('admin.tasks.store');
    Route::delete('/admin/tasks/{task}/destroy', [TaskController::class, 'destroy'])->name('admin.tasks.destroy');
    Route::post('/admin/tasks/download-csv', [TaskController::class, 'downloadCsv'])->name('admin.tasks.download-csv');
});

// --- 2. 記事管理：全員(1, 2, 99)が入れるグループ ---
Route::middleware(['auth', 'can:article-access'])->group(function () {
    // 記事管理関連のルートをここにまとめる
    Route::get('/admin/posts', [PostController::class, 'index'])->name('admin.posts.index');
    Route::get('/admin/posts/{id}/detail', [PostController::class, 'show'])->name('admin.posts.show');
    Route::get('/admin/posts/create', [PostController::class, 'create'])->name('admin.posts.create');
    Route::post('/admin/posts/store', [PostController::class, 'store'])->name('admin.posts.store');
    Route::get('/admin/posts/search', [PostController::class, 'search'])->name('admin.posts.search');
    Route::get('/admin/posts/{id}/edit', [PostController::class, 'edit'])->name('admin.posts.edit');
    Route::put('/admin/posts/{id}/update', [PostController::class, 'update'])->name('admin.posts.update');
    Route::delete('/admin/posts/{id}/destroy', [PostController::class, 'destroy'])->name('admin.posts.destroy');
});

// --- Routeの定義例 ---
// Route::{メソッド（POST、GET）}({URL}, [{コントローラ名}::class, {メソッド名}])->name({エイリアス});
// 記事管理ルート
// Route::get('/admin/posts', [PostController::class, 'index'])->name('admin.posts.index');//一覧
// Route::get('/admin/posts/{id}/detail', [PostController::class, 'show'])->name('admin.posts.show');//詳細画面
// Route::get('/admin/posts/create', [PostController::class, 'create'])->name('admin.posts.create');//登録画面
// Route::post('/admin/posts/store', [PostController::class, 'store'])->name('admin.posts.store');//登録画面
// Route::get('/admin/posts/store', [PostController::class, 'search'])->name('admin.posts.search');//記事検索機能
// Route::get('/admin/posts/{id}/edit', [PostController::class, 'edit'])->name('admin.posts.edit');//編集画面
// Route::put('/admin/posts/{id}/update', [PostController::class, 'update'])->name('admin.posts.update');//編集画面
// Route::delete('/admin/posts/{id}/destroy', [PostController::class, 'destroy'])->name('admin.posts.destroy');//削除画面


// //タスク管理ルート
// Route::get('/admin/tasks', [TaskController::class, 'index'])->name('admin.tasks.index');//一覧
// Route::get('/admin/tasks/{id}/edit', [TaskController::class, 'edit'])->name('admin.tasks.edit');//編集表示
// Route::put('/admin/tasks/{id}/update', [TaskController::class, 'update'])->name('admin.tasks.update');//編集更新
// Route::get('/admin/tasks/{id}/show', [TaskController::class, 'show'])->name('admin.tasks.show');//詳細
// Route::get('/admin/tasks/create', [TaskController::class, 'create'])->name('admin.tasks.create');//登録
// Route::post('/admin/tasks/store', [TaskController::class, 'store'])->name('admin.tasks.store');//登録バリデ
// Route::delete('/admin/tasks/{task}/destroy', [TaskController::class, 'destroy'])->name('admin.tasks.destroy');//削除
// Route::post('/admin/tasks/download-csv', [TaskController::class, 'downloadCsv'])->name('admin.tasks.download-csv');
// ;//CSVダウンロード機能

// // タスク管理のルート（管理者のみ）
// Route::get('/tasks', [TaskController::class, 'index'])
//     ->middleware('can:admin-task-access');

// // 記事管理のルート（一般ユーザーもOK）
// Route::get('/articles', [PostController::class, 'index'])
//     ->middleware('can:article-access');



    
//     // この中に書いたルートはすべて管理者限定
//     Route::get('/admin/tasks', [TaskController::class, 'index'])->name('admin.tasks.index');
//     // 他の管理者用ルートもここに追加可能
    
// });


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

//変更後：TaskController の dashboard メソッドを呼ぶようにする
Route::get('/dashboard', [TaskController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
