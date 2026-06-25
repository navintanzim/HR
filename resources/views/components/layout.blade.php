<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'My App' }}</title>
    <script src="https://cdn.shopify.com/shopifycloud/polaris.js"></script>
    @vite('resources/js/app.js')
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) dont use tailwind yet--> 
</head>

<body style="margin: 0;">

    <header style="background-color: #dcfce7; padding: 12px 24px; display: flex; align-items: center; justify-content: space-between; gap: 20px;">
        <div style="font-size: 1.125rem; font-weight: 700; white-space: nowrap;">
            Welcome to HR dashboard
        </div>

        <nav style="display: flex; justify-content: center; flex: 1;">
            <s-inline-stack spacing="loose">
                <a href="/dashboard" class="block rounded" style="padding: 50px;">Dashboard</a>
                <a href="/leaves" class="block rounded" style="padding: 50px;">Leaves</a>
                <a href="/attendance" class="block rounded" style="padding: 50px;">Attendance</a>

                @if(Auth::user()->role=='101')
                <a href="/settings" class="block p-2 hover:bg-gray-100 rounded" style="padding: 50px;">Settings</a>
                <a href="/users" class="block p-2 hover:bg-gray-100 rounded">Users</a>
                @endif
            </s-inline-stack>
        </nav>

        <div style="display: flex; justify-content: flex-end;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="padding: 8px 14px; border: 1px solid #86efac; border-radius: 8px; background-color: #ffffff; cursor: pointer;">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>


</body>

</html>
