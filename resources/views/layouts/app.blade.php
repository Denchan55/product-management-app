<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mogitate</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- ヘッダー --}}
    <header class="bg-white py-1">
        <div class="max-w-6xl px-6">
            <h1 class="text-3xl font-bold italic tracking-wide text-yellow-300">
                mogitate
            </h1>
        </div>
    </header>

    {{-- コンテンツ --}}
    <main class="flex-1 w-full">
        @yield('content')
    </main>

</body>

</html>