<x-layout-login>
    @if (session('success'))
      <s-banner tone="success">
        {{ session('success') }}
      </s-banner>
      @endif

      @if (session('error'))
      <s-banner tone="critical">
        {{ session('error') }}
      </s-banner>
      @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input required type="email" name="email" placeholder="Email">
        <input required type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>
</x-layout-login>