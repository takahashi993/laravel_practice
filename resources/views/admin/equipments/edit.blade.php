<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            備品{{ isset($equipment) ? '編集（ID: ' . $equipment->id . '）' : '投稿' }}
        </h2>
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
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.equipments.update', $equipment->id) }}" method="POST">
                    @csrf
    @method('PUT')  {{-- ← これが非常に重要です！ --}}
                     <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">備品管理番号</label>
                        <input type="text" name="equipment_management_id" value="{{ $equipment->equipment_management_id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">備品名</label>
                        <input type="text" name="name" value="{{ $equipment->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">備品説明</label>
                        <input type="text" name="description" value="{{ $equipment->description }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">購入日</label>
                        <input type="datetime-local" name="purchased_at" value="{{ old('purchased_at', $equipment->purchased_at ? date('Y-m-d\TH:i', strtotime($equipment->purchased_at)) : '') }}" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">購入金額</label>
                        <input type="text" name="price" value="{{ $equipment->price }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">ステータス</label>
                            <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                            @foreach(config('const.equipment.status') as $key => $label)
                            <option value="{{ $key }}" {{ old('status', $equipment->status) == $key ? 'selected' : '' }}>
                            {{ $label }}
                            </option>
                            @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">編集</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>