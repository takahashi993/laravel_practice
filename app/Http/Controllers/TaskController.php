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
        $task = Task::withTrashed()->findOrFail($id);
        return view('admin.tasks.edit', compact('task'));
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


    public function create()//登録デメソッド
    {
        return view('admin.tasks.create');
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
        ];

        $messages = [
            'required' => ':attributeは必須項目です。',
            'max'      => ':attributeは:max文字以内で入力してください。',
            'date'     => ':attributeは正しい日付形式で入力してください。',
        ];
        
        $attributes = [
            'title'       => 'タイトル',
            'content'     => '内容',
            'status'      => 'ステータス',
            'priority'    => '優先度',
            'deadline_at' => '対応期限',
            'support_at'  => '対応日時',
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messages, $attributes);
    }




    
}