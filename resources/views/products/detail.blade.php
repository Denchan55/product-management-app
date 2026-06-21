<h1>商品詳細</h1>

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

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
    <input type="file" name="image">
    @error('image')
        <div style="color:red;">{{ $message }}</div>
    @enderror
    <!-- 説明 -->
    <p>商品説明</p>
    <textarea name="description">{{ old('description', $product->description) }}</textarea>
    @error('description')
        <div style="color:red;">
            <div>商品説明を入力してください</div>
            <div>120文字以内で入力してください</div>
        </div>
    @enderror
    <a href="{{ route('products.index') }}">戻る</a>
    <button type="submit">変更を保存</button>
</form>