<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;

class ProductController extends Controller
{
    // 商品一覧
public function index()
{
    $products = Product::all(); // DBから全件取得
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
    // 2. 商品を保存
    $product = Product::create([
        'name' => $validated['name'],
        'price' => $validated['price'],
        'description' => $validated['description'],
        'image_path' => '後で実装',
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

    // ★ 画像は後で実装
    // if ($request->hasFile('image')) { ... }

    $product->save();

    // ★ 季節は別テーブルなので sync
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
