<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();//ID自動連番
            // $table->unsignedBigInteger('user_id');//担当者
            // $table->unsignedBigInteger('user_id')->after('id');//担当者
            $table->string('title');//型：短いテキスト 備考:タイトル
            $table->text('content');//型：長いテキスト 備考:内容
            $table->dateTime('deadline_at');//型：日時 備考:対応期限
            $table->dateTime('support_at')->nullable();//型：日時 備考:対応日時
            $table->integer('priority');//型：数字 備考:優先度
            $table->integer('status');//型：数字 備考:ステータス
            $table->timestamps();//created_at と updated_at を自動作成
            $table->softDeletes();//deleted_at（削除日時）を管理

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
