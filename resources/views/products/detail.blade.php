<!-- <h1>商品詳細</h1> -->
@vite('resources/css/app.css')

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <a href="{{ route('products.index') }}">商品一覧</a> ＞ {{ $product->name }}

    <!-- 商品名 -->
    <p>商品名</p>
    <input type="text" name="name" value="{{ old('name', $product->name) }}">
    @error('name')
        <div style="color:red;">{{ $message }}</div>
    @enderror

    <!-- 値段 -->
    <p>値段</p>
    <input type="number" name="price" value="{{ old('price', $product->price) }}">
    @error('price')
        <div style="color:red;">
            <div>値段を入力してください</div>
            <div>数値で入力してください</div>
            <div>値段は0〜10000円以内で入力してください</div>
        </div>
    @enderror
    <!-- 季節チェックボックス -->
    <p>季節</p>
    @php
        $selectedSeasons = old('season', $product->seasons->pluck('id')->toArray());
        if (old('season') === null && $errors->has('season')) {
            $selectedSeasons = [];
        }
    @endphp
    @foreach ($seasons as $season)
        <label>
            <input type="checkbox" name="season[]" value="{{ $season->id }}" {{ in_array($season->id, $selectedSeasons) ? 'checked' : '' }}>
            {{ $season->name }}
        </label>
    @endforeach
    @error('season')
        <div style="color:red;">{{ $message }}</div>
    @enderror
    <!-- 画像 -->
    <img id="preview" src="{{ asset('storage/images/' . $product->image_path) }}" width="300">
    <input type="file" id="image" name="image">
    @error('image')
        <div style="color:red;">{{ $message }}</div>
    @enderror

    @error('image')
        <div style="color:red;">{{ $message }}</div>
    @enderror
    <!-- 説明 -->
    <p>商品説明</p>
    <textarea name="description" style="resize: none; width: 100%; height: 120px;">
    {{ old('description', $product->description) }}
</textarea>
    @error('description')
        <div style="color:red;">
            <div>商品説明を入力してください</div>
            <div>120文字以内で入力してください</div>
        </div>
    @enderror
    <a href="{{ route('products.index') }}">戻る</a>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <button type="submit">変更を保存</button>
    </form>
    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('削除しますか？')">
        @csrf
        @method('DELETE')
        <button type="submit" class="trash-button">🗑</button>
    </form>

</form>
<script>
    document.getElementById('image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('preview').src = URL.createObjectURL(file);
        }
    });
</script>