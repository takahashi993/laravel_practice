<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EquipmentCategory;

class EquipmentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void//DBにデータを入れる指示書※ターミナルで実行
    {
        $categories = [
            ['id' => 1, 'name' => 'PC 本体', 'sort_order' => 10],
            ['id' => 2, 'name' => 'モニター', 'sort_order' => 20],
            ['id' => 3, 'name' => 'キーボード・マウス', 'sort_order' => 30],
            ['id' => 4, 'name' => 'ソフトウェアライセンス', 'sort_order' => 40],
            ['id' => 5, 'name' => '文房具', 'sort_order' => 50],
            ['id' => 99, 'name' => 'その他', 'sort_order' => 990],
            ];
        // $categories（荷物のリスト）から、$category（1個の箱）を取り出す作業を繰り返す
        foreach ($categories as $category) {
        // この1個の箱について「確認して置く」を実行！
        EquipmentCategory::updateOrCreate(['id' => $category['id']], $category);
        } // 全部終わるまで最初に戻る
    }
}
