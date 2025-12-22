<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            タスク詳細（ID: {{ $task->id }}）
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="space-y-0">
                    <div class="flex items-center gap-2">
                        <label class="text-lg font-bold ">タイトル:</label>
                        <p class="text-lg text-gray-900">{{ $task->content }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-lg font-bold ">内容:</label>
                        <p class="text-lg text-gray-900">{{ $task->content }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                          <label class="text-lg font-bold">優先度:</label>
                          <p class="text-lg text-gray-900">
                              {{ config('const.task.priority')[$task->priority] ?? '不明' }}
                          </p>
                      </div>
                      <div class="flex items-center gap-2">
                          <label class="text-lg font-bold">ステータス:</label>
                          <p class="text-lg text-gray-900">
                              {{ config('const.task.priority')[$task->status] ?? '不明' }}
                          </p>
                      </div>
                      <div class="flex items-center gap-2">
                        <label class="text-lg font-bold ">期限</label>
                        <p class="text-lg text-gray-900">{{ $task->deadline_at }}</p>
                     </div>
                     <div class="flex items-center gap-2">
                        <label class="text-lg font-bold ">作成日時：</label>
                        <p class="text-lg text-gray-900">{{ $task->created_at }}</p>
                     </div>
                     <div class="flex items-center gap-2">
                        <label class="text-lg font-bold ">更新日時：</label>
                        <p class="text-lg text-gray-900">{{ $task->updated_at }}</p>
                     </div>
                </div>
                <div class="mt-8 flex space-x-4">
                    <a href="{{ route('admin.tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        一覧に戻る
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>