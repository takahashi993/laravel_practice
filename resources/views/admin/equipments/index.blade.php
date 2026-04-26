<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            ▼備品管理一覧
        </h2>
</x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                {{-- ここから追記/修正 --}}

                {{-- ここに以下の検索フォームを追加 --}}
                <form action="{{ route('admin.equipments.index') }}" method="GET" class="mb-4">
                <div style="border: 1px solid #eee; padding: 5px;">
                <label>ステータス:</label>
                <div class="checkbox-group" style="display: flex; flex-direction: column; gap: 5px;">
                    <label><input type="checkbox" name="status[]" value="1"> 利用可能</label>
                    <label><input type="checkbox" name="status[]" value="2"> 貸し出し中</label>
                    <label><input type="checkbox" name="status[]" value="3"> その他</label>
                    {{-- 他のステータスオプションが続く --}}
                </div>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="タイトルを検索" class="border p-2 rounded-md">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                          検索
                    </button>
                    <a href="{{ route('admin.equipments.index') }}" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded ml-2">
                          クリア
                      </a>
                    </form>
                </div>
                  {{-- ここまで追加 --}}


                    {{-- 成功メッセージの表示 --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- 新規投稿画面へのリンク --}}
                    {{-- 検索フォームを実装済みの場合は、その下 --}}
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.equipments.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            新規投稿
                        </a>
                    </div>

                    {{-- ここまで追記/修正 --}}
                    <table class="table-auto w-full border">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">ID</th>
                                <th class="border px-4 py-2">備品管理番号</th>
                                <th class="border px-4 py-2">備品名</th>
                                <th class="border px-4 py-2">備品説明</th>
                                <th class="border px-4 py-2">購入日</th>
                                <th class="border px-4 py-2">金額</th>
                                <th class="border px-4 py-2">備品ステータス</th>
                                <th class="border px-4 py-2">登録日</th>
                                <th class="border px-4 py-2">操作</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($equipments as $equipment)<!-- 欲しい情報をDBから取り出す指示 -->
                                <tr>
                                    <td class="border px-4 py-2">{{ $equipment->id }}</td>
                                    <td class="border px-4 py-2">{{ $equipment->equipment_management_id }}</td>
                                    <td class="border px-4 py-2">{{ $equipment->name }}</td>
                                    <td class="border px-4 py-2">{{ $equipment->description }}</td>
                                    <td class="border px-4 py-2">{{ $equipment->purchased_at }}</td>
                                    <td class="border px-4 py-2">{{ $equipment->price }}</td>
                                    <td class="border px-4 py-2">{{ config('const.equipment.status.' . $equipment->status) }}</td>
                                    <td class="border px-4 py-2">{{ $equipment->created_at }}</td>
                                    <td class="border px-4 py-2 flex items-center justify-center space-x-2">
                                        {{-- 詳細ボタンを追加 --}}
                                        <a href="{{ route('admin.equipments.show', $equipment->id) }}" class="text-blue-600 hover:underline">詳細</a>
                                        {{-- 編集ボタンを追加 --}}
                                        <a href="{{ route('admin.equipments.edit', $equipment->id) }}" class="ml-2 text-green-600 hover:underline">編集</a>
                                        {{-- 削除ボタンの追加 --}}
                                        <form action="{{ route('admin.equipments.destroy', $equipment->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline bg-transparent border-none cursor-pointer p-0 m-0">削除</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
