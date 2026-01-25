<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'My App' }}</title>
    <script src="https://cdn.shopify.com/shopifycloud/polaris.js" ></script>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-50 flex h-screen">

    
    <aside class="w-64 bg-white shadow-md border-r border-gray-200">
        <div class="p-4 font-bold text-lg border-b border-gray-200">
            Welcome to HR dashboard
        </div>
        <nav class="p-4 space-y-2">
            <s-stack>
      
    <a href="/dashboard" class="block p-2 hover:bg-gray-100 rounded">Dashboard</a>
    <a href="/leaves" class="block p-2 hover:bg-gray-100 rounded">Leaves</a>
    <a href="/attendance" class="block p-2 hover:bg-gray-100 rounded">Attendance</a>
    @if(Auth::user()->role=='101')
    <a href="/settings" class="block p-2 hover:bg-gray-100 rounded">Settings</a>
    @endif
    
    </s-stack>
        </nav>
    </aside>

   
    <main class="flex-1 overflow-auto p-6">
        {{ $slot }}
    </main>

</body>
</html>
