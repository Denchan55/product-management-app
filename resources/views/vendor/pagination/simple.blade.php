@if ($paginator->hasPages())
    <nav class="flex justify-center mt-8">
        <ul class="inline-flex items-center space-x-2">

            {{-- 前へ --}}
            @if ($paginator->onFirstPage())
                <span
                    class="w-8 h-8 flex items-center justify-center bg-gray-100 border border-gray-300 rounded-full text-gray-400">＜</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="w-8 h-8 flex items-center justify-center bg-white border border-gray-300 rounded-full text-gray-700 hover:bg-gray-100">＜</a>
            @endif

            {{-- ページ番号 --}}
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span
                                class="w-8 h-8 flex items-center justify-center bg-yellow-300 border border-gray-300 rounded-full font-bold">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="w-8 h-8 flex items-center justify-center bg-white border border-gray-300 rounded-full text-gray-700 hover:bg-gray-100">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- 次へ --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="w-8 h-8 flex items-center justify-center bg-white border border-gray-300 rounded-full text-gray-700 hover:bg-gray-100">＞</a>
            @else
                <span
                    class="w-8 h-8 flex items-center justify-center bg-gray-100 border border-gray-300 rounded-full text-gray-400">＞</span>
            @endif


        </ul>
    </nav>
@endif