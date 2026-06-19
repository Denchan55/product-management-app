<h1>商品詳細</h1>

<h1>{{ $product->name }}</h1>

<img src="{{ asset('storage/images/' . $product->image_path) }}" width="300">
@foreach ($product->seasons as $season)
    {{ $season->name }}
@endforeach

<p>価格：{{ $product->price }}円</p>

<p>{{ $product->description }}</p>

<a href="{{ route('products.index') }}">一覧に戻る</a>