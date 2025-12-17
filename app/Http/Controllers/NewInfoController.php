<?php
// app/Http/Controllers/NewInfoController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // 必要であれば記述（POSTやGETがされるページがある時）
use App\Models\NewInfo; // 存在してる想定

class NewInfoController extends Controller
{
    /**
     * ルーティングで指定されたURLへのリクエストがあったときに実行されるメソッド
     * （例でいう所の登録画面の表示）
     */
    public function create()
    {
        // ここでデータ取得などの処理を行うことが多いです
        // $data = ...;

        // 'new-info/input' という名前のViewファイル（画面ファイル）を読み込んで表示せよ、という指示（/を.に変える）
        // ファイルの場所：/resources/views/配下（以下の記述だと、/resources/views/new-info/input.blade.phpを呼び出す。）
        return view('new-info.input');
        
        // データをViewに渡す場合は
        // return view('new-info.input', ['data' => $data, 'id' => $id]);や
        // return view('new-info.input', compact('data', 'id')); ←推奨
        // のようにします
    }
    
    // public function edit($id)
    // {
    //     $newInfo = NewInfo::find($id)

    //     return view('new-info.input', compact('newInfo'));
    // }
}