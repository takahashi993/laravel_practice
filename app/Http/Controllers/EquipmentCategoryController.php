<?php

namespace App\Http\Controllers;
use App\Models\EquipmentCategory;
use Illuminate\Http\Request;

class EquipmentCategoryController extends Controller
{
    public function index() // 一覧画面
    { 
        // 1. データベースから「表示順（sort_order）」の小さい順に取ってくる
        $categories = EquipmentCategory::orderBy('sort_order', 'asc')->get();

        // 2. 「admin/equipment_categories/index.blade.php」という画面を表示して、
        //    そこに取ってきた $categories を渡す！
        return view('admin.equipment_categories.index', compact('categories'));
    }
}
