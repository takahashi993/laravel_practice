<?php

namespace App\Http\Controllers; // このファイルの住所

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Controllers\Controller; 

class TaskController extends Controller // クラス名がファイル名と一致
{
    public function index() //一覧メソッド
    {
    // withTrashed() を取ると、削除されていないタスクだけを取得
    $tasks = Task::latest()->get();
    return view('admin.tasks.index', compact('tasks'));
    }

    public function show($id)// 詳細メソッド
    {
        $task = Task::withTrashed()->findOrFail($id);
        return view('admin.tasks.show', compact('task'));
    }

    public function edit($id) //編集メソッド（）
    {
        $task = Task::withTrashed()->findOrFail($id);// 1. 編集するタスクを取得
        $users = \App\Models\Task::all();
        return view('admin.tasks.edit', compact('task', 'users'));
    }


    public function update(Request $request, $id)//編集メソッド更新
    {
    // ① 削除済みのデータも含めて対象を探す
    $task = \App\Models\Task::withTrashed()->findOrFail($id);

    // ② データを更新する
    $task->update($request->all());

    // ③ ここで「復元」を実行してゴミ箱から出す 
    $task->restore();

    return redirect()
        ->route('admin.tasks.index')
        ->with('success', 'タスクを更新し、復元しました！');
    }


    public function create()//登録メソッド
    {
        // Task ではなく User モデルから全ユーザーを取得 
        $users = \App\Models\User::all();

        return view('admin.tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        // バリデーション
        $validator = $this->validator($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // リダイレクト先を admin.tasks.create ルートに変更
            return redirect(route('admin.tasks.create')) 
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        // Postモデルのカスタムメソッドを使ってデータを保存
        $task = new Task();
        // $request オブジェクトを直接 savePost メソッドに渡す
        $task->saveTask($request); 
        
        // Post::Create([]);

        // /admin/posts にリダイレクトする（既に定義済みの記事一覧ページなどへ）
        // 成功メッセージをセッションにフラッシュデータとして保存
        return redirect(route('admin.tasks.index'))->with('success', '記事が正常に投稿されました。');
    }

    

    public function destroy(Task $task) // 消去メソッド
    {
        // すでに $task にデータが入っているfindOrFail は不要
        $task->delete();

        return redirect()->route('admin.tasks.index')->with('success', '削除しました');
    }

    private function validator(Request $request)// バリデーション用メソッド
    {
        $rules = [
            'title'       => 'required|max:100',
            'content'     => 'required|max:1000',
            'status'      => 'required|integer', 
            'priority'    => 'required|integer', 
            'deadline_at' => 'required|date',    
            'acted_at'    => 'nullable|date',    
            'user_id'     => 'required|integer|exists:users,id',//必須、数値である事、カラムにその数字が存在するか
        ];

        $messages = [
            'required' => ':attributeは必須項目です。',
            'max'      => ':attributeは:max文字以内で入力してください。',
            'date'     => ':attributeは正しい日付形式で入力してください。',
            'user_id'  => '担当者入力は必須です。',
        ];
        
        $attributes = [
            'title'       => 'タイトル',
            'content'     => '内容',
            'status'      => 'ステータス',
            'priority'    => '優先度',
            'deadline_at' => '対応期限',
            'support_at'  => '対応日時',
            'user_id'     => '担当者'
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messages, $attributes);
    }

    public function dashboard()//ダッシュボードのタスク表示
    {
        $loginUserId = auth()->id(); // 1. ログインユーザーのIDを取得 

        $tasks = Task::where('user_id', $loginUserId) // 2. 条件に合うタスクを取得 
            ->whereIn('status', [1, 2]) // ステータスが 1 または 2
            ->orderBy('deadline_at', 'asc') // ★ここで「対応期限が近い順（昇順）」に並び替える
            ->get();

            // ここに追加して、中身を画面に強制表示して止めます
            // dd($tasks);

        return view('dashboard', compact('tasks')); // 3. ビューに変数 $tasks を渡して表示 
    }




    
}