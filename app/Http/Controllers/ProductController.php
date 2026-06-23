<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // 商品一覧
public function index(Request $request)
{
    // ベースクエリ
    $query = Product::query();

    // 🔍 商品名検索（部分一致）
    $query->when($request->keyword, function ($q) use ($request) {
        $q->where('name', 'like', '%' . $request->keyword . '%');
    });

    // ↕ 並び替え
    $query->when($request->sort === 'high', function ($q) {
        $q->orderBy('price', 'desc');
    });

    $query->when($request->sort === 'low', function ($q) {
        $q->orderBy('price', 'asc');
    });

    // 📄 ページネーション（検索条件を保持）
    $products = $query->paginate(6)->appends($request->query());

    return view('products.index', compact('products'));
}


    // 商品詳細
public function detail($id)
{
    $product = Product::with('seasons')->findOrFail($id);
    $seasons = Season::all();

    return view('products.detail', compact('product', 'seasons'));
}
    // 商品登録フォーム
public function showRegister()
{
    $seasons = Season::all();
    return view('products.register', compact('seasons'));
}

    // 商品登録処理
public function register(Request $request)
{
    // 1. バリデーション
$validated = $request->validate([
    'name' => 'required',
    'price' => 'required|integer|min:0|max:10000',
    'description' => 'required|max:120',
    'season' => 'required|array',
    'image' => 'required|image|mimes:png,jpeg',
], [
    'name.required' => '商品名を入力してください',
    'price.required' => '値段を入力してください',
    'price.integer' => '数値で入力してください',
    'description.required' => '商品説明を入力してください',
    'description.max' => '120文字以内で入力してください',
    'season.required' => '季節を選択してください',
    'image.required' => '画像を選択してください',
    'image.mimes' => '｢.png｣または｢.jpeg｣形式でアップロードしてください',
    ]);
    // 2. 画像を保存
    $imageName = null;
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('public/images');
        $imageName = basename($path); 
    }
    // 2. 商品を保存
    $product = Product::create([
        'name' => $validated['name'],
        'price' => $validated['price'],
        'description' => $validated['description'],
        'image_path' => $imageName,
]);

// 3. 季節を紐づける
$product->seasons()->sync($validated['season'] ?? []);
    // 4. 一覧へリダイレクト
    return redirect()->route('products.index');
}

    // 商品更新処理
public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required',
        'price' => 'required|integer|min:0|max:10000',
        'description' => 'required|max:120',
        'season' => 'required|array',
        'image' => 'required|image|mimes:png,jpeg',
        ], [
    'name.required' => '商品名を入力してください',
    'price.required' => '値段を入力してください',
    'price.integer' => '数値で入力してください',
    'description.required' => '商品説明を入力してください',
    'description.max' => '120文字以内で入力してください',
    'season.required' => '季節を選択してください',
    'image.required' => '画像を選択してください',
    'image.mimes' => '｢.png｣または｢.jpeg｣形式でアップロードしてください',
    ]);

    $product = Product::findOrFail($id);

    // ★ Product テーブルに存在する項目だけ更新
    $product->name = $validated['name'];
    $product->price = $validated['price'];
    $product->description = $validated['description'];

    // ★ 新しい画像がアップロードされた場合のみ処理
    if ($request->hasFile('image')) {

        // ★ 古い画像を削除（余裕があれば）
        if ($product->image_path) {
            Storage::delete('public/images/' . $product->image_path);
        }

        // ★ 新しい画像を保存
        $path = $request->file('image')->store('public/images');
        $product->image_path = basename($path);
    }

    $product->save();

    // ★ 季節を更新
    $product->seasons()->sync($validated['season'] ?? []);

    return redirect()->route('products.detail', $id);
}
    // 商品検索
    public function search(Request $request)
    {
        return view('products.search');
    }

    // 商品削除
    public function delete($productId)
    {
        // 後で実装
    }
}
