<?php

namespace App\Http\Controllers;//どこのフォルダにあるかを書く
use App\Models\Equipment;//Equipmentモデルを呼び出す
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EquipmentCategory;


class EquipmentController extends Controller
{
public function index(Request $request) // Requestを追加
{
    // 検索ワードを受け取る
    $keyword = $request->input('keyword');
    $statuses = $request->input('status', []);

    // クエリビルダを使って絞り込みのベースを作る
    $query = Equipment::query();

    if (!empty($keyword)) {
        // キーワードがある時だけ、名前で検索する
        $query->where('name', 'LIKE', '%' . $keyword . '%');
    }
    if (!empty($statuses)) {
        // ステータスが1つ以上選択されている時だけ絞り込む
        $query->whereIn('status', $statuses);
    }

    // 最後に get() でデータを取得する
    $equipments = $query->get();

    return view('admin.equipments.index', compact('equipments'));
}
    public function show($id) //詳細画面
    {   
    // Equipmentモデルから、この$idのデータを1件探して変数に入れる
        $equipment = Equipment::findOrFail($id);
    // ビューに記事データを渡して表示
        return view('admin.equipments.show', compact('equipment'));
    }
    public function create()//登録画面
    {
        // 全カテゴリーを取得
        $categories = EquipmentCategory::all();
        // ビューに categories を渡す
        return view('admin.equipments.create', compact('categories'));
    }
    public function store(Request $request)
    {
        // --- 1. データの整形（ここは今のままでOK！） ---
        $input = $request->all();
        $input['price'] = str_replace('円', '', mb_convert_kana($request->price, "n"));
        $input['equipment_management_id'] = mb_convert_kana($request->equipment_management_id, "as");
        if ($input['price'] === '') { $input['price'] = null; }
        $request->merge($input);
        // --- 2. 自作バリデーションを呼び出す ---
        // 第2引数は渡さない（nullになる）ので「新規登録モード」で動きます
        $validator = $this->validateEquipment($request);
        if ($validator->fails()) {
            return redirect()->route('admin.equipments.create')
                    ->withErrors($validator)
                    ->withInput();
        }
        // --- 3. 保存 ---
        Equipment::create($request->all());
        return redirect()->route('admin.equipments.index')->with('success', '登録完了！');
    }
        //バリデーション
        private function validateEquipment(Request $request, $id = null)
    {
        $rules = [
            //備品管理番号→必須、文字、MAX20文字、新規は空で編集はidを生かせる
            'equipment_management_id' => 'required|string|max:20|unique:equipment,equipment_management_id' . ($id ? ",$id" : ""),
            //備品名→必須、文字、MAX255文字
            'name'=> 'required|string|max:255',
            //備品説明→空欄OK、文字指定、MAX255文字
            'description'=> 'nullable|string|max:255',
            //購入日→必須、日付
            'purchased_at'=> 'required|date',
            //購入金額→空欄OK、数字指定,0以上
            'price'=> 'nullable|integer|min:0',
            //備品ステータス→必須、数字
            'status'=> 'required|integer',
        ];

        $messages = [
            'required' => ':attributeは必須項目です。',
            'unique'   => 'その:attributeは既に登録されています。別の番号を入力してください。',
            'integer'  => ':attributeは半角数字で入力してください。',
            'max'      => ':attributeは:max文字以内で入力してください。',
        ];
        
        $attributes = [
            'equipment_management_id' => '備品管理番号',
            'name' => '備品名',
            'description' => '備品説明',
            'purchased_at' => '購入日',
            'price' => '購入金額',
            'status' => '備品ステータス',
        ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }

    public function update(Request $request, $id)
    {   
        // --- データの整形（storeと同じ整形をここでもやるのが丁寧です） ---
        $input = $request->all();
        // ★これを追加して、一度止めて中身を見る！
        // dd($request->all());
        $input['price'] = str_replace('円', '', mb_convert_kana($request->price, "n"));
        if ($input['price'] === '') { $input['price'] = null; }
        $request->merge($input);

        // --- 2. 自作バリデーションを呼び出す（★ここ重要！） ---
        // 第2引数に $id を渡すことで「編集モード（自分を除外）」で動きます！
        $validator = $this->validateEquipment($request, $id);

        if ($validator->fails()) {
            return redirect(route('admin.equipments.edit', $id))
                ->withErrors($validator)
                ->withInput();
        }

        // --- 3. 更新処理 ---
        $equipment = Equipment::findOrFail($id);
        $equipment->update($request->all()); // 1行ずつ書かなくてもこれで一気に更新できます

        return redirect(route('admin.equipments.index'))->with('success', '正常に更新されました。');
    }

    public function destroy($id) // 消去メソッド
    {
        // 削除対象の記事を取得。見つからなければ404エラー
        $equipment = Equipment::findOrFail($id);

        // すでに $task にデータが入っているfindOrFail は不要
        $equipment->delete();

        return redirect()->route('admin.equipments.index')->with('success', '削除しました');
    }

    public function edit($id) // 編集画面を表示する
    {
    // 編集したいデータを1件取得
    $equipment = Equipment::findOrFail($id);
    // 編集用のビュー（edit.blade.php）を表示し、データを渡す
    return view('admin.equipments.edit', compact('equipment'));
    }





    }




