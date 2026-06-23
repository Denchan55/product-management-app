<h1>商品一覧</h1>
@vite('resources/css/app.css')

<a href="{{ route('products.register') }}" class="register-button">
    + 商品を追加
</a>

<form action="{{ route('products.index') }}" method="GET">
    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="商品名で検索">
    <button type="submit">検索</button>
    <h2>価格順で表示</h2>
    <select name="sort">
        <option value="">価格で並び替え</option>
        <option value="high" {{ request('sort') == 'high' ? 'selected' : '' }}>高い順に表示</option>
        <option value="low" {{ request('sort') == 'low' ? 'selected' : '' }}>低い順に表示</option>
    </select>
    @if (request('sort'))
        <div style="display:inline-block; padding:5px 10px; background:#eee; border-radius:5px; margin:10px 0;">
            並び替え：{{ request('sort') === 'high' ? '高い順' : '低い順' }}
            <!-- ×ボタン（sort を解除して再検索） -->
            <a href="{{ route('products.index', ['keyword' => request('keyword')]) }}"
                style="margin-left:10px; color:red; text-decoration:none;">
                ×
            </a>
        </div>
    @endif
</form>

@foreach ($products as $product)
    <div>
        <p>{{ $product->name }}</p>
        <p>{{ $product->price }}円</p>
        <a href="{{ route('products.detail', $product->id) }}">
            <img src="{{ asset('storage/images/' . $product->image_path) }}" width="150">
            <p>{{ $product->name }}</p>
        </a>

    </div>
@endforeach

{{ $products->links() }}