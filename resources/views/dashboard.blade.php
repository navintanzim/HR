<x-layout>
    <s-page>
    <s-section>
      <s-badge tone="success" color="strong">Logged in successfully</s-badge>
      <h1>Welcome, {{ Auth::user()->name }}!</h1>
       <p>This is your dashboard.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
    </s-section>
  </s-page>

   
</x-layout>
