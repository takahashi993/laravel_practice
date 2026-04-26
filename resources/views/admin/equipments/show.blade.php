<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            備品詳細（ID: {{ $equipment->id }}）
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="space-y-0">
                    <div class="flex items-center gap-2">
                        <label class="text-lg font-bold ">備品管理番号:</label>
                        <p class="text-lg text-gray-900">{{ $equipment->equipment_management_id }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-lg font-bold ">備品名:</label>
                        <p class="text-lg text-gray-900">{{ $equipment->name }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                          <label class="text-lg font-bold">備品説明:</label>
                        <p class="text-lg text-gray-900">{{ $equipment->description }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-lg font-bold ">購入日</label>
                        <p class="text-lg text-gray-900">{{ $equipment->purchased_at }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-lg font-bold ">金額</label>
                        <p class="text-lg text-gray-900">{{ $equipment->price }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                          <label class="text-lg font-bold">ステータス:</label>
                          <p class="text-lg text-gray-900">
                              {{ config('const.equipment.status')[$equipment->status] ?? '不明' }}
                          </p>
                      </div>
                     <div class="flex items-center gap-2">
                        <label class="text-lg font-bold ">登録日：</label>
                        <p class="text-lg text-gray-900">{{ $equipment->created_at }}</p>
                     </div>

                    <div class="mt-8 flex space-x-4">
                    <a href="{{ route('admin.equipments.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        一覧に戻る
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>