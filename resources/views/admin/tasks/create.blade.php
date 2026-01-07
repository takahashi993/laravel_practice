<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            タスク{{ isset($task) ? '編集（ID: ' . $task->id . '）' : '投稿' }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                 <h1 class="text-2xl font-bold mb-6">
                      タスク{{ isset($task) ? '編集' : '投稿' }}
                 </h1>
                {{--バリデーションエラーメッセージの一括表示 --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded relative" role="alert">
                        <strong class="font-bold">入力内容にエラーがあります！</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.tasks.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">タイトル:</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                   <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">内容:</label>
                        <textarea name="content" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('content') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">担当者</label>
                        <select name="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <!-- <option value="">選択してください</option> -->
                            @foreach($users as $user)
                                {{-- value には ID を、表示には名前（name）を使います --}}
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">対応期限:</label>
                        <input type="datetime-local" name="deadline_at" value="{{ old('deadline_at') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">対応日時:</label>
                        <input type="datetime-local" 
                              name="support_at" 
                              value="{{ old('support_at') }}" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">優先度:</label>
                        <select name="priority" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            {{-- configファイルから優先度のリストを読み込んでループさせます --}}
                            @foreach(config('const.task.priority') as $key => $label)
                                <option value="{{ $key }}" {{ old('priority') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">ステータス:</label>
                        <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach(config('const.task.status') as $key => $label)
                                <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">登録する</button>
                </form>
                </div>
        </div>
    </div>
</x-app-layout>