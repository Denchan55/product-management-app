@extends('layouts.app')
@section('content')
    @vite('resources/css/app.css')

    <div class="w-full px-6 mt-6">
        <div class="max-w-4xl mx-auto">

            <h1 class="text-3xl font-bold mb-6">商品登録</h1>

            <form action="{{ route('products.register.post') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- 商品名 --}}
                <div class="mb-6">
                    <label class="font-semibold mb-1 flex items-center gap-2">
                        商品名
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">必須</span>
                    </label>

                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2">

                    <x-error-message field="name" />
                </div>

                {{-- 値段 --}}
                <div class="mb-6">
                    <label class="font-semibold mb-1 flex items-center gap-2">
                        値段
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">必須</span>
                    </label>

                    <input type="number" name="price" value="{{ old('price') }}" class="w-full border rounded px-3 py-2">

                    <x-error-message field="price" />
                </div>

                {{-- 商品画像 --}}
                <div class="mb-6">
                    <label class="font-semibold mb-1 flex items-center gap-2">
                        商品画像
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">必須</span>
                    </label>

                    {{-- プレビュー画像 --}}
                    <img id="preview" class="w-64 h-64 object-cover rounded-md shadow mb-4 border" />

                    <input type="file" id="image" name="image">

                    <x-error-message field="image" />
                </div>

                {{-- 季節 --}}
                <div class="mb-6">
                    <label class="font-semibold mb-2 flex items-center gap-3">
                        <span class="flex items-center gap-2">
                            季節
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">必須</span>
                        </span>
                        <span class="text-red-500 text-sm">複数選択可</span>
                    </label>

                    <div class="flex gap-10">
                        @foreach ($seasons as $season)
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="season[]" value="{{ $season->id }}" class="w-5 h-5 rounded-full border-2 border-gray-700
                                            appearance-none
                                            checked:bg-black checked:border-black
                                            checked:before:content-['✓']
                                            checked:before:text-white
                                            checked:before:flex checked:before:items-center checked:before:justify-center">
                                {{ $season->name }}
                            </label>
                        @endforeach
                    </div>

                    <x-error-message field="season" />
                </div>

                {{-- 商品説明 --}}
                <div class="mb-6">
                    <label class="font-semibold mb-1 flex items-center gap-2">
                        商品説明
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">必須</span>
                    </label>

                    <textarea name="description"
                        class="w-full border rounded px-3 py-2 h-48 resize-none">{{ old('description') }}</textarea>

                    <x-error-message field="description" />
                </div>

                {{-- ボタン --}}
                <div class="flex items-center justify-between mt-10">

                    <div class="w-1/3"></div>

                    <div class="flex justify-center gap-6 w-1/3">
                        <a href="{{ route('products.index') }}"
                            class="min-w-[200px] px-6 py-3 bg-gray-300 text-black rounded hover:bg-gray-400 transition text-lg block mx-auto text-center">
                            戻る
                        </a>

                        <button type="submit"
                            class="min-w-[200px] px-6 py-3 bg-yellow-400 text-black rounded hover:bg-yellow-500 transition text-lg">
                            登録
                        </button>
                    </div>

                    <div class="w-1/3"></div>

                </div>

            </form>
        </div>
    </div>

    {{-- 画像プレビュー --}}
    <script>
        document.getElementById('image').addEventListener('change', function (e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview');

            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        });
    </script>

@endsection