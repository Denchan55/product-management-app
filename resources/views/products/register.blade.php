<h1>商品登録</h1>

<form action="{{ route('products.register.post') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>商品名</label>
        <input type="text" name="name">
    </div>

    <div>
        <label>価格</label>
        <input type="number" name="price">
    </div>
    <div>
        <label>画像</label>
        <input type="file" name="image">
    </div>
    <div>
        <label>季節（複数選択可）</label><br>

        @foreach ($seasons as $season)
            <label>
                <input type="checkbox" name="season[]" value="{{ $season->id }}">
                {{ $season->name }}
            </label>
        @endforeach
    </div>

    <div>
        <label>説明</label>
        <textarea name="description"></textarea>
    </div>
    <button type="button" onclick="location.href='{{ route('products.index') }}'">戻る</button>
    <button type="submit">登録する</button>
</form>