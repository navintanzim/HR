<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'My App' }}</title>
    <script src="https://cdn.shopify.com/shopifycloud/polaris.js"></script>
    @vite('resources/js/app.js')
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) dont use tailwind yet--> 
</head>

<body class="bg-gray-50 flex h-screen">


    <aside class="w-64 bg-white shadow-md border-r border-gray-200">
        <div class="p-4 font-bold text-lg border-b border-gray-200">
            Welcome to HR dashboard
        </div>

    </aside>


    <main class="">
        <nav class="p-4" style="display: flex;justify-content: center;margin: 10px;padding: 10px;">
            <s-inline-stack spacing="loose">
                <a href="/dashboard" class="block rounded" style="padding: 50px;">Dashboard</a>
                <a href="/leaves" class="block rounded" style="padding: 50px;">Leaves</a>
                <a href="/attendance" class="block rounded" style="padding: 50px;">Attendance</a>

                @if(Auth::user()->role=='101')
                <a href="/settings" class="block p-2 hover:bg-gray-100 rounded">Settings</a>
                @endif
            </s-inline-stack>
        </nav>

        {{ $slot }}
    </main>


</body>

</html>