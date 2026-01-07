<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    {{-- ここからタスク表示領域 --}}
                    <div class="mt-4">
                        <h3 class="font-semibold text-lg text-gray-800 leading-tight mb-2">担当タスク</h3>
                        @if($tasks->isEmpty())
                            {{-- 1. タスクが空だった時のメッセージを表示  --}}
                            <p>現在、該当するタスクはありません。</p>
                        @else
                            {{-- 2. タスクがある場合、リスト形式で表示 📝 --}}
                            <ul>
                                @foreach ($tasks as $task)
                                    <li>
                                        {{-- ここに「対応期限」と「タイトル」を表示 --}}
                                        {{ $task->deadline_at }} : {{ $task->title }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        {{-- ここに、ログインユーザーの担当タスク（対応期限、タイトル順）を表示します --}}
                        {{-- 例:
                        <ul>
                            <li>
                                2025年6月1日15時00分: タスク1
                            </li>
                        </ul>
                        --}}
                         {{-- 条件に合うタスクがない場合はulタグを表示せず、「現在、該当するタスクはありません。」というメッセージを表示します --}}
                    </div>
                    {{-- ここまでタスク表示領域 --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>