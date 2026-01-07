<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request; // Requestクラスをインポート
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;

    use SoftDeletes;

    // savePostメソッドで個別にプロパティを設定するため、$fillableは必須ではありませんが、
    // create()など他のLaravelの機能を使う場合に備えて残しておくと良いでしょう。
    protected $fillable = ['title', 'content', 'status', 'priority', 'deadline_at', 'support_at', 'user_id'];

    /**
     * 投稿データをモデルに設定し、保存するカスタムメソッド
     *
     * @param \Illuminate\Http\Request $request 送信されたリクエストオブジェクト
     * @return void
     */
    public function saveTask(Request $request)
    {
        // 1. 各プロパティにリクエストの値を代入
        $this->title       = $request->input('title');
        $this->content     = $request->input('content');
        $this->status      = $request->input('status');
        $this->priority    = $request->input('priority');
        $this->deadline_at = $request->input('deadline_at');
        $this->user_id     = $request->input('user_id');
        $this->support_at  = $request->input('support_at');

        // 登録/編集処理
        // dd($this->toArray());
        $this->save();
    }

    public function user()
{
    return $this->belongsTo(User::class);
}

    
}