<?php

namespace App\Http\Controllers;//どこのフォルダにあるかを書く
use App\Models\Equipment;//Equipmentモデルを呼び出す
use Illuminate\Http\Request;


class EquipmentController extends Controller
{
    public function index() 
    { 
        $equipment = Equipment::all();
        return view('equipment.index', compact('equipment'));
     }
}
