<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; 

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

public function boot(): void
{
//     Gate::define('admin-task-access', function ($user) {
    
//     dd([
//         'Gateが認識しているロール' => $user->role,
//         '型の確認' => gettype($user->role),
//         '判定式の結果' => in_array($user->role, [1, 2])
//     ]);

//     return in_array((int)$user->role, [1, 2]);
// });



// タスク管理：(int)で確実に数値として比較する
    Gate::define('admin-task-access', function ($user) {
        return in_array((int)$user->role, [1, 2]);
    });

    // 記事管理：こちらも同様に
    Gate::define('article-access', function ($user) {
        return in_array((int)$user->role, [1, 2, 99]);
    });
}}