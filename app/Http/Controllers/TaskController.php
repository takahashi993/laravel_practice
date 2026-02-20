<?php

namespace App\Http\Controllers; // このファイルの住所

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller // クラス名がファイル名と一致
{
    public function index(Request $request) 
    {


        // ... その後の処理 ...

        // 1. 全ユーザーを取得
        $users = \App\Models\User::all();
        // 2. タスクを探す命令予約
        $query = Task::query();
        // ３【検索条件】
        // --- タイトル---
        if ($request->filled('title')) {
            $query->where('title', 'LIKE', "%{$request->title}%");
        }
        // --- 担当者 ---
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        // --- ステータス（複数選択対応） ---
        if ($request->filled('status')) {
            // statusは配列で届くので whereIn を使う
            $query->whereIn('status', $request->status);
        }
        // --- 優先度（複数選択対応） ---
        if ($request->filled('priority')) {
            // priorityは配列で届くので whereIn を使う
            $query->whereIn('priority', $request->priority);
        }
        // --- 対応期限（開始日） ---
        if ($request->filled('deadline_from')) {
            // deadline_at が 開始日(deadline_from) 以上のものを探す
            $query->where('deadline_at', '>=', $request->deadline_from);
        }
        // --- 対応期限（終了日） ---
        if ($request->filled('deadline_to')) {
            // deadline_at が 終了日(deadline_to) 以下のものを探す
            $query->where('deadline_at', '<=', $request->deadline_to);
        }

        // 4. 最後にデータを取得して実行
        $tasks = $query->latest()->get();
        return view('admin.tasks.index', compact('tasks', 'users'));
    }

        public function downloadCsv(Request $request)
        {
            $query = Task::query();

            if ($request->filled('title')) {
            $query->where('title', 'LIKE', "%{$request->title}%");
            }
            // --- 担当者 ---
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            // --- ステータス（複数選択対応） ---
            if ($request->filled('status')) {
                // statusは配列で届くので whereIn を使う
                $query->whereIn('status', $request->status);
            }
            // --- 優先度（複数選択対応） ---
            if ($request->filled('priority')) {
                // priorityは配列で届くので whereIn を使う
                $query->whereIn('priority', $request->priority);
            }
            // --- 対応期限（開始日） ---
            if ($request->filled('deadline_from')) {
                // deadline_at が 開始日(deadline_from) 以上のものを探す
                $query->where('deadline_at', '>=', $request->deadline_from);
            }
            // --- 対応期限（終了日） ---
            if ($request->filled('deadline_to')) {
                // deadline_at が 終了日(deadline_to) 以下のものを探す
                $query->where('deadline_at', '<=', $request->deadline_to);
            }

            $tasks = $query->latest()->get();

            $data = [
                ['ID', 'タイトル', '担当者名', '対応期限', '優先度', 'ステータス', '最終更新日時']
            ];

            foreach ($tasks as $task) {
                $data[] = [
                    $task->id,
                    $task->title,
                    $task->user->name ?? '未設定',
                    $task->deadline_at,
                    config("const.task.priority." . $task->priority),
                    config("const.task.status." . $task->status),
                    $task->updated_at,
                ];
            }

            $csv = '';
            foreach ($data as $row) {
                $escaped = [];
                foreach ($row as $value) {
                    $escaped[] = "'" . str_replace("'", "''", $value) . "'";
                }
                $csv .= implode(',', $escaped) . "\r\n";
            }

            $filename = 'tasks_export_' . date('YmdHis') . '.csv';
            $encodedCsv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');

            return response($encodedCsv, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=' . $filename,
            ]);
        }






    public function show($id)// 詳細メソッド
    {
        $task = Task::withTrashed()->findOrFail($id);
        return view('admin.tasks.show', compact('task'));
    }

    public function edit($id) //編集メソッド（）
    {
        $task = Task::withTrashed()->findOrFail($id);// 1. 編集するタスクを取得
        $users = \App\Models\User::all();
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