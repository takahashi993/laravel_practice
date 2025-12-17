<?php
//☆posts テーブルに初期データやテストデータを自動で投入するための設計図コード


//このファイルがどのディレクトリに属してるかPHPに伝える役割
namespace Database\Seeders;


//useステートメントを使って、Laravelが用意している便利なクラスを使うために記入
use Illuminate\Database\Console\Seeds\WithoutModelEvents;//記事が作成されたときに自動でメールを送るなどの処理）を一時的に無効にするための設定
use Illuminate\Database\Seeder;//PostSeederが「これはLaravelのシーダーですよ」と定義するために継承する基底クラスをインポート
use Illuminate\Support\Facades\DB; // データベース（DB）を直接操作するための機能（ファサード）をインポート
use Illuminate\Support\Carbon; // 日時を入れるためによく使います



class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    //メソッドを作成
    public function run(): void
    {
         // この行を追加して、シーダー実行前にpostsテーブルの全データをクリア
        DB::table('posts')->truncate();

        // posts テーブルにデータを一つ入れる例 (DBファサードを使用)
        DB::table('posts')->insert(
		        [
		            'title' => 'シーダーで作った記事',
		            'body' => 'この内容はシーダーによって自動で入りました',
		            'published_at' => Carbon::now(), // カラムにCarbon::now() で取得した現在の日時を入れる
		            'created_at' => Carbon::now(),//カラムに作成日時に現在の時刻を入れる
		            'updated_at' => Carbon::now(),//カラムに更新日時に現在の時刻を入れる
		        ],
                 // ,...
        );
        
        /* 複数件登録する場合
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'title' => 'シーダーで作った記事' . $i,
                'body' => 'この内容はシーダーによって自動で入りました',
                'published_at' => Carbon::now(), // 今の日時を入れる
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        
        DB::table('posts')->insert($data);
        */

        // もっとたくさんのダミーデータを入れたいときは「ファクトリ」という機能を使うと便利です（後述）
        // \App\Models\Post::factory()->count(10)->create(); // ダミー記事を10個作る例
    }
}

