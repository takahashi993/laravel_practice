<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ▼タスク一覧
        </h2>
    </x-slot>
    {{-- 白背景作成 --}}
    <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg">
            <div class="p-6 text-gray-900">
    {{-- ここから追記/修正 --}}
{{-- 検索エリア --}}
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg">
            <div class="p-6 text-gray-900">
                <form method="GET" action="/admin/tasks">
                    <div class="search-form-container" style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; padding: 10px; border-bottom: 1px solid #ccc;">
                        <div>
                            <label for="search_title">タイトル:</label>
                            <input type="text" id="search_title" name="title" value="">
                        </div>
                        <div>
                            <select id="search_user_id" name="user_id">
                                <option value="">すべて</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="border: 1px solid #eee; padding: 5px;">
                            <label>ステータス:</label>
                            <div class="checkbox-group" style="display: flex; flex-direction: column; gap: 5px;">
                                <label><input type="checkbox" name="status[]" value="1"> 起票</label>
                                <label><input type="checkbox" name="status[]" value="2"> 対応中</label>
                                <label><input type="checkbox" name="status[]" value="3"> 対応済</label>
                                <label><input type="checkbox" name="status[]" value="4"> 承認</label>
                                {{-- 他のステータスオプションが続く --}}
                            </div>
                        </div>
                        <div style="border: 1px solid #eee; padding: 5px;">
                            <label>優先度:</label>
                            <div class="checkbox-group" style="display: flex; flex-direction: column; gap: 5px;">
                                <label><input type="checkbox" name="priority[]" value="1"> 極高</label>
                                <label><input type="checkbox" name="priority[]" value="2"> 高</label>
                                <label><input type="checkbox" name="priority[]" value="3"> 中</label>
                                {{-- 他の優先度オプションが続く --}}
                            </div>
                        </div>
                        <div style="flex-basis: 100%;"> 
                            <label for="search_deadline_from">対応期限 (From):</label>
                            <input type="date" id="search_deadline_from" name="deadline_from" value="">
                        </div>
                        <div>
                            <label for="search_deadline_to">対応期限 (To):</label>
                            <input type="date" id="search_deadline_to" name="deadline_to" value="">
                        </div>
                    </div>
                    <div>
                        <button type="submit" style="padding: 8px 15px; background-color: #010c03ff; color: white;">検索</button>
                        <a href="/admin/tasks" role="button" style="padding: 8px 15px; text-decoration: none; border: 1px solid #ccc; color: #333;">リセット</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- CSVダウンロードボタン（新規作成ボタンの上に配置） --}}
{{-- 画面一覧と同内容をダウンロードするため、検索条件をhiddenで保持する --}}
<div class="flex items-center justify-end">
  <form method="POST" action="/admin/tasks/download-csv" style="margin-top: 20px;">
        @csrf
        <input type="hidden" name="title" value="{{ request('title')}}">
        <input type="hidden" name="user_id" value="{{ request('user_id') }}">
        {{-- ステータスを選択された分だけループ処理 --}}
        @if(is_array(request('status')))
            @foreach(request('status') as $s)
                <input type="hidden" name="status[]" value="{{ $s }}">
            @endforeach
        @endif
        {{-- 優先度を選択された分だけループ処理 --}}
        @if(is_array(request('priority')))
            @foreach(request('priority') as $p)
                <input type="hidden" name="priority[]" value="{{ $p }}">
            @endforeach
        @endif

        <input type="hidden" name="deadline_from" value="{{ request('deadline_from') }}">
        <input type="hidden" name="deadline_to" value="{{ request('deadline_to') }}">

        <button type="submit" style="padding: 8px 15px; background-color: #28a745; color: white;">CSVダウンロード</button>
    </form>
</div>






    {{-- 編集成功メッセージの表示 --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-18">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- ここにテーブルを書いていきます --}}
            <div class="mb-4">
            {{-- 登録画面(create)へ移動するボタン --}}
             <div class="flex justify-end mb-4">
            <a href="{{ route('admin.tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                新規登録
            </a>
            </div>
            
            <!-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"> -->
                <!-- <table class="w-full text-left border-collapse"> -->

                   <table class="table-auto w-full border">
                    <thead>
                        <!-- <tr class="table-auto w-full border"> -->
                            <th class="border px-4 py-2">ID</th>
                            <th class="border px-4 py-2">タイトル</th>
                            <th class="border px-4 py-2">担当者</th>
                            <th class="border px-4 py-2">対応期限</th>
                            <th class="border px-4 py-2">優先度</th>
                            <th class="border px-4 py-2">ステータス</th>
                            <th class="border px-4 py-2">最終更新日時</th>
                            <th class="border px-4 py-2">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($tasks as $task)
                      <!-- <tr class="hover:bg-gray-50"> -->
                        <td class="border px-4 py-2">{{ $task->id }}</td>
                        <td class="border px-4 py-2">{{ $task->title }}</td>
                        <td>{{ $task->user->name ?? '未設定' }}</td>
                        <td class="border px-4 py-2">{{ $task->deadline_at }}</td>
                        <td class="border px-4 py-2">{{ config("const.task.priority." . $task->priority) }}</td>
                        <td class="border px-4 py-2">{{ config("const.task.status." . $task->status) }}</td>
                        <td class="border px-4 py-2">{{ $task->updated_at }}</td>
                        
 
                        <td class="border px-4 py-2 text-center">
                          {{-- ボタンを横に並べるためのグループ --}}
                          <div class="flex items-center justify-center space-x-3">
                              {{-- 1. 詳細 --}}
                              <a href="{{ route('admin.tasks.show', $task->id) }}" class="text-blue-600 hover:underline text-sm">詳細</a>
                              {{-- 2. 編集 --}}
                              <a href="{{ route('admin.tasks.edit', $task->id) }}" class="text-green-600 hover:underline text-sm">編集</a>
                              {{-- 3. 削除 --}}
                              <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');" class="inline">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="text-red-600 hover:underline text-sm">削除</button>
                              </form>
                          </div>
                        </td>
                      </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>