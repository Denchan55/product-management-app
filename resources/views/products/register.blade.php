<h1>商品登録</h1>
@vite('resources/css/app.css')

<form action="{{ route('products.register.post') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label class="block font-bold">
            商品名 <span class="text-red-500">必須</span>
        </label>
        <input type="text" name="name" value="{{ old('name') }}" class="border p-2 w-full">
        @error('name')
            <div style="color:red;">{{ $message }}</div>
        @enderror

    </div>

    <div>
        <label class="block font-bold">
            値段 <span class="text-red-500">必須</span>
        </label>
        <input type="number" name="price" value="{{ old('price') }}" class="border p-2 w-full">
        @error('price')
            <div style="color:red;">
                <div>値段を入力してください</div>
                <div>数値で入力してください</div>
                <div>値段は0〜10000円以内で入力してください</div>
            </div>
        @enderror

    </div>
    <div>
        <label class="block font-bold">
            商品画像 <span class="text-red-500">必須</span>
        </label>
        <img id="preview" class="w-40 h-40 object-cover rounded-md mb-4" />
        <input type="file" id="image" name="image">
        @error('image')
            <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label class="block font-bold">
            季節（複数選択可）<span class="text-red-500">必須</span>
        </label>
        @foreach ($seasons as $season)
            <label>
                <input type="checkbox" name="season[]" value="{{ $season->id }}">
                {{ $season->name }}
            </label>
        @endforeach
        @error('season')
            <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label class="block font-bold">
            商品説明<span class="text-red-500">必須</span>
        </label>
        <textarea name="description" class="border p-2 w-full">{{ old('description') }}</textarea>
        @error('description')
            <div style="color:red;">
                <div>商品説明を入力してください</div>
                <div>120文字以内で入力してください</div>
            </div>
        @enderror
    </div>
    <button type="button" onclick="location.href='{{ route('products.index') }}'">戻る</button>
    <button type="submit">登録する</button>
</form>

<script>
    document.getElementById('image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');

        if (file) {
            preview.src = URL.createObjectURL(file);
        }
    });
</script>