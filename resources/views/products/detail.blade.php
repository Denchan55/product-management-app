@extends('layouts.app')
@section('content')
    @vite('resources/css/app.css')

    <div class="w-full px-6 mt-6">
        <div class="max-w-4xl mx-auto">

            {{-- 更新フォーム --}}
            <form id="update-form" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- 1段目：パンくず + 画像 + 基本情報 --}}
                <div class="flex gap-10 mb-10">

                    {{-- 左：パンくず + 画像 --}}
                    <div class="w-1/2 flex flex-col">
                        <div class="mb-3 text-gray-600">
                            <a href="{{ route('products.index') }}" class="text-blue-500 hover:underline">商品一覧</a>
                            > {{ $product->name }}
                        </div>

                        <img id="preview" src="{{ asset('storage/images/' . $product->image_path) }}"
                            class="w-full rounded-lg shadow">

                        <input type="file" id="image" name="image" class="mt-3">
                        <x-error-message field="image" />
                    </div>

                    {{-- 右：商品名・値段・季節 --}}
                    <div class="w-1/2 flex flex-col gap-6">

                        {{-- 商品名 --}}
                        <div class="mt-8">
                            <p class="font-semibold mb-1">商品名</p>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                class="w-full border rounded px-3 py-2">
                            <x-error-message field="name" />
                        </div>

                        {{-- 値段 --}}
                        <div>
                            <p class="font-semibold mb-1">値段</p>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                class="w-full border rounded px-3 py-2">
                            <x-error-message field="price" />
                        </div>

                        {{-- 季節 --}}
                        <div>
                            <p class="font-semibold mb-1">季節</p>

                            @php
                                $selectedSeasons = old('season', $product->seasons->pluck('id')->toArray());
                                if (old('season') === null && $errors->has('season')) {
                                    $selectedSeasons = [];
                                }
                            @endphp

                            <div class="flex gap-10">
                                @foreach ($seasons as $season)
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" name="season[]" value="{{ $season->id }}"
                                            class="w-5 h-5 rounded-full border-2 border-gray-700
                                            appearance-none
                                            checked:bg-black checked:border-black
                                            checked:before:content-['✓']
                                            checked:before:text-white
                                            checked:before:flex checked:before:items-center checked:before:justify-center"
                                            {{ in_array($season->id, $selectedSeasons) ? 'checked' : '' }}>
                                        {{ $season->name }}
                                    </label>
                                @endforeach
                            </div>

                            <x-error-message field="season" />
                        </div>

                    </div>
                </div>

                {{-- 2段目：商品説明 --}}
                <div class="mb-8">
                    <p class="font-semibold mb-1">商品説明</p>
                    <textarea name="description"
                        class="w-full border rounded px-3 py-2 h-48 resize-none">{{ old('description', $product->description) }}</textarea>

                    <x-error-message field="description" />
                </div>

            </form> {{-- ★★★ 更新フォームここで閉じる（重要） ★★★ --}}

            {{-- 3段目：戻る・保存・削除 --}}
            <div class="flex items-center justify-between mt-10">

                {{-- 左：空 --}}
                <div class="w-1/3"></div>

                {{-- 中央：戻る・保存 --}}
                <div class="flex justify-center gap-6 w-1/3">
                    <a href="{{ route('products.index') }}"
                        class="min-w-[200px] px-6 py-3 bg-gray-300 text-black rounded hover:bg-gray-400 transition text-lg block mx-auto text-center">
                        戻る
                    </a>

                    {{-- ★ 保存ボタンはフォーム外 → form 属性で update-form を送信 --}}
                    <button form="update-form" type="submit"
                        class="min-w-[200px] px-6 py-3 text-lg bg-yellow-400 text-black rounded hover:bg-yellow-500 transition text-lg">
                        変更を保存
                    </button>
                </div>

                {{-- 右：削除 --}}
                <div class="w-1/3 flex justify-end">
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                        onsubmit="return confirm('削除しますか？')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                                <path
                                    d="M9 3a1 1 0 0 0-1 1v1H4v2h16V5h-4V4a1 1 0 0 0-1-1H9zm-3 6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V9H6zm5 2h2v8h-2v-8z" />
                            </svg>
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (event) {
                document.getElementById('preview').src = event.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>

@endsection
