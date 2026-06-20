<h1>商品一覧</h1>

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