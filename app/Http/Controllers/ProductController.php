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
    $product = Product::findOrFail($id);
    return view('products.detail', compact('product'));
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
        'price' => 'required|integer',
        'description' => 'required',
        'season' => 'required|array', 
        'image' => 'required|image',
    ]);

    // 2. 商品を保存
    $product = Product::create([
        'name' => $validated['name'],
        'price' => $validated['price'],
        'description' => $validated['description'],
        'image_path' => '後で実装',
    ]);

// 3. 季節を紐づける
    $product->seasons()->sync($validated['season']);

    // 4. 一覧へリダイレクト
    return redirect()->route('products.index');
}

    // 商品更新フォーム
    public function showUpdate($productId)
    {
        return view('products.update');
    }

    // 商品更新処理
    public function update(Request $request, $productId)
    {
        // 後で実装
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
