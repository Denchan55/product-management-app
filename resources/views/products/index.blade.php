@extends('layouts.app')
@section('content')
    @vite('resources/css/app.css')

    <div class="w-full px-6">

        <div class="flex justify-between items-center mt-6 mb-8">
            <h2 class="text-3xl font-bold text-gray-800">
                商品一覧
            </h2>
            <a href="{{ route('products.register') }}"
                class="px-4 py-2 rounded-lg font-bold text-black bg-orange-400 hover:bg-yellow-300 transition">
                +商品を追加
            </a>
        </div>

        <div class="flex gap-1">

            {{-- 左：検索フォーム --}}
            <div class="w-1/5 pr-6">
                <form action="{{ route('products.index') }}" method="GET" class="flex flex-col gap-4 mb-8">

                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="商品名で検索"
                        class="border border-gray-300 rounded-3xl px-4 py-2">

                    <button class="btn btn-yellow w-full">
                        検索
                    </button>

                    <h2 class="text-lg font-semibold text-gray-700">
                        価格順で表示
                    </h2>

                    <select name="sort" class="border border-gray-300 rounded-md px-4 py-2">
                        <option value="">価格で並び替え</option>
                        <option value="high" {{ request('sort') == 'high' ? 'selected' : '' }}>高い順に表示</option>
                        <option value="low" {{ request('sort') == 'low' ? 'selected' : '' }}>低い順に表示</option>
                    </select>

                    @if (request('sort'))
                                    <div
                                        class="inline-flex items-center border border-yellow-400 rounded-full px-3 py-1 text-sm text-black bg-white mt-2">
                                        並び替え：{{ request('sort') === 'high' ? '高い順' : '低い順' }}

                                        <a href="{{ route('products.index', [
                            'keyword' => request('keyword'),
                            'sort' => null
                        ]) }}"
                                            class="ml-3 w-5 h-5 flex items-center justify-center bg-yellow-400 text-black rounded-full text-xs hover:bg-yellow-500">
                                            ×
                                        </a>
                                    </div>
                    @endif

                </form>
            </div>

            {{-- 右：カード一覧 --}}
            <div class="flex-1 w-full flex flex-col">
                <div class="flex-1 w-full">
                    <div class="grid grid-cols-3 gap-2">
                        @foreach ($products as $product)
                            <div class="bg-white border rounded-lg shadow-sm p-2 hover:shadow-md transition">

                                <a href="{{ route('products.detail', $product->id) }}">
                                    <img src="{{ asset('storage/images/' . $product->image_path) }}"
                                        class="w-full h-64 object-cover rounded-md mb-4 hover:opacity-90 transition">
                                </a>

                                <div class="flex justify-between items-center mt-2">
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        {{ $product->name }}
                                    </h3>

                                    <p class="text-gray-700 font-bold">
                                        ¥{{ number_format($product->price) }}
                                    </p>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        {{-- ページネーション（正しい位置） --}}
        <div class="mt-8">
            {{ $products->links('vendor.pagination.simple') }}
        </div>

    </div>
@endsection