<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // テーブルに追加していく
    //$table->型('カラム名')->オプション;
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_management_id')->unique();//重複NG備品管理番号
            $table->string('name');//文字で入れる備品名
            $table->string('description')->nullable();//備品説明
            $table->date('purchased_at');//購入日
            $table->integer('price')->nullable();//購入金額
            $table->integer('status')->default(1);//備品ステータス
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};

