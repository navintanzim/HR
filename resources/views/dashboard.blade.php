<x-layout>
    <h1>Welcome, {{ Auth::user()->name }}!</h1>

    <p>This is your dashboard.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</x-layout>
