<?php
//☆初期データ（シードデータ）**を投入する際の、司令塔となるファイル

//このファイルがどこにあり、何であるかのただのメモ
// database/seeders/DatabaseSeeder.php

//このファイルがDatabase\Seeders というグループに属していますよ」とPHPに教えている
namespace Database\Seeders;

////useステートメントを使って、Laravelが用意している便利なクラスを使うために記入
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PostSeeder;


class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */

    public function run(): void
    {   
        /**
		* Seed the application's database.
		*/

        // User::factory(10)->create();

        $this->call(PostSeeder::class); // 実行したいファイルのクラス呼び出す記述
        // $this->call(UserSeeder::class); // UserSeeder を呼び出す記述を追加
        // \App\Models\User::factory(10)->create(); // ダミーユーザーをファクトリで作る場合の例
        // $this->call(OtherSeeder::class);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
