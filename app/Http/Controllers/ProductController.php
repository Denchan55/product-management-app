<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;


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
public function register(StoreProductRequest $request)
{
    // バリデーション済みデータ
    $validated = $request->validated();

    // 画像保存
    $imageName = null;
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('public/images');
        $imageName = basename($path);
    }

    // 商品保存
    $product = Product::create([
        'name'        => $validated['name'],
        'price'       => $validated['price'],
        'description' => $validated['description'],
        'image_path'  => $imageName,
    ]);

    // 季節を紐づける
    $product->seasons()->sync($validated['season']);

    return redirect()->route('products.index');
}
    // 商品更新処理
public function update(UpdateProductRequest $request, $id)
{
    $validated = $request->validated();

    $product = Product::findOrFail($id);

    $product->name = $validated['name'];
    $product->price = $validated['price'];
    $product->description = $validated['description'];

    if ($request->hasFile('image')) {
        if ($product->image_path) {
            Storage::delete('public/images/' . $product->image_path);
        }

        $path = $request->file('image')->store('public/images');
        $product->image_path = basename($path);
    }

    $product->save();

    $product->seasons()->sync($validated['season']);

    return redirect()->route('products.index');
}


    // 商品検索
    public function search(Request $request)
    {
        return view('products.search');
    }

    // 商品削除
    public function delete($productId)
{
    $product = Product::findOrFail($productId);

    $product->seasons()->detach();

    Storage::delete('public/images/' . $product->image_path);
    // 本体の削除
    $product->delete();
    return redirect()->route('products.index');
}

}
