<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            ▼備品カテゴリー 一覧
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <p>取得したカテゴリの数: {{ count($categories) }}</p>

                {{-- テーブルを一つにまとめました --}}
                <table class="min-w-full divide-y divide-gray-200 border mt-4">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">カテゴリー名</th>
                            <th class="px-6 py-3 text-left">表示順</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($categories as $category)
                            <tr>
                                <td class="px-6 py-4">{{ $category->id }}</td>
                                <td class="px-6 py-4">{{ $category->name }}</td>
                                <td class="px-6 py-4">{{ $category->sort_order }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div> {{-- bg-white を閉じる --}}
        </div> {{-- max-w-7xl を閉じる --}}
    </div> {{-- py-6 を閉じる --}}
</x-app-layout>