<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            タスク{{ isset($task) ? '編集（ID: ' . $task->id . '）' : '投稿' }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                     <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST">
                     <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">ステータス</label>
                            @csrf
                            @method('PUT')
                            <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                            @foreach(config('const.task.status') as $key => $label)
                            <option value="{{ $key }}" {{ old('status', $task->status) == $key ? 'selected' : '' }}>
                            {{ $label }}
                            </option>
                            @endforeach
                            </select>
                      </div>
                      <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">優先度</label>
                            <select name="priority" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach(config('const.task.priority') as $key => $label)
                                <option value="{{ $key }}" {{ old('priority', $task->priority) == $key ? 'selected' : '' }}>{{ $label }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                            <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">担当者</label>
                            <select name="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">未選択</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $task->user_id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                            <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">対応期限</label>
                            <input type="datetime-local" name="deadline_at" value="{{ old('deadline_at', $task->deadline_at ? date('Y-m-d\TH:i', strtotime($task->deadline_at)) : '') }}" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">対応日時</label>
                            <input type="datetime-local" name="support_at" 
                                value="{{ old('support_at', $task->support_at ? date('Y-m-d\TH:i', strtotime($task->support_at)) : '') }}" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                         </div>
                            <label class="block text-sm font-medium text-gray-700">内容</label>
                            <textarea name="content" class="w-full">{{ $task->content }}</textarea>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">タイトル</label>
                            <input type="text" name="title" value="{{ $task->title }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">編集</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>