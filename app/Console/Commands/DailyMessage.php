<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use Carbon\Carbon; // 日付操作のために使用
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Mail\RemindMail;

class DailyMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // コマンド名を定義します。
    protected $signature = 'app:task-remind {target_date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '毎日決まったメッセージを表示します。';

    /**
     * Execute the console command.
     */
public function handle()
{
    // 1. 基準日の決定
    $baseDate = $this->argument('target_date') 
                ? Carbon::parse($this->argument('target_date')) 
                : Carbon::today();

    // 2. 「翌日」を計算
    $targetDate = $baseDate->copy()->addDay()->toDateString();

    $this->info("基準日: " . $baseDate->toDateString() . " / 対象日: " . $targetDate . " の抽出を開始します。");

    // 1. タスクを取得し、担当者ごとにグループ化する
    $groupedTasks = Task::whereDate('deadline_at', $targetDate)
    ->whereIn('status', [1, 2])
    ->with('user') // Eager Loadingでユーザー情報も一緒に取得
    ->get()
    ->groupBy('user_id'); 

foreach ($groupedTasks as $userId => $tasks) {
    // 最初のタスクからユーザー情報を取得
    $user = $tasks->first()->user;
    
    if (!$user || $user->deleted_at) continue;

    // 2. そのユーザーのタスク一覧をテキストにまとめる
    $taskListText = "";
    foreach ($tasks as $task) {
        $statusName = ($task->status == 1) ? '起票' : '対応中';
        // フォーマット: 2026年1月8日 15時03分: タイトル（ステータス）
        $deadline = $task->deadline_at->format('Y年n月j日 G時i分');
        $taskListText .= "{$deadline}: {$task->title}（{$statusName}）\n";
    }


    \Illuminate\Support\Facades\Log::info('メール送信ループ通過: ' . $user->email);

    Mail::to($user->email)->send(new \App\Mail\WelcomeMail($user->name, $taskListText));
    
    $this->info("送信完了: {$user->name} ({$user->email})");
}
    }
}