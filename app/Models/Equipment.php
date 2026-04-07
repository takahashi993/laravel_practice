<?php

namespace App\Models;// このファイルは App\Models にありますよという宣言

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    //マイグレーションで作ったカラム名のうち、**「プログラム経由で保存・更新してもいいもの」**をすべて並べます。
    use HasFactory;           // 2. 【機能】テストデータ作成機能を使う

    protected $fillable = [   // 3. 【門番】保存を許可する項目のリスト
            'equipment_management_id',//備品管理番号
            'name',//備品名
            'description',//備品説明
            'purchased_at',//購入日
            'price',//購入金額
            'status'//備品ステータス
    ];
}
