<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
@vite(["resources/css/app.css","resources/js/app.js"])        
    @stack('styles')
</head>

<body class="bg-[#05080a] min-h-screen text-gray-200 antialiased selection:bg-[#0070FF]/30">
    @include('components.navbar')

    <main class="p-6">
        @yield('content')
    </main>
    @include('components.footer')
</body>
</html>
