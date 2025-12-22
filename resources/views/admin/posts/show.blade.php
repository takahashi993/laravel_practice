<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            記事詳細（ID: {{ $post->id }}）
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                
                <div class="p-6 text-gray-900">
                    <!-- <h3 class="text-lg font-bold mb-4">{{ $post->title }}</h3> -->

                    <div class="flex items-center gap-2">
                    <label class="text-lg font-bold ">タイトル:</label>
                    <p class="text-lg text-gray-900">{{ $post->title }}</p>
                    </div>

                    <!-- <p class="mb-2"><strong>公開日時:</strong> {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('Y-m-d H:i:s') : '未定' }}</p> -->

                    <div class="flex items-center gap-2">
                    <label class="text-lg font-bold ">公開日時:</label>
                    <p class="text-lg text-gray-900">{{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('Y-m-d H:i:s') : '未定' }}</p>
                    </div>



                    <!-- <div class="mt-4">
                        <strong>本文:</strong>
                        <p class="mt-2 whitespace-pre-line">{!! nl2br(e($post->body)) !!}</p>
                    </div> -->

                    <div class="flex items-center gap-2">
                    <label class="text-lg font-bold ">本文:</label>
                    <p class="text-lg text-gray-900">{!! nl2br(e($post->body)) !!}</p>
                    </div>

                    <div class="mt-8 flex space-x-4">
                    <a href="{{ route('admin.posts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        一覧に戻る
                    </a>




                </div>
            </div>
        </div>
    </div>
</x-app-layout>

